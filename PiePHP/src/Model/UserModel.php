<?php

namespace Model;

class UserModel extends \Core\Entity //extends \Core\ORM
{
  protected $id;
  protected $orm;
  protected $getdb;
  // public static $db;

  // public function __construct($mel, $pwd)
  // {
  //   $this->mel = $mel;
  //   $this->pwd = $pwd;
  //   // $this->db = new \Core\Database ();
  //   self::$db = \Core\Database::connect();
  //   $this->orm =  new \Core\ORM();
  // }

  public function run()
  {
    echo __CLASS__ . ".php [ OK ]" . PHP_EOL;
  }

  public function save()
  {
    $sql = 'INSERT INTO users (`email`, `password`) VALUES ( ? ,  ? ); ';
    \Core\Database::executeThis($sql, [$this->email, $this->password]);
  }

  public function login()
  {
    $sql = 'SELECT * from USERS WHERE email = ? AND `password` = ? ; ';
    return \Core\Database::executeThis($sql, [$this->email, $this->password]);
  }

  public function modelCreate()
  {
    return $this->id = \Core\ORM::create('users', [
      'email' => $this->email,
      'password' => $this->password,
    ]);
  }

  public function modelRead()
  {
    return \Core\ORM::read('users', $this->id);
  }

  public function modelUpdate()
  {
    return \Core\ORM::update('users', $this->id, [
      'email' => 'newemail@test',
      'password' => 'wesh',
    ]);
  }

  public function modelDelete()
  {
    return \Core\ORM::delete('users', $this->id);
  }

  public function modelFind()
  {
    return \Core\ORM::find('users', [
      'WHERE' => [
        'email' => 'newemail@test',
        'password' => 'wesh'
      ],
      'ORDER BY' => 'id DESC',
      'LIMIT' => '3',
    ]);
  }
}
