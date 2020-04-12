<?php

namespace Core;

class ORM
{

  static $t;
  static $v;
  static $u;
  static $arr;
  static $where;
  static $fields;

  //Les 5 KAGES
  public static function create($table, $fields) //return last id
  {
    if ( isset(\Core\Request::$post) ) {
      unset($fields['relations']);
      unset($fields['hasone']);
      unset($fields['hasmany']);
      unset($fields['manytomany']);
      self::$fields = $fields;

      self::fieldMaker();
      $sql = "INSERT INTO {$table} ( " . self::$t . " ) VALUES ( " . self::$v . " ) ;";
      // var_dump($sql);
      // var_dump(self::$arr);
      Database::executeThis($sql, self::$arr);
      return Entity::$db->lastInsertId();
    }
  }

  public static function read($table, $fields = null) // retourne un tableau associatif de l' enregistrement
  {
    if ( isset(\Core\Request::$post['email']) ) {
      $sql = "SELECT * FROM $table WHERE users.email = ? ;";
      self::$arr = \Core\Request::$post['email'];
    } else {
      if (isset($fields['WHERE'])) {
        self::$fields = $fields['WHERE'];
        self::fieldMaker();
        unset($fields['WHERE']);
      }
      if (is_array($fields) && count($fields) > 0) { //potentielle erreur future ?
        self::$fields = $fields;
        self::fieldMaker();
      }
      $sql = "SELECT * FROM $table " . self::$where . ";";
    }
    // var_dump($sql);
    // var_dump(self::$arr);
    $ret = Database::executeThis($sql, self::$arr);
    self::unsetAll();
    // var_dump($ret);
    return $ret;
  }

  public static function read_all($table) // retourne un tableau associatif de l' enregistrement
  {
    $sql = "SELECT * FROM $table ;";
    return Database::executeThis($sql, self::$arr);
  }

  public static function update($table, $fields) // retourne un booleen, here id should be $_SESSION['id']
  {
    self::$fields = $fields;
    self::fieldMaker();
    $sql = "UPDATE $table SET " . self::$u . " WHERE id = '{$_SESSION['id']}' ;";
    Database::executeThis($sql, self::$arr);
    return Database::$stmt->rowCount();
  }

  public static function delete($table, $fields) //retourne un booleen
  {
    self::$fields = $fields;
    self::fieldMaker();
    $sql = "DELETE FROM $table " .  self::$where . " ;";
    Database::executeThis($sql, self::$arr);
    return Database::$stmt->rowCount();
  }

  public static function find($table, $params)
  { // retourne un tableau d'enregistrements
    $params = self::getSpacesAgain($params);
    $ord = '';
    $lim = '';
    $join = '';
    if (isset($params['WHERE'])) {
      self::$fields = $params['WHERE'];
      self::fieldMaker();
    }
    if (isset($params['ORDER BY'])) {
      $ord = "ORDER BY {$params['ORDER BY']} ";
    }
    if (isset($params['LIMIT'])) {
      $lim = "LIMIT {$params['LIMIT']} ";
    }
    if (isset($params['JOIN'])) {
      $join = $params['JOIN'];
    }
    $sql = "SELECT " .  $table . ".* FROM $table " . $join . self::$where . $ord .  $lim . " ;";
    // var_dump($sql);
    $class = '\Model\\' . substr(ucfirst($table), 0, -1) . 'Model';
    $ret = Database::executeThis($sql, self::$arr);
    self::unsetAll();
    // var_dump($class);
    if (class_exists($class)) {
      $obj = new $class();
      if (isset($ret[0])) {
        foreach ($ret as $key => $value) {
          $obj->{substr($table, 0, -1)}[$key] = $value;
        }
      } else {
        $obj->{substr($table, 0, -1)} = $ret;
      }
      unset($obj->relations);
      return $obj;
    } else {
      return $ret;
    }
  }

  public static function fieldMaker()
  {
    self::$arr = [];
    self::$t = '';
    self::$v = '';
    self::$u = '';
    self::$where = 'WHERE ';
    foreach (self::$fields as $table => $value) {
      if (array_key_last(self::$fields) == $table) {
        self::$t .=  "`" . $table . "`";
        self::$v .= "?";
        if ($table != 'id') {
          self::$u .= " $table = ? ";
        }
        self::$where .= " $table = ? ";
      } else {
        self::$t .=  "`" . $table . "`, ";
        self::$v .= "? , ";
        if ($table != 'id') {
          self::$u .= " $table = ? , ";
        }
        self::$where .= " $table = ? AND ";
      }
      array_push(self::$arr, $value);
    }
  }

  public static function getSpacesAgain($arr)
  {
    foreach ($arr as $key => $value) {
      if (preg_match('/\_/', $key)) {
        $arr[preg_replace('/\_/', ' ',  $key)] = $arr[$key];
        unset($arr[$key]);
      }
    }
    return $arr;
  }

  public function unsetAll()
  {
    $class = new \ReflectionClass('\Core\ORM');
    $arr = $class->getStaticProperties();
    foreach ($arr as $k => $var) {
      self::${$k} = null;
    }
    unset($arr);
  }
}
