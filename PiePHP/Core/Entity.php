<?php

namespace Core;

class Entity
{
  static $db;
  static $dbname;
  static $getvars;

  public function __construct($params = [])
  {
    self::get_db_name();
    self::$db = Database::connect();
    if (isset($params['id'])) { //read user info and create array
      $newparams = ORM::read(
        self::$dbname,
        [
          'WHERE' => [
            self::$dbname . ".id" => $params['id']
          ]
        ]
      );
      if (count($newparams) === 0) {
        echo 'This user doesnt exist';
        return;
      } else {
        self::createParam($newparams);
      }
    } else {
      self::createParam($params);
    }
    //RELATIONS
    if (isset($this->relations['hasmany']) && isset($this->id)) {
      for ($i = 0; $i < count($this->relations['hasmany']); $i++) {
        $this->{$this->relations['hasmany'][$i]['table']}[$i] = \Core\ORM::find(
          $this->relations['hasmany'][$i]['table'],
          [
            'WHERE' => [
              $this->relations['hasmany'][$i]['key'] => $this->id,
            ]
          ]
        );
      }
    }
    if (isset($this->relations['hasone']) && isset($this->id)) {
      for ($i = 0; $i < count($this->relations['hasone']); $i++) {
        //Alternative, faire une premiere requete pour recuperer le id de promo, puis chercher dans la table.
        //A continuer
        $ret = ORM::read($this->relations['hasone'][$i]['table']);

        //methode avec join
        $this->{$this->relations['hasone'][$i]['table']}[$i] = \Core\ORM::find(
          $this->relations['hasone'][$i]['table'],
          [
            'JOIN' => " JOIN " . self::$dbname  .  '_' . $this->relations['hasone'][$i]['table'] .
              " ON ( " . self::$dbname  .  '_' .  $this->relations['hasone'][$i]['table'] . '.' . $this->relations['hasone'][$i]['key'] . " = " .
              $this->relations['hasone'][$i]['table'] . ".id ) ",
            'WHERE' => [
              self::$dbname  .  '_' . $this->relations['hasone'][$i]['table'] . '.' . substr(self::$dbname, 0, -1) . '_id' => $this->id,
            ],
          ]
        );
      }
    }
    if (isset($this->relations['manytomany']) && isset($this->id)) {
      for ($i = 0; $i < count($this->relations['manytomany']); $i++) {
        $this->{$this->relations['manytomany'][$i]['table']}[$i] = \Core\ORM::find(
          $this->relations['manytomany'][$i]['table'],
          [
            'JOIN' => " JOIN " . self::$dbname  .  '_' . $this->relations['manytomany'][$i]['table'] .
              " ON ( " . self::$dbname  .  '_' .  $this->relations['manytomany'][$i]['table'] . '.' . $this->relations['manytomany'][$i]['key'] . " = " .
              $this->relations['manytomany'][$i]['table'] . ".id ) ",
          ]
        );
      }
    }
    self::$getvars = get_object_vars($this);
  }

  public function get_db_name()
  {
    self::$dbname = strtolower(preg_replace('/Model/', '', explode('\\', get_class($this))[1])) . 's';
  }

  public function createParam($arr)
  {
    foreach ($arr as $key => $value) {
      if (preg_match('/ /', $key)) {
        $this->{preg_replace('/ /', '_',  $key)} = $value; //defining my protected variables
      } else {
        $this->{$key} = $value; //defining my protected variables
      }
    }
  }

  //APPEL DES 5 KAGES
  public function modelCreate()
  {
    return \Core\ORM::create(self::$dbname, self::$getvars);
  }

  public function modelRead()
  {
    if (isset($this->relations) && is_array($this->relations) && count($this->relations) > 0) {
      $this->verifyRelations();
    }
    var_dump(self::$getvars);
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
    if (isset($this->relations) && is_array($this->relations) && count($this->relations) > 0) {
      $this->verifyRelations();
    }
    return \Core\ORM::find(self::$dbname, self::$getvars);
  }

  protected function verifyRelations()
  {
    if (isset($this->relations['hasone'])) {
      self::$getvars['hasone'] = $this->relations['hasone'];
    }
    if (isset($this->relations['hasmany'])) {
      self::$getvars['hasmany'] = $this->relations['hasmany'];
    }
    if (isset($this->relations['manytomany'])) {
      self::$getvars['manytomany'] = $this->relations['manytomany'];
    }
  }
}
