<?php

namespace Model;


class UserModel extends \Core\Entity
{
  public $relations = [
    'hasone' => [
      ['table' => 'promos', 'key' => 'promo_id'],
    ],
    'hasmany' => [
      ['table' => 'comments', 'key' => 'user_id'],
    ],
    'manytomany' => [
      ['table' => 'games', 'key' => 'game_id'],
    ],
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
