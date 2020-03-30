<?php

namespace Core;

class ORM //extends Database
{

  static $t;
  static $v;
  static $u;
  static $arr;
  static $where;
  static $fields;
  // private $getdb;
  static $db;

  public function __construct()
  {
    self::$db = Database::connect();
  }

  public static function create($table, $fields) //return last id
  {
    self::$fields = $fields;
    self::fieldMaker();
    $sql = "INSERT INTO {$table} ( " . self::$t . " ) VALUES ( " . self::$v . " ) ;";
    Database::executeThis($sql, self::$arr, self::$db);
    return self::$db->lastInsertId();
  }

  public static function read($table, $id) // retourne un tableau associatif de l' enregistrement
  {
    $sql = "SELECT * FROM $table WHERE id = ? ;";
    return Database::executeThis($sql, $id, self::$db);
  }

  public static function update($table, $id, $fields) // retourne un booleen
  {
    self::$fields = $fields;
    self::fieldMaker();
    $sql = "UPDATE $table SET " . self::$u . " WHERE id = $id ;";
    Database::executeThis($sql, self::$arr, self::$db);
    return Database::$stmt->rowCount();
  }

  public static function delete($table, $id) //retourne un booleen
  {
    $sql = "DELETE FROM $table WHERE id = ? ;";
    Database::executeThis($sql, $id, self::$db);
    return Database::$stmt->rowCount();
  }

  public static function find($table, $params)
  { // retourne un tableau d'enregistrements
    self::$fields = $params['WHERE'];
    self::fieldMaker();
    $ord = '';
    $lim = '';
    if (isset($params['ORDER BY'])) {
      $ord = "ORDER BY {$params['ORDER BY']} ";
    }
    if (isset($params['LIMIT'])) {
      $lim = "LIMIT {$params['LIMIT']} ";
    }
    $sql = "SELECT * FROM $table WHERE " . self::$where . $ord .  $lim . " ;";
    echo '<pre></br>';
    echo $sql;
    echo '</br></pre>';
    return Database::executeThis($sql, self::$arr, self::$db);
  }

  public static function fieldMaker()
  {
    self::$arr = [];
    self::$t = '';
    self::$v = '';
    self::$u = '';
    self::$where = '';
    foreach (self::$fields as $table => $value) {
      if (array_key_last(self::$fields) == $table) {
        self::$t .=  "`" . $table . "`";
        self::$v .= "?";
        self::$u .= " $table = ? ";
        self::$where .= " $table = ? ";
      } else {
        self::$t .=  "`" . $table . "`, ";
        self::$v .= "? , ";
        self::$u .= " $table = ? , ";
        self::$where .= " $table = ? AND ";
      }
      array_push(self::$arr, $value);
    }
  }
}
