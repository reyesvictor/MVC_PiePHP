<?php

namespace Core;

class Entity
{
  static $db;
  static $dbname;
  static $getvars;
  static $id;
  private static $relations;

  public function __construct($params = [])
  {
    self::get_db_name();
    self::$db = Database::connect();
    if (isset($params['id'])) { //read user info and create array
      $newparams = ORM::read(self::$dbname, $params['id']);
      self::createParam($newparams);
    } else {
      self::createParam($params);
    }
    self::$getvars = get_object_vars($this);
    echo '--------<pre></br>';
    var_dump(self::$getvars);
    echo '--------</br></pre>';
  }

  public function get_db_name()
  {
    self::$dbname = strtolower(preg_replace('/Model/', '', explode('\\', get_class($this))[1])) . 's';
  }

  public function createParam($arr)
  {
    foreach ($arr as $key => $value) {
      if ( $key == 'relations' ) {
        self::$relations = $value;
      } else if ( preg_match('/ /', $key) ) {
        $this->{preg_replace('/ /', '_',  $key)} = $value; //defining my protected variables
      } else {
        $this->{$key} = $value; //defining my protected variables
      }
    }
  }

  //APPEL DES 5 KAGES
  public function modelCreate()
  {
    return self::$id = \Core\ORM::create(self::$dbname, self::$getvars);
  }

  public function modelRead()
  {
    if ( is_array(self::$relations) && count(self::$relations) == 2) {
      self::$getvars['hasmany'] = self::$relations['hasmany'];
      self::$getvars['hasone'] = self::$relations['hasone'];
    }
    return \Core\ORM::read(self::$dbname, self::$getvars);
  }

  public function modelRead_all()
  {
    return \Core\ORM::read_all(self::$dbname);
  }

  public function modelUpdate()
  {
    return \Core\ORM::update(self::$dbname, self::$getvars);
  }

  public function modelDelete()
  {
    return \Core\ORM::delete(self::$dbname, self::$getvars);
  }

  public function modelFind()
  {
    if ( is_array(self::$relations) && count(self::$relations) == 2) {
      self::$getvars['hasmany'] = self::$relations['hasmany'];
      self::$getvars['hasone'] = self::$relations['hasone'];
    }
    return \Core\ORM::find(self::$dbname, self::$getvars);
  }
}
