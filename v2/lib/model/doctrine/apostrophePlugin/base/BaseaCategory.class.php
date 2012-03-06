<?php

/**
 * BaseaCategory
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property Doctrine_Collection $MediaItems
 * @property Doctrine_Collection $Pages
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $Groups
 * @property Doctrine_Collection $BlogItems
 * @property Doctrine_Collection $CategoryUsers
 * @property Doctrine_Collection $CategoryGroups
 * @property Doctrine_Collection $aMediaItemToCategory
 * @property Doctrine_Collection $aPageToCategory
 * @property Doctrine_Collection $BlogItemCategories
 * @property Doctrine_Collection $aPerson
 * @property Doctrine_Collection $aPersonToACategory
 * 
 * @method integer             getId()                   Returns the current record's "id" value
 * @method string              getName()                 Returns the current record's "name" value
 * @method string              getDescription()          Returns the current record's "description" value
 * @method Doctrine_Collection getMediaItems()           Returns the current record's "MediaItems" collection
 * @method Doctrine_Collection getPages()                Returns the current record's "Pages" collection
 * @method Doctrine_Collection getUsers()                Returns the current record's "Users" collection
 * @method Doctrine_Collection getGroups()               Returns the current record's "Groups" collection
 * @method Doctrine_Collection getBlogItems()            Returns the current record's "BlogItems" collection
 * @method Doctrine_Collection getCategoryUsers()        Returns the current record's "CategoryUsers" collection
 * @method Doctrine_Collection getCategoryGroups()       Returns the current record's "CategoryGroups" collection
 * @method Doctrine_Collection getAMediaItemToCategory() Returns the current record's "aMediaItemToCategory" collection
 * @method Doctrine_Collection getAPageToCategory()      Returns the current record's "aPageToCategory" collection
 * @method Doctrine_Collection getBlogItemCategories()   Returns the current record's "BlogItemCategories" collection
 * @method Doctrine_Collection getAPerson()              Returns the current record's "aPerson" collection
 * @method Doctrine_Collection getAPersonToACategory()   Returns the current record's "aPersonToACategory" collection
 * @method aCategory           setId()                   Sets the current record's "id" value
 * @method aCategory           setName()                 Sets the current record's "name" value
 * @method aCategory           setDescription()          Sets the current record's "description" value
 * @method aCategory           setMediaItems()           Sets the current record's "MediaItems" collection
 * @method aCategory           setPages()                Sets the current record's "Pages" collection
 * @method aCategory           setUsers()                Sets the current record's "Users" collection
 * @method aCategory           setGroups()               Sets the current record's "Groups" collection
 * @method aCategory           setBlogItems()            Sets the current record's "BlogItems" collection
 * @method aCategory           setCategoryUsers()        Sets the current record's "CategoryUsers" collection
 * @method aCategory           setCategoryGroups()       Sets the current record's "CategoryGroups" collection
 * @method aCategory           setAMediaItemToCategory() Sets the current record's "aMediaItemToCategory" collection
 * @method aCategory           setAPageToCategory()      Sets the current record's "aPageToCategory" collection
 * @method aCategory           setBlogItemCategories()   Sets the current record's "BlogItemCategories" collection
 * @method aCategory           setAPerson()              Sets the current record's "aPerson" collection
 * @method aCategory           setAPersonToACategory()   Sets the current record's "aPersonToACategory" collection
 * 
 * @package    asandbox
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseaCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('a_category');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));

        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('aMediaItem as MediaItems', array(
             'refClass' => 'aMediaItemToCategory',
             'local' => 'category_id',
             'foreign' => 'media_item_id'));

        $this->hasMany('aPage as Pages', array(
             'refClass' => 'aPageToCategory',
             'local' => 'category_id',
             'foreign' => 'page_id'));

        $this->hasMany('sfGuardUser as Users', array(
             'refClass' => 'aCategoryUser',
             'local' => 'category_id',
             'foreign' => 'user_id'));

        $this->hasMany('sfGuardGroup as Groups', array(
             'refClass' => 'aCategoryGroup',
             'local' => 'category_id',
             'foreign' => 'group_id'));

        $this->hasMany('aBlogItem as BlogItems', array(
             'refClass' => 'aBlogItemToCategory',
             'local' => 'category_id',
             'foreign' => 'blog_item_id'));

        $this->hasMany('aCategoryUser as CategoryUsers', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('aCategoryGroup as CategoryGroups', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('aMediaItemToCategory', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('aPageToCategory', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('aBlogItemToCategory as BlogItemCategories', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $this->hasMany('aPerson', array(
             'refClass' => 'aPersonToACategory',
             'local' => 'category_id',
             'foreign' => 'person_id'));

        $this->hasMany('aPersonToACategory', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable();
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
    }
}