<?php

namespace Core;
// CONNECT TO THE DATABASE HOST
class Database
{
  private $host = "localhost";
  private $user = "root";
  private $pwd = "";
  private $dbName = "piephp";
  protected $stmt;
  // private $host = "remotemysql.com";
  // private $user = "lTsiPIi4Qh";
  // private $pwd = "nUKWNJXLKN";
  // private $dbName = "lTsiPIi4Qh";

  //CONNEXION TO THE DATABASE
  protected function connect()
  {
    $dsn = 'mysql:host=' . $this->host . ';port=3306;dbname=' . $this->dbName;
    $pdo = new \PDO($dsn,  $this->user,  $this->pwd);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    return $pdo;
  }

  protected function executeThis($sql, $array_values = null)
  {
    $this->stmt = $this->db->prepare($sql);
    if (!$array_values) {
      $this->stmt->execute();
    } else if (is_string($array_values) || is_int($array_values)) {
      $this->stmt->execute([$array_values]);
    } else {
      //TEST-------------------------------------------
      // for ($i = 1; $i <= count($array_values); $i++) {
      //   $this->stmt->bindParam($i, $array_values[$i - 1]);
      // }
      // $this->stmt->execute();
      // echo '<pre></br>';
      // var_dump($this->stmt->debugDumpParams());
      // echo '</br></pre>';
      //------------------------------------------------
      $this->stmt->execute($array_values);
      // NE PAS EFFACER CEST COOL POUR VOIR LES REQUETES SQL----------------------
      // echo '<pre></br>';
      // var_dump($this->stmt->debugDumpParams());
      // echo '</br></pre>';
      //--------------------------------------------------------------------------
    }
    return $this->tryFetch();
  }

  protected function tryFetch()
  {
    try {
      if (count($results = $this->stmt->fetchAll()) == 1) {
        return $results[0];
      } else {
        return $results;
      }
    } catch (\Throwable $th) {
      return $th;
    }
  }
}
