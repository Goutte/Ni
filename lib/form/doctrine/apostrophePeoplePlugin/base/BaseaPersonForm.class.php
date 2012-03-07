<?php

/**
 * aPerson form base class.
 *
 * @method aPerson getObject() Returns the current form's model object
 *
 * @package    asandbox
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseaPersonForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'first_name'      => new sfWidgetFormInputText(),
      'middle_name'     => new sfWidgetFormInputText(),
      'last_name'       => new sfWidgetFormInputText(),
      'salutation'      => new sfWidgetFormInputText(),
      'suffix'          => new sfWidgetFormInputText(),
      'email'           => new sfWidgetFormInputText(),
      'address_1'       => new sfWidgetFormInputText(),
      'address_2'       => new sfWidgetFormInputText(),
      'city'            => new sfWidgetFormInputText(),
      'state'           => new sfWidgetFormInputText(),
      'postal_code'     => new sfWidgetFormInputText(),
      'work_phone'      => new sfWidgetFormInputText(),
      'work_fax'        => new sfWidgetFormInputText(),
      'body'            => new sfWidgetFormTextarea(),
      'link'            => new sfWidgetFormInputText(),
      'headshot_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Headshot'), 'add_empty' => true)),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
      'slug'            => new sfWidgetFormInputText(),
      'categories_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'aCategory')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'first_name'      => new sfValidatorString(array('max_length' => 255)),
      'middle_name'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_name'       => new sfValidatorString(array('max_length' => 255)),
      'salutation'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'suffix'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'           => new sfValidatorString(array('max_length' => 255)),
      'address_1'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'address_2'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'city'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'state'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'work_phone'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'work_fax'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'body'            => new sfValidatorString(array('required' => false)),
      'link'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'headshot_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Headshot'), 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
      'slug'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'categories_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'aCategory', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'aPerson', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('a_person[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'aPerson';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['categories_list']))
    {
      $this->setDefault('categories_list', $this->object->Categories->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCategoriesList($con);

    parent::doSave($con);
  }

  public function saveCategoriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['categories_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Categories->getPrimaryKeys();
    $values = $this->getValue('categories_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Categories', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Categories', array_values($link));
    }
  }

}
