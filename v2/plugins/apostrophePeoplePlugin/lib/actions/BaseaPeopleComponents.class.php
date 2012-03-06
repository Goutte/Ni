<?php

/**
 * aPerson actions.
 *
 * @package    cs
 * @subpackage aPerson
 * @author     P'unk Avenue
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BaseaPeopleComponents extends sfComponents
{
	/**
   * Executes sidebar component
   *
   * Displays the Program links that are used to filter the Person in the content area.
   *
   * @param sfRequest $request A request object
   */
  public function executeSidebar(sfWebRequest $request)
  {
    $defaults = $this->getFilterDefaults();
    
    $this->form = new aPeopleCategoryForm($defaults);
    $this->actionUrl = url_for($request->getUri());

    $this->hasName = !empty($defaults['name']);
  }

  protected function getFilterDefaults()
  {
    $defaults = array();
    $defaults['categories'] = aPeopleTools::getAttribute('categories_filter', array());
    $defaults['name'] = aPeopleTools::getAttribute('name_filter', '');
    
    return $defaults;
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    $q = $this->q;
    // Matches middle names promiscuously if user types firstname lastname; also works around the lack of a space
    // between concatenated first and last name in the simplest way. There are other approaches but this works fine.
    // Don't make consecutive %'s, MySQL doesn't seem to mind much but why ask for trouble
    $q = preg_replace('/\s+/', '%', $q);
    $this->results = Doctrine::getTable('aPerson')->createQuery('p')->where('concat(coalesce(p.first_name, ""), coalesce(p.middle_name, ""), coalesce(p.last_name, "")) LIKE ?', "%$q%")->limit(10)->execute();
  }
}