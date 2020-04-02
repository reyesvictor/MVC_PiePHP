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
    self::$fields = $fields;
    self::fieldMaker();
    $sql = "INSERT INTO {$table} ( " . self::$t . " ) VALUES ( " . self::$v . " ) ;";
    Database::executeThis($sql, self::$arr);
    return Entity::$db->lastInsertId();
  }

  //This One Should Have The Possibility to get $relations = [ $articles, $comments  ]; ==> modify the sql request
  // SELECT * FROM comments JOIN user WHERE user.id = 2 ;
  public static function read($table, $fields) // retourne un tableau associatif de l' enregistrement
  {
    self::$fields = $fields;
    self::fieldMaker();
    $join = '';
    if (isset($fields['hasmany'])) {
      $table = $fields['hasone'];
      $join = "JOIN {$fields['hasmany']} ";
    }
    $sql = "SELECT * FROM $table " . $join . self::$where . ";";
    return Database::executeThis($sql, self::$arr);
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

  //This One Should Have The Possibility to get $relations = [ $articles, $comments  ]; ==> modify the
  // INSERT INTO comments (content, id_users) VALUES ( 'This is a comment', 2 );
  // INSERT INTO comments (content, id_users) VALUES ( 'This is another comment', 2 );
  // INSERT INTO comments (content, id_users) VALUES ( 'This is a last comment', 2 );
  // Example get multiple comments from one user 
  // SELECT * FROM comments JOIN user WHERE user.id = 2 ;
  public static function find($table, $params) //read_all
  { // retourne un tableau d'enregistrements
    $params = self::getSpacesAgain($params);
    $ord = '';
    $lim = '';
    $join = '';
    if (isset($params['hasmany'])) {
      $table = $params['hasone'];
      $join = "JOIN {$params['hasmany']} ";
    }
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
    $sql = "SELECT * FROM $table " . $join . self::$where . $ord .  $lim . " ;";
    return Database::executeThis($sql, self::$arr);
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
}
