<?php

class PluginaPeopleCategoryForm extends BaseForm
{
  public function  configure() {
    parent::configure();


    $categories = $this->getCategoryQuery()->fetchArray();

    $choices = array();

    foreach($categories as $id => $category)
    {
      $choices[$id] = $category['name'];
    }

    $this->widgetSchema['categories'] = new sfWidgetFormChoice(array('multiple' => true, 'choices' => $choices));
    $this->validatorSchema['categories'] = new sfValidatorChoice(array('choices' => array_keys($choices)));

    $this->widgetSchema['name'] = new sfWidgetFormInput(array(), array('class' => 'a-search-field'));
    $this->validatorSchema['name'] = new sfValidatorString();

    $this->widgetSchema->setNameFormat('aPeopleCategoryFilter[%s]');
  }

  public function getCategoryQuery()
  {
    return Doctrine_Query::create()
      ->from('aCategory INDEXBY id')
      ->select('name');
  }
}
