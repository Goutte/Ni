<?php

class apostropheGeneratepeopleTask extends sfBaseTask
{
  protected function configure()
  {
    // You can add additional arguments here
    //$this->addArguments(array(
    //  new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    //));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('count', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', '100'),
      // You can add you own options here
    ));

    $this->namespace        = 'apostrophe';
    $this->name             = 'generate-people';
    $this->briefDescription = 'Populates project with a given number of test people.';
    $this->detailedDescription = <<<EOF
The [apostrophe:generate-people|INFO] task adds test people to the 'a_person' table so you can manage them at /admin/people.
Call it with:

  [php symfony apostrophe:generate-people|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // Initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $maleNames = $this->loadNamesFromCensusFile(sfConfig::get('sf_plugins_dir') . '/apostrophePeoplePlugin/data/dist.male.first');
    $femaleNames = $this->loadNamesFromCensusFile(sfConfig::get('sf_plugins_dir') . '/apostrophePeoplePlugin/data/dist.female.first');
    $lastNames = $this->loadNamesFromCensusFile(sfConfig::get('sf_plugins_dir') . '/apostrophePeoplePlugin/data/dist.all.last');

    $conn = Doctrine_Manager::connection();

    try
    {
      $conn->beginTransaction();

      for ($i = 0; $i < $options['count']; $i++)
      {
        $firstName = '';
        $middleName = '';
        $lastName = '';
        $salutation = '';
        $suffix = 'PhD, P Eng';
        $sex = '';
        $address_1 = '123 Marian St';
        $city = 'Philadelphia';
        $state = 'PA';
        $postalCode = '12345';
        $workPhone = '123-456-7890';
        $workFax = '987-654-3210';
        $body = 'This is where a bunch of information about this person would normally go.';
        $link = 'http://apostrophenow.com/';

        if (rand(0,1) == 1)
        {
          $firstName = $maleNames[rand(0, (count($maleNames) - 1))];
          $firstName = trim($firstName[0]);
          $firstName = ucfirst(strtolower($firstName));
          $middleName = $maleNames[rand(0, (count($maleNames) - 1))];
          $middleName = trim($middleName[0]);
          $middleName = ucfirst(strtolower($middleName));
          $sex = 'Male';
        }
        else
        {
          $firstName = $femaleNames[rand(0, (count($femaleNames) - 1))];
          $firstName = trim($firstName[0]);
          $firstName = ucfirst(strtolower($firstName));
          $middleName = $femaleNames[rand(0, (count($maleNames) - 1))];
          $middleName = trim($middleName[0]);
          $middleName = ucfirst(strtolower($middleName));
          $sex = 'Female';
        }
        
        $lastName = $lastNames[rand(0, (count($lastNames) - 1))];
        $lastName = trim($lastName[0]);
        $lastName = ucfirst(strtolower($lastName));
        
        $email = strtolower($firstName . '+' . rand(0, 100000) . '@example.com');

        $person = new aPerson();
        $person->first_name = $firstName;
        $person->middle_name = $middleName;
        $person->last_name = $lastName;
        $person->salutation = $salutation;
        $person->suffix = $suffix;
        $person->email = $email;
        $person->address_1 = $address_1;
        $person->city = $city;
        $person->state = $state;
        $person->postal_code = $postalCode;
        $person->work_phone = $workPhone;
        $person->work_fax = $workFax;
        $person->body = $body;
        $person->link = $link;
        $person->sex = $sex;
        $person->save();

        echo "Creating " . $person . "...\n";
      }

      $conn->commit();
    }
    catch (Exception $e)
    {
      $conn->rollback();
      var_dump($e->getMessage());
    }

  }

  public function loadNamesFromCensusFile($filename)
  {
    $data = file_get_contents($filename);
    $data = explode("\n", $data);

    foreach($data as &$row)
    {
      $row = preg_split('/\s+/', trim($row));
    }

    return $data;
  }
}
