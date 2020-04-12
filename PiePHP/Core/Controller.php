<?php

namespace Core;

class Controller
{
    protected function render($view, $scope = [])
  {
    $f = implode(DIRECTORY_SEPARATOR, ['.', 'src', 'View', str_replace('Controller', '', basename(get_class($this))), $view]) . '.php';
    if (file_exists($f)) {

      if (preg_match_all('/\@foreach|\@if|{{(.+)}}|\@isset|\@empty/', (file_get_contents($f)))) {
        //BLOC 0 : ne sert plus, sauf pour mettre en place les Relations Model..
        ob_start();
        include($f);
        $view = ob_get_clean();
        //BLOC 1 : Moteur de template
        ob_start();
        $tm = new \Core\TemplateEngine();
        echo $tm->parse($scope, $view);
        $view = ob_get_clean();
      } else {
        //BLOC 1 : ne sert plus, sauf pour mettre en place les Relations Model..
        ob_start();
        include($f);
        $view = ob_get_clean();
      }

      //BLOC 2
      ob_start();
      include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
      $_render = ob_get_clean();
      return $_render;
    }
  }
}
