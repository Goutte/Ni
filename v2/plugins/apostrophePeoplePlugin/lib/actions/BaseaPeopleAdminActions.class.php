<?php

require_once dirname(__FILE__).'/../../modules/aPeopleAdmin/lib/aPeopleAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../../modules/aPeopleAdmin/lib/aPeopleAdminGeneratorHelper.class.php';

/**
 * person actions.
 *
 * @package    pennldi
 * @subpackage person
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseaPeopleAdminActions extends autoAPeopleAdminActions
{
  public function executeHeadshot(sfWebRequest $request)
  {
    $person = Doctrine::getTable('aPerson')->find($request->getParameter('id'));

    if ($request->hasParameter('aMediaUnset'))
    {
      $person->setHeadshotId(null);
      $person->save();
      return $this->redirect('aPeopleAdmin/index');
    }
    
    if (!$request->hasParameter('aMediaId') && !$request->getParameter('aMediaCancel'))
    {
      $url = 'aMedia/select?' .
        http_build_query(array(
          'engine-slug' => '/admin/media',
          'multiple' => false,
          'label' => 'Choose a person headshot', 
          'aMediaId' => $person->getHeadshotId(),
          'type' => 'image',
          // ACHTUNG: if you change this it must remain consistent with _headshot.php or you will get distortion
          'minimum-width' => 170,
          'minimum-height' => 200,
					'aspect-width' => 170, 
					'aspect-height' => 200,
          'after' => $this->getController()->genUrl('aPeopleAdmin/headshot?id='.$person->getId())
        ));

      return $this->executeMedia($request, $url);
    }
    elseif (!$request->getParameter('aMediaCancel'))
    {
      $person->setHeadshotId($request->getParameter('aMediaId'));
      $person->save();
      
      return $this->redirect('aPeopleAdmin/index');
    }

    return $this->redirect('aPeopleAdmin/index');
  }
  
  
  public function executeMedia(sfWebRequest $request, $url)
  {    
    $url = $this->getController()->genUrl($url);
    return $this->redirect($url);
  }
}
