<?php

namespace Core;

class Controller
{
  public static $_render;
  // static $info;
  protected function render($view, $scope = [])
  {
    //extract and make variable accessible from other functions like $this->var;
    // extract($scope);
    $f = implode(DIRECTORY_SEPARATOR, ['.', 'src', 'View', str_replace('Controller', '', basename(get_class($this))), $view]) . '.php';
    if (file_exists($f)) {
      //BLOC 0 : Moteur de template, remplace le bloc 1
      ob_start();
      $tm = new \Core\TemplateEngine ();
      echo $tm->parse($scope, $f);
      $view = ob_get_clean();

      //BLOC 1 : ne sert plus, sauf pour mettre en place les Relations Model..
      // ob_start();
      // include($f);
      // $view = ob_get_clean();

      //BLOC 2
      ob_start();
      include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
      self::$_render = ob_get_clean();
      echo self::$_render;
    }
  }
}
