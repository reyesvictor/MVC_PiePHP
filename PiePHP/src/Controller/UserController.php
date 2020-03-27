<?php

// require_once AUTOLOADER_URI;

namespace Controller;

class UserController extends \Core\Controller
{
  protected $file;

  public function __construct()
  {
    // echo PHP_EOL;
    // echo '__construct [ OK ]' . PHP_EOL;
  }

  public function addAction()
  {
    echo 'UserController + addAction' . PHP_EOL;
  }

  public function indexAction()
  {
    $this->file = 'index';
    // echo 'UserController + indexAction' . PHP_EOL;
  }
  
  public function registerAction()
  {
    $this->file = 'register';
    // echo 'UserController + registerAction' . PHP_EOL;
  }

  public function loginAction()
  {
    $this->file = 'login';
    // echo 'UserController + registerAction' . PHP_EOL;
  }

  
  public function showAction()
  {
    $this->file = 'show';
    // echo 'UserController + registerAction' . PHP_EOL;
  }

  public function __destruct()
  {
    // var_dump($this->_render);
    // var_dump(self::$_render);
    if ( $this->file ) {
      $this->render($this->file);
    } else {
      echo 'File hasnt been declared in UserController';
    }
    // echo '__destruct [ OK ]' . PHP_EOL;
    // echo PHP_EOL;
  }
}
