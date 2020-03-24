<?php

//Le point de départ est src/View/User/index.php
//Donc pour accéder à Core il faut
// ../../../../Core/core.php

// var_dump($_SERVER);
$path = $_SERVER['PATH_TRANSLATED'] . $_SERVER['REDIRECT_URL'] . 'Core/';
// echo $path . PHP_EOL;

// if ( file_exists('C:/xampp/htdocs//MVC_PiePHP/Core/Core.php') ) {
//   echo 'OK CHEF';
// }

spl_autoload_register('autoLoad');

function autoLoad($class)
{
  $array = [
    url($_SERVER['PATH_TRANSLATED'] . $_SERVER['REDIRECT_URL']),
    // url('../../../../../Core/'),
    // url('../../../../Core/'),
    // url('../../../Core/'),
    // url('../../Core/'),
    // url('../Core/'),
    // url('./Core/'),
  ];

  for ($i = 0; $i < count($array); $i++) {
    $classPath = url("{$array[$i]}{$class}.php");
    // echo 'IM OUTSIDE SIR: ' . ($classPath) . PHP_EOL;
    if (file_exists($classPath)) {
      // echo 'IM IN SIR:  ' . $classPath . PHP_EOL;
      include $classPath;
    }
  }
}
