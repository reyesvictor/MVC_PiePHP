<?php

namespace Core;

class Entity
{
  static $db;
  public $class;
  private $dbname;
  protected $email;
  protected $password;

  public function __construct($params = [])
  {
    self::get_db_name();
    self::$db = Database::connect();
    if (isset($params['id'])) {
      $newparams = ORM::read($this->dbname, $params['id']);
      self::createParam($newparams);
    } else {
      self::createParam($params);
      $this->orm = new \Core\ORM();
    }
  }

  public function get_db_name()
  {
    $this->dbname = strtolower(preg_replace('/Model/', '', explode('\\', get_class($this))[1])) . 's';
  }

  public function createParam($arr)
  {
    foreach ($arr as $key => $value) {
      $this->{$key} = $value; //defining my protected variables
    }
  }
}
