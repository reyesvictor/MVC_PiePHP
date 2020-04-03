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

    //Charge HomePage
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
        echo "<button><a href='/PiePHP/show'>Show All Users</a></button>";
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
    if ( isset($id) && $id == '?' ) { //if ? then look for the first user in the database
      $this->all_users = new \Model\UserModel();
      $arr = $this->all_users->modelRead_all();
      $id = $arr[0]['id'];
    }
    if (isset($id)) {
      $param = [
        'WHERE' => [
          'id' => $id,
          // 'users.email' => 'victor.reyes@hhh',
        ],
      ];
      $this->parametric = new \Model\UserModel($param);
      $arr = $this->parametric->modelRead();
    }
    if (isset($_SESSION['id']) && isset($_SESSION['email'])) {
      //Test Les Relationnels Model - One To Many--------------------
      $this->onetomany = new \Model\UserModel([
        'relations' => [
          'hasmany' => 'users',
          'hasone' => 'comments',
        ],
        'WHERE' => [
          'users.email' => 'victor.reyes@'
        ],
      ]);
      //if count(results) == 2 then INNER JOIN
      // SELECT * FROM comments JOIN users WHERE users.id = 2 ;
      //OR
      //SELECT * FROM comments JOIN users ON users.id=comments.id_users WHERE users.id = 2
      $arr = $this->onetomany->modelFind();
      //Fin de test---------------------------------------------------

      //Test a garder=================================
      // $this->show = new \Model\UserModel($param);
      // $arr = $this->show->modelFind();
      // $arr = \Model\UserModel::modelFind();
      //==============================================
    }

    //DISPLAY RESULTS
    if (isset($arr) && count($arr) > 0) {
          if (isset($arr[0]) && is_array($arr[0])) {
            for ($i = 0; $i < count($arr); $i++) {
              if (isset($arr[$i]['content'])) {
                echo "<p>Comment by user n<b>{$arr[$i]['id']}</b>: {$arr[$i]['content']}</p>";
              } else {
                echo "<p>User n <b>{$arr[$i]['id']}</b>, email: {$arr[$i]['email']}</p>";
              }
            }
          } else {
            echo "<p>User n <b>{$arr['id']}</b>, email: {$arr['email']}</p>";
          }
        } else {
          echo '<p>There are no users results</p>';
        }
    $this->file = 'show';
  }

  public function __destruct()
  {
    if ($this->file) {
      $this->render($this->file);
    }
  }
}
