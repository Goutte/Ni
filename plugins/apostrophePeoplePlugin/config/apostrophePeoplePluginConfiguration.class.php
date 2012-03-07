<?php

class apostrophePeoplePluginConfiguration extends sfPluginConfiguration
{
  static $registered = false;
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    // Yes, this can get called twice. This is Fabien's workaround:
    // http://trac.symfony-project.org/ticket/8026
    
    if (!self::$registered)
    {
      $this->dispatcher->connect('a.migrateSchemaAdditions', array($this, 'migrate'));
      
      self::$registered = true;
    }
  }
  
  public function migrate($event)
  {
    $migrate = $event->getSubject();
    if (!$migrate->tableExists('a_person'))
    {
      $migrate->sql(array(
        'CREATE TABLE a_person (id BIGINT AUTO_INCREMENT, first_name VARCHAR(255) NOT NULL, middle_name VARCHAR(255), last_name VARCHAR(255) NOT NULL, salutation VARCHAR(255), suffix VARCHAR(255), email VARCHAR(255) NOT NULL, address_1 VARCHAR(255), address_2 VARCHAR(255), city VARCHAR(255), state VARCHAR(255), postal_code VARCHAR(255), work_phone VARCHAR(255), work_fax VARCHAR(255), body TEXT, link VARCHAR(255), headshot_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), UNIQUE INDEX a_person_sluggable_idx (slug), INDEX headshot_id_idx (headshot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;',
        'CREATE TABLE a_person_to_a_category (person_id BIGINT, category_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(person_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = INNODB;',
        'ALTER TABLE a_person ADD CONSTRAINT a_person_headshot_id_a_media_item_id FOREIGN KEY (headshot_id) REFERENCES a_media_item(id) ON DELETE SET NULL;',
        'ALTER TABLE a_person_to_a_category ADD CONSTRAINT a_person_to_a_category_person_id_a_person_id FOREIGN KEY (person_id) REFERENCES a_person(id) ON DELETE CASCADE;',
        'ALTER TABLE a_person_to_a_category ADD CONSTRAINT a_person_to_a_category_category_id_a_category_id FOREIGN KEY (category_id) REFERENCES a_category(id) ON DELETE CASCADE;'
      ));
    }
  }
}
