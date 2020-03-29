<?php

namespace Model;

class UserModel extends \Core\ORM
{
  private $mel;
  private $pwd;
  protected $db;

  public function __construct($mel, $pwd) {
      $this->mel = $mel;
      $this->pwd = $pwd;
      $this->db = $this->connect();
  }  

  public function run()
  {
    echo __CLASS__ . ".php [ OK ]" . PHP_EOL;
  }

  public function save() {
    $sql = 'INSERT INTO users (`email`, `password`) VALUES ( ? ,  ? ); ';
    $this->executeThis($sql, [$this->mel, $this->pwd]);
  }
  
  public function login() {
    $sql = 'SELECT * from USERS WHERE email = ? AND `password` = ? ; ';
    return $this->executeThis($sql, [$this->mel, $this->pwd]);
  }
  
  
  public function modelRegister() {
    $sql = 'INSERT INTO users (`email`, `password`) VALUES ( ? ,  ? ); ';
    $this->executeThis($sql, [$this->mel, $this->pwd]);
    return $this->db->lastInsertId();
  }



}