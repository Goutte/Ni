<?php

/**
 * @package apostrophePeoplePlugin
 * @subpackage toolkit
 * @author P'unk Avenue <apostrophe.punkave.com>
 */

class BaseaPeopleTools
{

  /**
   * DOCUMENT ME
   * @return mixed
   */
  static protected function getUser()
  {
    return sfContext::getInstance()->getUser();
  }

  /**
   * DOCUMENT ME
   * @param mixed $attribute
   * @param mixed $default
   * @return mixed
   */
  static public function getAttribute($attribute, $default = null)
  {
    $attribute = "aPeople-$attribute";
    return aPeopleTools::getUser()->getAttribute($attribute, $default, 'apostrophe');
  }

  /**
   * DOCUMENT ME
   * @param mixed $attribute
   * @param mixed $value
   */
  static public function setAttribute($attribute, $value = null)
  {
    $attribute = "aPeople-$attribute";
    aPeopleTools::getUser()->setAttribute($attribute, $value, 'apostrophe');
  }

}