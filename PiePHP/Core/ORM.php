<?php

namespace Core;

class ORM extends Database
{
  private $db;

  public function __construct() {
    $this->db = $this->connect();
  } 

}
