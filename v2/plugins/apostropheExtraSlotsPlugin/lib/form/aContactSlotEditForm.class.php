<?php    
class aContactSlotEditForm extends BaseForm
{
	  // Ensures unique IDs throughout the page
	  protected $id;
	  protected $soptions;

	  public function __construct($id, $soptions = array())
	  {
	    $this->id = $id;
	    $this->soptions = $soptions;
			$soptions['class'] = 'aNewButtonSlot';
	    $this->allowedTags = $this->consumeSlotOption('allowed-tags');
	    $this->allowedAttributes = $this->consumeSlotOption('allowed-attributes');
	    $this->allowedStyles = $this->consumeSlotOption('allowed-styles');
	    parent::__construct();
	  }

	  protected function consumeSlotOption($s)
	  {
	    if (isset($this->soptions[$s]))
	    {
	      $v = $this->soptions[$s];
	      unset($this->soptions[$s]);
	      return $v;
	    }
	    else
	    {
	      return null;
	    }
	  }

	  public function configure()
	  {
	    // ADD YOUR FIELDS HERE

	    $widgetOptions = array();
	    $tool = $this->consumeSlotOption('tool');
	    if (!is_null($tool))
	    {
	      $widgetOptions['tool'] = $tool;
	    }

	    $this->setWidgets(array(
				'description' => new aWidgetFormRichTextarea($widgetOptions, $this->soptions),
			));

	    $this->setValidators(array(
				'description' => new sfValidatorHtml(array('required' => false, 'allowed_tags' => $this->allowedTags, 'allowed_attributes' => $this->allowedAttributes, 'allowed_styles' => $this->allowedStyles)),
			));

	    // Ensures unique IDs throughout the page. Hyphen between slot and form to please our CSS
	    $this->widgetSchema->setNameFormat('slotform-' . $this->id . '-%s');

	    // You don't have to use our form formatter, but it makes things nice
	    $this->widgetSchema->setFormFormatterName('aAdmin');
	  }

	  public function validateUrl($validator, $value)
	  {
	    $url = $value;
	    // sfValidatorUrl doesn't accept mailto, deal with local URLs at all, etc.
	    // Let's take a stab at a more forgiving approach. Also, if the URL
	    // begins with the site's prefix, turn it back into a local URL just before
	    // save time for better data portability. TODO: let this stew a bit then
	    // turn it into a validator and use a form here
	    $prefix = sfContext::getInstance()->getRequest()->getUriPrefix();
	    if (substr($url, 0, 1) === '/')
	    {
	      $url = "$prefix$url";
	    }
	    // Borrowed and extended from sfValidatorUrl
	    if (!preg_match(  
	      '~^
	        (
	          (https?|ftps?)://                       # http or ftp (+SSL)
	          (
	            [\w\-\.]+             # a domain name (tolerate intranet short names)
	              |                                   #  or
	            \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
	          )
	          (:[0-9]+)?                              # a port (optional)
	          (/?|/\S+)                               # a /, nothing or a / with something
	          |
	          mailto:\S+
	        )
	      $~ix', $url))
	    {
	      throw new sfValidatorError($validator, 'invalid', array('value' => $url));
	    }
	    else
	    {
	      // Convert URLs back to local if they have the site's prefix
	      if (substr($url, 0, strlen($prefix)) === $prefix)
	      {
	        $url = substr($url, strlen($prefix));
	      }
	    }
	    return $url;
	  }
	}