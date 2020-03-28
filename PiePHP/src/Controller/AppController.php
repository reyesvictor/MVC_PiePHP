<?php

// require_once AUTOLOADER_URI;

namespace Controller;

class AppController extends \Core\Controller
{
  protected $file;
  protected $rq;

  public function indexAction()
  {
    $this->rq = new \Core\Request();
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