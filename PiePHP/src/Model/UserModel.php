<?php

namespace Model;


class UserModel extends \Core\Entity
{
  // Vous devez donc représenter ce mécanisme dans vos models, et dans votre ORM
  //$relations = [ $articles, $comments  ];

  public $relations = [
    'hasone' => [
      ['table' => 'promos', 'key' => 'promo_id'],
    ], 
    'hasmany' => [
      ['table' => 'comments', 'key' => 'user_id'],
    ],
    'manytomany' => ['table1' => 'users', 'table2' => 'games'],
  ];

  public function login()
  {
    $sql = "SELECT `id`, `email` from USERS WHERE email = ? AND `password` = ? ; ";
    if (count($res = \Core\Database::executeThis($sql, [$this->email, $this->password])) > 0) {
      $_SESSION['id'] = $res['id'];
      $_SESSION['email'] = $res['email'];
    }
    return $res;
  }
}