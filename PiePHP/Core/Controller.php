<?php

namespace Core;

class Controller
{
  public static $_render;
  // protected function render($view, $scope = [])
  protected function render($view, $scope = [])
  {
    // echo 'render [ OK ]' . PHP_EOL;  
    extract($scope);
    // $f = implode(DIRECTORY_SEPARATOR, [substr(PATH_ORIGIN, 0, -1), 'src', 'View', str_replace('Controller', '', basename(get_class($this))), $view]) . '.php';
    $f = implode(DIRECTORY_SEPARATOR, ['./src', 'View', str_replace('Controller', '', basename(get_class($this))), $view]) . '.php';
    // echo url($f) . ' <===' . PHP_EOL;
    // echo __DIR__  . ' <===' . PHP_EOL;
    // echo 'OUTSIDE FILE EXISTS' . PHP_EOL;
    // echo $f . PHP_EOL;
    if (file_exists($f)) {
      // echo 'INSIDE file_exists <==========' . PHP_EOL; 
      
      //BLOC 1
      ob_start();
      include($f);
      // echo ob_get_clean();
      $view = ob_get_clean();
      // echo $view;

      //BLOC 2
      ob_start();
      include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
      // include('./src/View/index.php');
      self::$_render = ob_get_clean();
      echo self::$_render;
      
      // echo implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php' . PHP_EOL;
      // $this->_render = ob_get_clean();
    }
  }
}
