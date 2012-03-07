<?php

/**
 * aPerson filter form base class.
 *
 * @package    asandbox
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseaPersonFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'middle_name'     => new sfWidgetFormFilterInput(),
      'last_name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'salutation'      => new sfWidgetFormFilterInput(),
      'suffix'          => new sfWidgetFormFilterInput(),
      'email'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'address_1'       => new sfWidgetFormFilterInput(),
      'address_2'       => new sfWidgetFormFilterInput(),
      'city'            => new sfWidgetFormFilterInput(),
      'state'           => new sfWidgetFormFilterInput(),
      'postal_code'     => new sfWidgetFormFilterInput(),
      'work_phone'      => new sfWidgetFormFilterInput(),
      'work_fax'        => new sfWidgetFormFilterInput(),
      'body'            => new sfWidgetFormFilterInput(),
      'link'            => new sfWidgetFormFilterInput(),
      'headshot_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Headshot'), 'add_empty' => true)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'            => new sfWidgetFormFilterInput(),
      'categories_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'aCategory')),
    ));

    $this->setValidators(array(
      'first_name'      => new sfValidatorPass(array('required' => false)),
      'middle_name'     => new sfValidatorPass(array('required' => false)),
      'last_name'       => new sfValidatorPass(array('required' => false)),
      'salutation'      => new sfValidatorPass(array('required' => false)),
      'suffix'          => new sfValidatorPass(array('required' => false)),
      'email'           => new sfValidatorPass(array('required' => false)),
      'address_1'       => new sfValidatorPass(array('required' => false)),
      'address_2'       => new sfValidatorPass(array('required' => false)),
      'city'            => new sfValidatorPass(array('required' => false)),
      'state'           => new sfValidatorPass(array('required' => false)),
      'postal_code'     => new sfValidatorPass(array('required' => false)),
      'work_phone'      => new sfValidatorPass(array('required' => false)),
      'work_fax'        => new sfValidatorPass(array('required' => false)),
      'body'            => new sfValidatorPass(array('required' => false)),
      'link'            => new sfValidatorPass(array('required' => false)),
      'headshot_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Headshot'), 'column' => 'id')),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'            => new sfValidatorPass(array('required' => false)),
      'categories_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'aCategory', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('a_person_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCategoriesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.aPersonToACategory aPersonToACategory')
      ->andWhereIn('aPersonToACategory.category_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'aPerson';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'first_name'      => 'Text',
      'middle_name'     => 'Text',
      'last_name'       => 'Text',
      'salutation'      => 'Text',
      'suffix'          => 'Text',
      'email'           => 'Text',
      'address_1'       => 'Text',
      'address_2'       => 'Text',
      'city'            => 'Text',
      'state'           => 'Text',
      'postal_code'     => 'Text',
      'work_phone'      => 'Text',
      'work_fax'        => 'Text',
      'body'            => 'Text',
      'link'            => 'Text',
      'headshot_id'     => 'ForeignKey',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
      'slug'            => 'Text',
      'categories_list' => 'ManyKey',
    );
  }
}
