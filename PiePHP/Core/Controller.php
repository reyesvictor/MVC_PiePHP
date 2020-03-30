<?php

namespace Core;

class Controller
{
  public static $_render;

  protected function render($view, $scope = [])
  {
    extract($scope);
    $f = implode(DIRECTORY_SEPARATOR, ['.' , 'src', 'View', str_replace('Controller', '', basename(get_class($this))), $view]) . '.php';
    if (file_exists($f)) {
      //BLOC 1
      ob_start();
      include($f);
      $view = ob_get_clean();

      //BLOC 2
      ob_start();
      include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
      self::$_render = ob_get_clean();
      echo self::$_render;
    }
  }
}
