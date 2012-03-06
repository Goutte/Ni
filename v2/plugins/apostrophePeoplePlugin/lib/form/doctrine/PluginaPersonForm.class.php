<?php

/**
 * PluginaPerson form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginaPersonForm extends BaseaPersonForm
{
	public function setup()
	{
		parent::setup();

		$this->unsetFields();

    $this->widgetSchema->setFormFormatterName('aAdmin');

		$this->setWidget('body', new aWidgetFormRichTextarea(array('editor' => 'fck', 'height' => '300', 'width' => '500')));
		// For projects that need this column (most do not)
		if (isset($this['sex']))
		{
		  $this->setWidget('sex', new sfWidgetFormChoice(array('choices' => array('' => '', 'M' => 'Male', 'F' => 'Female'))));
		}
		$this->getWidget('categories_list')->setOption('query', Doctrine::getTable('aCategory')->createQuery()->orderBy('aCategory.name asc')); // Alphabetize categories dropdown

   	// Set labels for form elements
    $this->widgetSchema->setLabels(array(
      'first_name' => 'First Name:',
      'middle_name' => 'Middle Name:',
      'last_name' => 'Last Name:',
      'salutation' => 'Salutation:',
      'suffix' => 'Suffix:',
      'email' => 'Email Address:',
      'address_1' => 'Address (line 1):',
      'address_2' => 'Address (line 2):',
      'city' => 'City:',
      'state' => 'State:',
      'postal_code' => 'Zipcode:',
      'work_phone' => 'Phone Number:',
      'work_fax' => 'Fax Number:',
      'body' => 'About this Person:',
      'link' => 'Website:',
      'sex' => 'Gender:',
      'ethnicity' => 'Ethnicity:'
    ));

    // Set error messages for form elements
    $this->setValidator('first_name', new sfValidatorString(
      array('max_length' => 255, 'required' => true, 'trim' => true),
      array(
        'max_length' => 'Your first name must be shorter than %max_length% characters.',
        'required' => 'You must provide your first name.'
      )
    ));
    $this->setValidator('last_name', new sfValidatorString(
      array('max_length' => 255, 'required' => true, 'trim' => true),
      array(
        'max_length' => 'Your last name must be shorter than %max_length% characters.',
        'required' => 'You must provide your last name.'
      )
    ));
    $this->setValidator('email', new sfValidatorEmail(
      array('max_length' => 255, 'required' => true, 'trim' => true),
      array(
        'max_length' => 'Your email address must be shorter than %max_length% characters.',
        'required' => 'You must provide your email address.',
        'invalid' => 'Your email address must be of the form name@domain.ext'
      )
    ));
    $this->setValidator('postal_code', new sfValidatorInteger(
      array('max' => 99999, 'min' => 00000, 'required' => false, 'trim' => true),
      array(
        'max' => 'Your zip code must be 5 digits long.',
        'min' => 'Your zip code must be 5 digits long.',
        'invalid' => 'Your zip code must be composed of 5 digits.'
      )
    ));
    $this->setValidator('link', new aValidatorUrl(
      array('max_length' => 1024, 'required' => false, 'trim' => true),
      array(
        'max_length' => 'Your website URL must be shorter than %max_length% characters.',
        'invalid' => 'Your website URL must be of the form http://yourwebsite.ext'
      )
    ));
    if (isset($this['sex']))
    {
      $this->setValidator('sex', new sfValidatorChoice(
        array('choices' => array(0 => '', 1 => 'M', 2 => 'F'), 'required' => false),
        array(
          'invalid' => 'Please specify a valid gender by selecting an option from the dropdown menu.'
        )
      ));
    }
    $this->setValidator('body', new sfValidatorHtml(
      array('required' => false)
    ));
	}

	protected function unsetFields()
	{
	  // Don't show the following fields to the user
    unset(
      $this['headshot_id'], $this['created_at'],
      $this['updated_at'], $this['slug']
    );
	}

}
