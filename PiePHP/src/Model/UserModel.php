<?php

namespace Model;

class UserModel extends \Core\ORM
{
  private $mel;
  private $pwd;
  protected $db;
  protected $id;

  public function __construct($mel, $pwd)
  {
    $this->mel = $mel;
    $this->pwd = $pwd;
    $this->db = $this->connect();
  }

  public function run()
  {
    echo __CLASS__ . ".php [ OK ]" . PHP_EOL;
  }

  public function save()
  {
    $sql = 'INSERT INTO users (`email`, `password`) VALUES ( ? ,  ? ); ';
    $this->executeThis($sql, [$this->mel, $this->pwd]);
  }

  public function login()
  {
    $sql = 'SELECT * from USERS WHERE email = ? AND `password` = ? ; ';
    return $this->executeThis($sql, [$this->mel, $this->pwd]);
  }

  public function modelCreate()
  {
    return \Core\ORM::create('users', [
      'email' => $this->mel,
      'password' => $this->pwd,
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
      'LIMIT' => '10',
    ]);
  }
}
