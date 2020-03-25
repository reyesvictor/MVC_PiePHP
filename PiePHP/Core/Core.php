<?php

namespace Core;

class Core
{
  public function run()
  {
    echo __CLASS__ . " [ OK ]" . PHP_EOL;
    // echo '=============GET CORE===============' . PHP_EOL;
    // var_dump($_GET);


    //GET
    if ( isset($_GET['c']) ) {
      $class =  'Controller\\' . ucfirst($_GET['c']) . 'Controller';
      try {
        $cl = new $class ();
        $cl->{$_GET['a'] . 'Action'}();
      } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
      }  
    }
    else {
      $arr = array_reverse((explode('/', $_SERVER['REQUEST_URI'])));
      $class =  'Controller\\' . ucfirst($arr[1]) . 'Controller';
      try {
        $cl = new $class ();
        $cl->{$arr[0] . 'Action'}();
      } catch (\Throwable $th) {
        echo "Captured Throwable: " . $th->getMessage() . PHP_EOL;
      }  
    }
    
    $md = new \Model\UserModel ();
    $md->run();
    //URL
  }
}
