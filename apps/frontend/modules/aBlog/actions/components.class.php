<?php

/**
 * aBlog Components.
 * 
 * @package    aBlogPlugin
 * @subpackage aBlog
 * @author     Your name here
 * @version    SVN: $Id: Components.class.php 12534 2008-11-01 13:38:27Z Kris.Wallsmith $
 */
class aBlogComponents extends BaseaBlogComponents
{
  public function executeTopbar()
  {
    $this->categories = $this->info['categoriesInfo'];
    $this->authors = $this->info['authors'];
    $this->tagsByPopularity = $this->info['tagsByPopularity'];
    $this->tagsByName = $this->info['tagsByName'];
    // What is this for?
    if($this->reset == true)
    {
      $this->params['cat'] = array();
      $this->params['tag'] = array();
    }
  }
}
