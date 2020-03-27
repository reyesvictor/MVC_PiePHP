<?php

// require_once AUTOLOADER_URI;

namespace Controller;

class AppController extends \Core\Controller
{
  protected $file;

  public function indexAction()
  {
    $this->file = 'index';
    // echo 'AppController + indexAction ' . PHP_EOL;
  }

  public function __destruct()
  {
    if ( $this->file ) {
      $this->render($this->file);
    } else {
      echo 'File hasnt been declared in UserController';
    }
  }
}