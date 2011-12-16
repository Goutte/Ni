<?php    
class aPeopleSlotEditForm extends BaseForm
{
  // Ensures unique IDs throughout the page
  protected $id;
  public function __construct($id, $defaults = array(), $options = array(), $CSRFSecret = null)
  {
    $this->id = $id;
    parent::__construct($defaults, $options, $CSRFSecret);
  }
  public function configure()
  {
    $this->widgetSchema['people'] = new sfWidgetFormDoctrineChoice(array(
      'model' => 'aPerson',
      'order_by' => array('last_name', 'asc'),
      'multiple' => true, 
    ));
    $this->validatorSchema['people'] = new sfValidatorDoctrineChoice(array('model' => 'aPerson', 'multiple' => true));
    
    // Ensures unique IDs throughout the page. Hyphen between slot and form to please our CSS
    $this->widgetSchema->setNameFormat('slot-form-' . $this->id . '[%s]');
    
    // You don't have to use our form formatter, but it makes things nice
    $this->widgetSchema->setFormFormatterName('aAdmin');
  }
}
