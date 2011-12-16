<?php


abstract class PluginaPersonTable extends Doctrine_Table
{  
  public static function getInstance()
  {
		return Doctrine_Core::getTable('aPerson');
  }

  public function getAtoZ($category = null, $chars = null, $q = null)
  {
    if (is_null($chars))
    {
      $chars = range('A', 'Z');
    }
    else
    {
      if (!is_array($chars))
      {
        $chars = explode(',', $chars);
      }
    }
		if(is_null($q))
		{
			$q = Doctrine::getTable('aPerson')
	      ->createQuery('p');
		}

    $q->orderBy('last_name');


    $people = $q->execute();

    $peopleChars = array();
	  foreach ($chars as $char)
	  {
	    $peopleChars[$char] = array();
	    foreach ($people as $person)
	    {
	      $lastName = $person->getLastName();
	      if (strtoupper(substr($person->getLastName(), 0, 1)) == $char)
	      {
    	    $peopleChars[$char][] = $person;
	      }
	    }
	  }
	  return $peopleChars;
  }

  public function getTagsAtoZ($chars = null)
  {

    $tags = TagTable::getAllTagNameWithCount(null, array('model' => 'aPerson'));

	  foreach ($tags as $tag => $count)
	  {
	 		$tagChars[strtoupper(substr($tag,0,1))][] = $tag;
	  }
	  
	  return $tagChars;
  }
  
  public function getEngineCategories()
  {
    return aEngineTools::getEngineCategories('aPeople');
  }
}