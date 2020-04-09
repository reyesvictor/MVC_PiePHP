<?php

namespace Core;

class Database
{
  static $host = "localhost";
  static $user = "root";
  static $pwd = "";
  static $dbName = "piephp";
  static $stmt;
  // private $host = "remotemysql.com";
  // private $user = "lTsiPIi4Qh";
  // private $pwd = "nUKWNJXLKN";
  // private $dbName = "lTsiPIi4Qh";

  //CONNEXION TO THE DATABASE
  public static function connect()
  {
    $dsn = 'mysql:host=' . self::$host . ';port=3306;dbname=' . self::$dbName;
    $pdo = new \PDO($dsn,  self::$user,  self::$pwd);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $pdo;
  }

  public static function executeThis($sql, $array_values = null)
  {
    self::$stmt = Entity::$db->prepare($sql);
    if (!$array_values) {
      self::$stmt->execute();
    } else if (is_string($array_values) || is_int($array_values)) {
      self::$stmt->execute([$array_values]);
    } else if ( is_array($array_values)) {
      //TEST-------------------------------------------
      // for ($i = 1; $i <= count($array_values); $i++) {
      //   self::$stmt->bindParam($i, $array_values[$i - 1]);
      // }
      // self::$stmt->execute();
      // echo '<pre></br>';
      // var_dump(self::$stmt->debugDumpParams());
      // echo '</br></pre>';
      //------------------------------------------------
      self::$stmt->execute($array_values);
      // NE PAS EFFACER CEST COOL POUR VOIR LES REQUETES SQL----------------------
      // echo '<pre></br>';
      // var_dump(self::$stmt->debugDumpParams());
      // echo '</br></pre>';
      //--------------------------------------------------------------------------
    }
    return self::tryFetch();
  }

  protected function tryFetch()
  {
    try {
      if (count($results = self::$stmt->fetchAll()) == 1) {
        return $results[0];
      } else {
        return $results;
      }
    } catch (\Throwable $th) {
      return $th;
    }
  }
}
