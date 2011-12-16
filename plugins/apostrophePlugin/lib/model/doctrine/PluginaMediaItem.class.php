<?php
/**
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * @package    apostrophePlugin
 * @subpackage    model
 * @author     P'unk Avenue <apostrophe@punkave.com>
 */
abstract class PluginaMediaItem extends BaseaMediaItem
{

  /**
   * DOCUMENT ME
   * @param Doctrine_Connection $conn
   * @return mixed
   */
  public function save(Doctrine_Connection $conn = null)
  {
    $new = $this->isNew();
    if (!$this->getOwnerId())
    {
      if (sfContext::hasInstance())
      {
        $user = sfContext::getInstance()->getUser();
        if ($user->getGuardUser())
        {
          $this->setOwnerId($user->getGuardUser()->getId());
        }
      }
    }
    // Let the culture be the user's culture
    $result = aZendSearch::saveInDoctrineAndLucene($this, null, $conn);
    $crops = $this->getCrops();
    foreach ($crops as $crop)
    {
      $crop->setTitle($this->getTitle());
      $crop->setDescription($this->getDescription());
      $crop->setCredit($this->getCredit());
      $crop->save();
    }
    
    if ($new)
    {
      $event = new sfEvent($this, 'a.mediaAdded', array());
    }
    else
    {
      $event = new sfEvent($this, 'a.mediaEdited', array());
    }
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getEventDispatcher()->notify($event);
    }
    
    return $result;
  }

  /**
   * DOCUMENT ME
   * @param mixed $conn
   * @return mixed
   */
  public function doctrineSave($conn)
  {
    $result = parent::save($conn);
    return $result;
  }

  /**
   * DOCUMENT ME
   * @param Doctrine_Connection $conn
   * @return mixed
   */
  public function delete(Doctrine_Connection $conn = null)
  {
    $ret = aZendSearch::deleteFromDoctrineAndLucene($this, null, $conn);
    $this->clearImageCache();
    
    $this->deleteCrops();
    
    // Don't even think about trashing the original until we know
    // it's gone from the db and so forth
    if (!$this->isCrop())
    {
      unlink($this->getOriginalPath());
    }
    return $ret;
  }

  /**
   * DOCUMENT ME
   * @param mixed $conn
   * @return mixed
   */
  public function doctrineDelete($conn)
  {
    return parent::delete($conn);
  }

  /**
   * DOCUMENT ME
   */
  public function updateLuceneIndex()
  {
    aZendSearch::updateLuceneIndex(array('object' => $this, 'indexed' => array(
      'type' => $this->getType(),
      'title' => $this->getTitle(),
      'description' => $this->getDescription(),
      'credit' => $this->getCredit(),
      'categories' => implode(", ", $this->getCategoryNames()),
      'tags' => implode(", ", $this->getTags())
    )));
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getCategoryNames()
  {
    $categories = $this->getCategories();
    $result = array();
    foreach ($categories as $category)
    {
      $result[] = $category->getName();
    }
    return $result;
  }

  /**
   * Returns file path to the original. If this is a crop,
   * the true original's path is returned
   * @param mixed $format
   * @return mixed
   */
  public function getOriginalPath($format = false)
  {
    if ($format === false)
    {
      $format = $this->getFormat();
    }
    $slug = $this->getSlug();
    if (preg_match('/^([^\.]*)\.(.*)$/', $slug, $matches))
    {
      $slug = $matches[1];
    }
    $path = aMediaItemTable::getDirectory() . 
      DIRECTORY_SEPARATOR . $slug . ".original.$format";
    return $path;
  }

  /**
   * Remove both the pregenerated renders of the image at various sizes and
   * the cache information that says they are available. Remove the originals
   * too if specifically asked to do so
   */
  public function clearImageCache($deleteOriginals = false)
  {
    if (!$this->getId())
    {
      return;
    }
    $cache = aCacheTools::get('media');
    $cache->removePattern($this->getSlug() . ':*');
    // Use our wimpy implementation of glob that is stream wrapper friendly
    $cached = aFiles::glob(aMediaItemTable::getDirectory() . '/' . $this->getSlug() . ".*");
    foreach ($cached as $file)
    {
      if (!$deleteOriginals)
      {
        if (strpos($file, ".original.") !== false)
        {
          continue;
        }
      }
      unlink($file); 
    }
  }

  /**
   * Now accepts either a file path (for backwards compatibility)
   * or an aValidatedFile object (better, supports more formats; see
   * the import-files task for how to exploit this outside of a form)
   * @param mixed $file
   * @return mixed
   */
  public function preSaveFile($file)
  {
    if (is_object($file) && (get_class($file) === 'aValidatedFile'))
    {
      $this->format = $file->getExtension();
      if (strlen($this->format))
      {
        // Starts with a .
        $this->format = substr($this->format, 1);
      }
      $types = aMediaTools::getOption('types');
      foreach ($types as $type => $info)
      {
        $extensions = $info['extensions'];
        if (in_array($this->format, $extensions))
        {
          $this->type = $type;
        }
      }
      $file = $file->getTempName();
    }
    // Refactored into aImageConverter for easier reuse of this should-be-in-PHP functionality
    $info = aImageConverter::getInfo($file);
    if ($info)
    {
      // Sometimes we store formats we can't get dimensions for on this particular platform
      if (isset($info['width']))
      {
        $this->width = $info['width'];
      }
      if (isset($info['height']))
      {
        $this->height = $info['height'];
      }
      // Don't force this, but it's useful when not invoked
      // with an aValidatedFile object
      if (is_null($this->format))
      {
        $this->format = $info['format'];
      }
      $this->clearImageCache(true);
    }
    // Always return true - we store a lot of files now, not just images
    return true;
  }

  /**
   * Now accepts either a file path (for backwards compatibility)
   * or an aValidatedFile object (better, supports more formats; see
   * the import-files task for how to exploit this outside of a form)
   * @param mixed $file
   * @return mixed
   */
  public function saveFile($file)
  {
    if (!$this->width)
    {
      if (!$this->preSaveFile($file))
      {
        return false;
      }
    }
    if (is_object($file) && (get_class($file) === 'aValidatedFile'))
    {
      $file = $file->getTempName();
    }
    
    $path = $this->getOriginalPath($this->getFormat());
    $result = copy($file, $path);
    // What to do about crops of the old image? We used to delete them, but this 
    // causes user confusion. A better idea is to autocrop the center of the new 
    // image to the same dimensions. If this is not possible we do delete the crop
    // in question - otherwise we might be violating the original constraints,
    // which are not knowable at this stage (they are to be found in one or more
    // page templates that had a hand in causing this crop to exist)
    $this->fixCropsForNewDimensions();
    return $result;
  }

  /**
   * DOCUMENT ME
   * @param mixed $width
   * @param mixed $height
   * @param mixed $resizeType
   * @param mixed $format
   * @param mixed $absolute
   * @param mixed $wmode
   * @param mixed $autoplay
   * @param array $options
   * @return mixed
   */
  public function getEmbedCode($width, $height, $resizeType, $format = 'jpg', $absolute = false, $wmode = 'opaque', $autoplay = false, $options = array())
  {
    if ($height === false)
    {
      // We need to scale the height. That requires knowing the true height
      if (!$this->height)
      {
        // Not known yet. This comes up when previewing a video with a service URL that we haven't saved yet
        if ($this->service_url)
        {
          $service = aMediaTools::getEmbedService($this->service_url);
          $thumbnail = $service->getThumbnail($service->getIdFromUrl($this->service_url));
          if ($thumbnail)
          {
            $info = aImageConverter::getInfo($thumbnail);
            if (isset($info['width']))
            {
              $this->width = $info['width'];
              $this->height = $info['height'];
            }
          }
        }
      }
      $height = floor(($width * $this->height / $this->width) + 0.5); 
    }

    // Accessible alt title
    $title = htmlentities($this->getTitle(), ENT_COMPAT, 'UTF-8');
    if ($this->getEmbeddable())
    {
      if ($this->service_url)
      {
        $service = aMediaTools::getEmbedService($this->service_url);
        if (!$service)
        {
          // Most likely explanation: this service was configured, now it's not.
          // Don't crash
          return '<div>Video Service Not Available</div>';
        }
        return $service->embed($service->getIdFromUrl($this->service_url), $width, $height, $title, $wmode, $autoplay);
      }
      elseif ($this->embed)
      {
        // Solution for non-YouTube videos based on a manually
        // provided thumbnail and embed code
        return str_replace(array('_TITLE_', '_WIDTH_', '_HEIGHT_'),
          array($title, $width, $height, $wmode), $this->embed);
      }
      else
      {
        throw new sfException('Media item without an embed code or a service url');
      }
    }
    elseif (($this->getType() == 'image') || ($this->getType() == 'pdf'))
    {
      // Use named routing rule to ensure the desired result (and for speed)
      return "<img alt=\"$title\" width=\"$width\" height=\"$height\" src='" . htmlspecialchars($this->getImgSrcUrl($width, $height, $resizeType, $format, $absolute, $options)) . "' />";
    }
    else
    {
      throw new Exception("Unknown media type in getEmbedCode: " . $this->getType() . " id is " . $this->id . " is new? " . $this->isNew());
    }
  }

  /**
   * @param mixed $width
   * @param mixed $height
   * @param mixed $resizeType
   * @param mixed $format
   * @param mixed $absolute
   * @param array $options
   * @return string (URL)
   * A bc wrapper around getScaledUrl 
   */
  public function getImgSrcUrl($width, $height, $resizeType, $format = 'jpg', $absolute = false, $options = array())
  {
    /**
     * This is now a wrapper around getScaledUrl
     */
    return $this->getScaledUrl(array_merge(array('width' => $width, 'height' => $height, 'format' => $format, 'resizeType' => $resizeType, 'absolute' => $absolute), $options));
  }

  /**
   * DOCUMENT ME
   * @param mixed $url
   * @return mixed
   */
  protected function youtubeUrlToEmbeddedUrl($url)
  {
    $url = str_replace("/watch?v=", "/v/", $url);
    $url .= "&fs=1";
    return $url;
  }

  /**
   * DOCUMENT ME
   * @param mixed $privilege
   * @param mixed $user
   * @return mixed
   */
  public function userHasPrivilege($privilege, $user = false)
  {
    if ($user === false)
    {
      $user = sfContext::getInstance()->getUser();
    }
    if ($privilege === 'view')
    {
      if ($this->getViewIsSecure())
      {
        if (!$user->isAuthenticated())
        {
          return false;
        }
      }
      return true;
    }
    if ($user->hasCredential(aMediaTools::getOption('admin_credential')))
    {
      return true;
    }
    $guardUser = $user->getGuardUser();
    if (!$guardUser)
    {
      return false;
    }
    if ($this->getOwnerId() === $guardUser->getId())
    {
      return true;
    }
    return false;
  }

  /**
   * Returns a complete URL to the media item. This URL may point to a Symfony action that will
   * generate the image on the fly, or directly to a previously generated image.
   * 
   * @param mixed $options
   * @return mixed
   */
  public function getScaledUrl($options)
  {
    // Implement flexible height
    if ($options['height'] == 0)
    {
      $options['height'] = floor(($options['width'] * $this->height / $this->width) + 0.5); 
    }

    $absolute = isset($options['absolute']) && $options['absolute'];

    $options = aDimensions::constrain($this->getWidth(), $this->getHeight(), $this->getFormat(), $options);
    $params = array("width" => $options['width'], "height" => $options['height'], 
      "resizeType" => $options['resizeType'], "format" => $options['format'], 'absolute' => $absolute);

    // check for null because 0 is valid
    if (!is_null($options['cropLeft']) && !is_null($options['cropTop']) && !is_null($options['cropWidth']) && !is_null($options['cropHeight']))
    {      
      $params = array_merge(
        $params,
        array("cropLeft" => $options['cropLeft'], "cropTop" => $options['cropTop'],
          "cropWidth" => $options['cropWidth'], "cropHeight" => $options['cropHeight'])
      );
    }
    
    // If the image is already generated point to it directly, don't do
    // an unnecessary redirect
    
    $result = $this->render(array_merge($params, array('cachedOnly' => true, 'authorize' => true)));
    if (is_array($result))
    {
      return $result['url'];
    }
    else
    {
      throw new sfException('Unable to render image');
    }    
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getCropThumbnailUrl()
  {    
    $selectedConstraints = aMediaTools::getOption('selected_constraints');
    
    if ($aspectRatio = aMediaTools::getAspectRatio()) // this returns 0 if aspect-width and aspect-height were not set
    {
      // Allow for either the width or the height to be flex
      if (isset($selectedConstraints['height']) && ($selectedConstraints['height'] !== false))
      {
        $selectedConstraints = array_merge(
          $selectedConstraints, 
          array('width' => floor($selectedConstraints['height'] * $aspectRatio))
        );
      }
      else
      {
        $selectedConstraints = array_merge(
          $selectedConstraints, 
          array('height' => floor($selectedConstraints['width'] / $aspectRatio))
        );
      }
    }
    
    
    $imageInfo = aMediaTools::getAttribute('imageInfo');

    if (isset($imageInfo[$this->id]['cropLeft']) &&
        isset($imageInfo[$this->id]['cropTop']) && isset($imageInfo[$this->id]['cropWidth']) && isset($imageInfo[$this->id]['cropHeight']))
    {
      $selectedConstraints = array_merge(
        $selectedConstraints, 
        array(
          'cropLeft' => $imageInfo[$this->id]['cropLeft'],
          'cropTop' => $imageInfo[$this->id]['cropTop'],
          'cropWidth' => $imageInfo[$this->id]['cropWidth'],
          'cropHeight' => $imageInfo[$this->id]['cropHeight']
        )
      );
    }
    
    return $this->getScaledUrl($selectedConstraints);
  }

  /**
   * Crops of other images have periods in the slug. Real slugs are always [\w_]+ (well, the i18n equivalent)
   * @return mixed
   */
  public function isCrop()
  {
    return (strpos($this->slug, '.') !== false);
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getCrops()
  {
    // This should perform well because there is an index on the slug and
    // indexes are great with prefix queries
    return $this->getTable()->createQuery('m')->where('m.slug LIKE ?', array($this->slug . '.%'))->execute();
    
  }

  /**
   * The image has been replaced with another image. Look at all existing crops of the
   * old image. Autocrop the center of the new image to the same dimensions. If this is 
   * not possible we drop the crop in question. Less disruptive than the old 
   * "drop all the crops when changing the image" policy
   */
  public function fixCropsForNewDimensions()
  {
    $crops = $this->getCrops();
    foreach ($crops as $crop)
    {
      $info = $crop->getCroppingInfo();
      if (!isset($info['cropWidth']))
      {
        continue;
      }
      $width = $info['cropWidth'];
      $height = $info['cropHeight'];
      if (($width > $this->width) || ($height > $this->height))
      {
        $crop->delete();
      }
      else
      {
        $info['cropLeft'] = floor(($this->width - $width) / 2);
        $info['cropTop'] = floor(($this->height - $height) / 2);
        $crop->slug = $this->formatCropSlug($info);
        $crop->save();
      }
    }
  }

  public function formatCropSlug($info)
  {
    return $this->slug . '.' . $info['cropLeft'] . '.' . $info['cropTop'] . '.' . $info['cropWidth'] . '.' . $info['cropHeight'];
  }
  
  /**
   * Remove all aMediaItem objects that are just cropping dimensions referring
   * back to this same object
   */
  public function deleteCrops()
  {
    $crops = $this->getCrops();
    // Let's make darn sure the PHP stuff gets called rather than using a delete all trick of some sort
    foreach ($crops as $crop)
    {
      $crop->delete();
    }
  }

  /**
   * DOCUMENT ME
   * @param mixed $info
   * @return mixed
   */
  public function findOrCreateCrop($info)
  {
    $slug = $this->formatCropSlug($info);
    $crop = $this->getTable()->findOneBySlug($slug);
    if (!$crop)
    {
      $crop = $this->copy(false);
      $crop->slug = $slug;
      $crop->width = $info['cropWidth'];
      $crop->height = $info['cropHeight'];
    }
    return $crop;
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getCroppingInfo()
  {
    $p = preg_split('/\./', $this->slug);
    if (count($p) === 5)
    {
      // Without the casts JSON won't give integers to JavaScript see #640
      return array('cropLeft' => (int) $p[1], 'cropTop' => (int) $p[2], 'cropWidth' => (int) $p[3], 'cropHeight' => (int) $p[4]);
    }
    else
    {
      return array();
    }
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getCropOriginal()
  {
    if (!$this->isCrop())
    {
      return $this;
    }
    $p = preg_split('/\./', $this->slug);
    return $this->getTable()->findOneBySlug($p[0]);
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getDownloadable()
  {
    $type = aMediaTools::getTypeInfo($this->type);
    return $type['downloadable'];
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getEmbeddable()
  {
    $type = aMediaTools::getTypeInfo($this->type);
    return $type['embeddable'];
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getImageAvailable()
  {
    // All that has to happen is we have an original (sometimes it's a thumbnail of a video) and therefore a format AND
    // a width. We used to check width alone, however width is set even for dumb video embeds now, and non-image files
    // have a format but no width
    return $this->width && strlen($this->format);
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function getCroppable()
  {
    // Right now images are always croppable and nothing else is
    return ($this->type === 'image');
  }

  /**
   * Returns categories that were added to this object by someone else which this user
   * is not eligible to remove
   * @return mixed
   */
  public function getAdminCategories()
  {
    $reserved = array();
    $existing = Doctrine::getTable('aCategory')->createQuery('c')->select('c.*')->innerJoin('c.MediaItems mi WITH mi.id = ?', $this->id)->execute();
    $categoriesForUser = aCategoryTable::getInstance()->addCategoriesForUser(sfContext::getInstance()->getUser()->getGuardUser(), $this->isAdmin())->execute();
    $ours = array_flip(aArray::getIds($categoriesForUser));
    foreach ($existing as $category)
    {
      if (!isset($ours[$category->id]))
      {
        $reserved[] = $category;
      }
    }
    return $reserved;
  }

  /**
   * DOCUMENT ME
   * @return mixed
   */
  public function isAdmin()
  {
    return sfContext::getInstance()->getUser()->hasCredential(aMediaTools::getOption('admin_credential'));
  }

  /**
   * Render an image with the specified width, height, resizeType, format and optionally cropLeft, cropTop, cropWidth and cropHeight.
   * Renders to the appropriate backend storage and returns an array with url, path (in filesystem), size and contentType keys
   * (contentType is ready for the Content-type: header). First checks the cache for a previous authorization to do so, if there
   * is no authorization returns false (this prevents DOS attacks). If the cachedOnly option is true, returns previously
   * rendered images but does not attempt to render new ones. If the authorize option is true, stores an authorization in the cache
   * allowing a future success to successfully render, returns an array containing only the 'url' key and renders nothing now 
   * (however if the image is already rendered a complete array is returned immediately).
   */
  public function render($options)
  {
    $absolute = isset($options['absolute']) && $options['absolute'];
    unset($options['absolute']);
    $width = ceil($options['width']) + 0;
    $height = ceil($options['height']) + 0;
    $format = $options['format'];
    $resizeType = $options['resizeType'];
    $mimeTypes = aMediaTools::getOption('mime_types');
    if (!isset($mimeTypes[$format]))
    {
      return false;
    }
    $contentType = $mimeTypes[$format];
    if (($resizeType !== 'c') && ($resizeType !== 's'))
    {
      return false;
    }

    $slug = $this->getSlug();
    
    // If this is a cropped version of another image, discover the real slug, and
    // get the crop parameters out and make them the defaults. (This used to be done for
    // us by a route, but now we generate images at page rendering time so that we have
    // a chance to talk to external storage like S3.)
    if (preg_match('/^([^\.]*)\.(.*)$/', $slug, $matches))
    {
      $slug = $matches[1];
      list($cropLeft, $cropTop, $cropWidth, $cropHeight) = preg_split('/\./', $matches[2]);
      $options = array_merge(array('cropLeft' => $cropLeft, 'cropTop' => $cropTop, 'cropWidth' => $cropWidth, 'cropHeight' => $cropHeight), $options);
    }

    $cropTop = isset($options['cropTop']) ? $options['cropTop'] : null;
    $cropLeft = isset($options['cropLeft']) ? $options['cropLeft'] : null;
    $cropWidth = isset($options['cropWidth']) ? $options['cropWidth'] : null;
    $cropHeight = isset($options['cropHeight']) ? $options['cropHeight'] : null;
    
    if (!is_null($cropWidth) && !is_null($cropHeight) && !is_null($cropLeft) && !is_null($cropTop))
    {
      $cropLeft = ceil($cropLeft + 0);
      $cropTop = ceil($cropTop + 0);
      $cropWidth = ceil($cropWidth + 0);
      $cropHeight = ceil($cropHeight + 0);
      // Explicit cropping always preempts any automatic cropping, so there's no difference between c and s,
      // and only the cropOriginal method actually supports cropping parameters, so...
      $resizeType = 'c';
      $suffix = ".$cropLeft.$cropTop.$cropWidth.$cropHeight.$width.$height.$resizeType.$format";
    }
    else
    {  
      $cropLeft = null;
      $cropTop = null;
      $cropWidth = null;
      $cropHeight = null;
      $suffix = ".$width.$height.$resizeType.$format";
    }
    $basename = "$slug$suffix";
    // The : is a namespace separator for the cache so we can removePattern later
    $cacheKey = "$slug:$suffix";

    // Local URL, used if we need to generate the image in response
    // to a later request (pausing execution of the page is no good)
    $request = sfContext::getInstance()->getRequest();
    
    // We need to use actual routing for these because otherwise folks who have
    // overridden the routes to alter their paths will not get the expected result
    if (!is_null($cropLeft))
    {
      $params = array('slug' => $slug, 'width' => $width, 'height' => $height, 'cropLeft' => $cropLeft, 'cropTop' => $cropTop, 'cropWidth' => $cropWidth, 'cropHeight' => $cropHeight, 'format' => $format, 'resizeType' => $resizeType, 'sf_route' => 'a_media_image_cropped');
      $localUrl = sfContext::getInstance()->getController()->genUrl($params);
    }
    else
    {
      $params = array('slug' => $slug, 'width' => $width, 'height' => $height, 'format' => $format, 'resizeType' => $resizeType, 'sf_route' => 'a_media_image');
      $localUrl = sfContext::getInstance()->getController()->genUrl($params);
    }

    // The final URL, in the cloud (if we're not just storing locally)
    if (sfConfig::get('app_a_static_url') || sfConfig::get('app_aMedia_static_url'))
    {
      $url = aMediaItemTable::getUrl() . '/' . $basename;
    }
    else
    {
      // Non-cloud sites don't need to fuss with this
      $url = $localUrl;
    }
    
    // $sf_relative_url_root = $request->getRelativeUrlRoot();
    // $localUrl = $sf_relative_url_root . '/uploads/media_items/' . $basename;
    
    $cache = aCacheTools::get('media');
    $cached = $cache->get($cacheKey);
    if (!$cached)
    {
      // This is just a request to generate the image in response to a separate HTTP request later
      // (eg via img src) so we don't pause the page render. Let the cache know this is a
      // legitimately requested size, then return the URL only since the actual generation
      // hasn't happened yet
      if (isset($options['authorize']) && $options['authorize'])
      {
        $cache->set($cacheKey, serialize(array('authorized' => true)));

        $url = $localUrl;
        if ($absolute)
        {
          $url = $this->makeMediaUrlAbsolute($url);      
        }
        return array('url' => $url);
      }
      // There is no mention of this image in the cache yet, therefore we have no
      // authorization to generate it
      return false;
    }
    $result = unserialize($cached);
    
    // Image is already rendered
    if (isset($result['url']) && $result['url'])
    {
      if ($absolute)
      {
        $result['url'] = $this->makeMediaUrlAbsolute($result['url']);      
      }
      return $result;
    }

    // Not rendered yet, but at least authorized, so if our goal was to authorize
    // and generate later we should return the URL at this point
    if (isset($options['authorize']) && $options['authorize'])
    {
      $url = $localUrl;
      $result = array('url' => $url);
      if ($absolute)
      {
        $result['url'] = $this->makeMediaUrlAbsolute($result['url']);      
      }
      return $result;
    }
    

    // We are only interested if the image is already rendered
    if (isset($options['cachedOnly']) && $options['cachedOnly'])
    {
      // We're just looking for a pregenerated image and don't want to wait to
      // generate a new one right now
      return false;
    }

    // We can generate the image now only if there's an authorization to do so
    // in the cache (from a legitimate page render that really needs it)
    if (!(isset($result['authorized']) && $result['authorized']))
    {
      return false;
    }
    
    $path = aMediaItemTable::getDirectory() . '/' . $basename;

    if (!file_exists($path))
    {
      $originalFormat = $this->getFormat();
      if ($resizeType === 'c')
      {
        $method = 'cropOriginal';
      }
      else
      {
        $method = 'scaleToFit';
      }
      aImageConverter::$method(
        $this->getOriginalPath(), 
        $path,
        $width,
        $height,
        sfConfig::get('app_aMedia_jpeg_quality', 75),
        $cropLeft,
        $cropTop,
        $cropWidth,
        $cropHeight);
    }
    $result = array('url' => $url, 'path' => $path, 'contentType' => $contentType, 'size' => filesize($path));
    $cache->set($cacheKey, serialize($result), 86400 * 365);
    if ($absolute)
    {
      $result['url'] = $this->makeMediaUrlAbsolute($result['url']);      
    }
    return $result;
  }
  
  protected function makeMediaUrlAbsolute($url)
  {
    if (substr($url, 0, 1) === '/')
    {
      $url = sfContext::getInstance()->getRequest()->getUriPrefix() . $url;
    }
    return $url;
  }
}
