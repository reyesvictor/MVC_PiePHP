<?php

// require_once AUTOLOADER_URI;

namespace Controller;

class UserController extends \Core\Controller
{
  protected $file;
  protected $add;
  protected $rq;

  public function __construct()
  {
    $this->rq = new \Core\Request();
    // echo PHP_EOL;
    // echo '__construct [ OK ]' . PHP_EOL;
  }



  public function addAction()
  {
    if ( isset($this->rq->post['email']) && isset($this->rq->post['password']) ) {
      $this->registerAction();
    } else {
      $this->file = 'register';
    }
      //true
    echo 'UserController + addAction [ ROUTER STATIC ] </br>' . PHP_EOL;
  }

  public function registerAction()
  {
      $this->add = new \Model\UserModel ($this->rq->post['email'], $this->rq->post['password']);
      echo $this->add->modelRegister() . ' <===LAST ID ENTERED </br>' . PHP_EOL;
      // echo $this->add->save();
      // $this->file = 'index'; //ne pas supprimer
  }



  public function indexAction()
  {
    if ( isset($this->rq->post['email']) && isset($this->rq->post['password']) ) {
      $this->loginAction();
    } else {
      $this->file = 'register';
    }
    $this->file = 'index';
    // echo 'UserController + indexAction' . PHP_EOL;
  }
  
  public function loginAction()
  {
    if ( isset($this->rq->post['email']) && isset($this->rq->post['password']) ) {
      $this->add = new \Model\UserModel ($this->rq->post['email'], $this->rq->post['password']);
      if ( $this->add->login() != null) { //if user exists
        $this->file = 'show';
      } else {
        $this->file = 'login';
      }
    } else { //if it isnt a connection but entering the page
      $this->file = 'login';
    }
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
      echo 'File hasnt been declared in UserController </br>' . PHP_EOL;
    }
    // echo '__destruct [ OK ]' . PHP_EOL;
    // echo PHP_EOL;
  }
}
