<?php

namespace Controller;

class AppController extends \Core\Controller
{
  protected $file;
  protected $rq;

  public function indexAction()
  {
    $this->rq = new \Core\Request();
    $this->file = 'index';
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