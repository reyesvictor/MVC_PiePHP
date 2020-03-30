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
  }

  //REGISTER A NEW USER -------------------------
  public function addAction()
  {
    if (isset(\Core\Request::$post['email']) && isset(\Core\Request::$post['password'])) { //register account
      echo '<h3>Registration in process !</h3>';
      echo $this->registerAction();
    } else { //show page
      $this->file = 'register';
      //EN DESSOUS POUR LES TESTS, A ENLEVER----
      $params = ['id' => '10'];
      $this->add = new \Model\UserModel($params);
      echo '<pre></br>';
      echo '<h3>Register here, enter your email and password !</h3>';
      print_r($this->add->modelFind());
      echo '</br></pre>';
      //JUSQUICI--------------------------------
    }
  }

  public function registerAction()
  {
    $this->add = new \Model\UserModel(\Core\Request::$post);
    //CREATE user
    echo '<pre>';
    echo $this->add->modelCreate() . ' <=== Modelcreate\Create : last id </br>' . PHP_EOL;
    echo '</br>';
    //READ, doit aller dans showAction en bas
    print_r($this->add->modelRead());
    echo '</br>';
    //UPDATE, modifie les données
    print_r($this->add->modelUpdate());
    echo ' <==== 1 = Update OK, 0 = Update WRONG </br>';
    //READ, doit aller dans showAction en bas
    // print_r($this->add->modelRead());
    //DELETE user
    print_r($this->add->modelDelete());
    echo ' <==== 1 = Delete OK, 0 = Delete WRONG </br>';
    echo '</br>';
    print_r($this->add->modelFind());
    echo '</br>';
    echo '</pre>';
  }

  //CONNECT A USER -------------------------------
  public function indexAction()
  {
    if (isset(\Core\Request::$post['email']) && isset(\Core\Request::$post['password'])) {
      $this->loginAction();
    } else {
      $this->file = 'register';
    }
    $this->file = 'index';
  }

  public function loginAction()
  {
    if (isset(\Core\Request::$post['email']) && isset(\Core\Request::$post['password'])) {
      $this->add = new \Model\UserModel(\Core\Request::$post);
      if ($res = $this->add->login() != false ) { //login action
        echo '<h3>Succesfull LOGIN :D</h3>';
        $this->file = '/';
      } else {
        echo '<h3>Wrong email or password :/</h3>';
        $this->file = 'login';
      }
    } else { //show page
      echo '<h3>Please enter your email and password to login :)</h3>';
      $this->file = 'login';
    }
  }


  // SHOW LIST OF USERS ----------------------------
  public function showAction()
  {
    $this->file = 'show';
  }

  public function __destruct()
  {
    if ($this->file) {
      $this->render($this->file);
    } else {
      echo 'File hasnt been declared in UserController </br>' . PHP_EOL;
    }
  }
}
