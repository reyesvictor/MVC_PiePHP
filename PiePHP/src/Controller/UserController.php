<?php

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
      echo $this->registerAction();
    } else { //show page
      $this->file = 'register';
    }
  }

  public function registerAction()
  {
    $this->add = new \Model\UserModel(\Core\Request::$post);
    // var_dump($this->add);
    if (count($this->add->modelRead()) > 0) {
      echo '<h3>Error, user with this mail already exists</h3>';
      $this->file = 'register';
      return;
    }
    //CREATE user
    echo '<h3>Registration done !</h3>';
    echo '<p>';
    echo 'Your user id is : ' . $this->add->modelCreate();
    echo '</p>';
    echo '</br>';
    echo 'Reading the user information: ';
    echo '</br>';
    //READ, doit aller dans showAction en bas
    echo '<pre>';
    print_r($this->add->modelRead('user', ['']));
    echo '</pre>';
    echo '</br>';
    echo 'Login in this user...';
    $this->add->login();
    echo '</br>';
    echo '</br>';
    echo 'Possibility to modify user information: ';
    echo '</br>';

    //UPDATE, modifie les données------------------------------
    $this->add2 = new \Model\UserModel([
      'email' => "{$_SESSION['email']}-modified",
      'password' => 'modified',
    ]);
    print_r($this->add2->modelUpdate());
    echo ' <==== 1 = Update OK, 0 = Update WRONG </br>';
    echo '</br>';
    echo 'Reading the user information: ';
    echo '</br>';
    // $this->logoutAction();
    $this->add2->login();
    echo '<pre>';
    //READ, doit aller dans showAction en bas
    print_r($this->add2->modelRead());
    echo '</pre>';
    echo '</br>';
    //VERIFY 
    $verif = $this->add2->modelFind();
    if (isset($verif) && count($verif) == 0) {
      echo 'This user does not exist';
    } else {
      echo 'This user exists';
    }

    // DELETE user-----------------------------------------
    // echo '</br>';
    // echo 'Possibility to delete user.</br>';
    // $this->del = new \Model\UserModel([
    //   'email' => $_SESSION['email'],
    // ]);
    // print_r($this->del->modelDelete());
    // echo ' <==== 1 = Delete OK, 0 = Delete WRONG </br>';
    // echo '</br>';
    // // VERIFY
    // $verif = $this->add2->modelFind();
    // if (isset($verif) && count($verif) == 0) {
    //   echo 'This user does not exist';
    // } else {
    //   echo 'This user exists';
    // }
    // echo '</br>';
    // $this->logoutAction();
    // echo '</br>';

    $this->file = 'index';
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
      if ($this->add->login() != false) { //login action
        echo "<h3>Succesfull LOGIN :D, your id is : {$_SESSION['id']}</h3>";
        echo "<button><a href='/PiePHP/show'>Show</a></button>";
        echo "<button><a href='/PiePHP/logout'>Logout</a></button>";
      } else { //connect page after error
        echo '<h3>Wrong email or password :/</h3>';
        $this->file = 'login';
      }
    } else { //Connect page
      $this->file = 'login';
    }
  }

  public function logoutAction()
  {
    if (isset($_SESSION['id'])) {
      session_destroy();
    }
    $this->file = 'index';
  }

  // SHOW LIST OF USERS ----------------------------
  public function showAction($id = null)
  {
    // $param = [
    //   //   'WHERE' => [
    //   //     'email' => 'victor.reyes@',
    //   //     'password' => 'root'
    //   //   ],
    //   'ORDER BY' => 'id DESC',
    //   // 'LIMIT' => '3',
    // ];
    if (isset($id) && $id  == '?') { //if ? then look for the first user in the database
      $this->all_users = new \Model\UserModel();
      $this->pass = $this->all_users->modelRead_all();
      $this->arr['users'] = $this->pass[0];
    } else if (isset($id)) {
      $users = new \Model\UserModel(['id' => $id]);
      unset($users->relations);
      // var_dump($users);
      if (!isset($users->email)) {
        echo 'This user doesnt exist<br>';
      } else if (isset($users->promos[0]->promo['content'])) {
        $users->comments[0]->display();
        $users->promos[0]->display();
        $this->arr['users'] = $users;
        echo 'The user ' . $users->email, ' had a ' . $users->promos[0]->promo['content'] . ' reduction<br>';
        echo 'The users ' . $users->email, ' didn\'t had a reduction<br>';
      } else if (isset($users->promo_id)) {
        $users->comments[0]->display();
        $users->promos[0]->display();
        $this->arr['users'] = $users;
        echo 'The user ' . $users->email, ' had a ' . $users->promo_id . ' reduction<br>';
      } else {
        echo 'The users ' . $users->email, ' didn\'t had a reduction<br>';
      }
    } else if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
      $users = new \Model\UserModel(['id' => $_SESSION['id']]);
      unset($users->relations);
      // var_dump($users);
      // var_dump($users->promos[0]->promo);
      if (!isset($users->email)) {
        echo 'This user doesnt exist<br>';
      } else if (isset($users->promos[0]->promo['content'])) {
        $users->comments[0]->display();
        $users->promos[0]->display();
        $this->arr['users'] = $users;
        echo 'The user ' . $users->email, ' had a ' . $users->promos[0]->promo['content'] . ' reduction<br>';
        echo 'The users ' . $users->email, ' didn\'t had a reduction<br>';
      } else if (isset($users->promo_id)) {
        $users->comments[0]->display();
        $users->promos[0]->display();
        $this->arr['users'] = $users;
        echo 'The user ' . $users->email, ' had a ' . $users->promo_id . ' reduction<br>';
      } else {
        echo 'The users ' . $users->email, ' didn\'t had a reduction<br>';

      }

      //Test a garder=================================
      // $param = [
      //   'WHERE' => [
      //     $id['col'] => $id['id'],
      //     // 'users.email' => 'victor.reyes@hhh',
      //   ]];
      // $this->show = new \Model\UserModel($param);
      // $this->arr = $this->show->modelFind();  
      // $this->arr = \Model\UserModel::modelFind();
      //==============================================
    }
    $this->file = 'show';
    $this->arr['welcome_text'] = 'Welcome to the user list page<br>';
    $this->arr['middle_text'] = 'Here you can see user information<br>';
    $this->arr['end_text'] = 'You reached the botttom';
    $this->arr['credits'] = '@victor 2020';
    // var_dump($this->arr);
    // echo '<hr>';
  }

  public function __destruct()
  {
    if (isset($this->file) && isset($this->arr)) {
      echo $this->render($this->file, $this->arr);
    } else {
      echo $this->render($this->file);
    }
  }
}
