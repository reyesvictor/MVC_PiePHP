<?php

namespace Core;

class Entity
{
  static $db;
  public $class;
  protected $email;
  protected $password;

  public function __construct($params = [])
  {
    // $this->class =  "\\" . get_class($this);
    self::$db = Database::connect();
    if (isset($params['id'])) {
      $newparams = ORM::read('users', $params['id']);
      self::createParam($newparams);
    } else {
      self::createParam($params);
      $this->orm = new \Core\ORM();
    }
  }

  public function createParam($arr)
  {
    foreach ($arr as $key => $value) {
      $this->{$key} = $value; //defining my protected variables
    }
  }
}