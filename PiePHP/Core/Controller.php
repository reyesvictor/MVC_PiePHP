<?php

namespace Core;

class Controller
{
  public static $_render;
  static $info;
  protected function render($view, $scope = [])
  {
    extract($scope);
    $f = implode(DIRECTORY_SEPARATOR, ['.', 'src', 'View', str_replace('Controller', '', basename(get_class($this))), $view]) . '.php';
    if (file_exists($f)) {

      //Etape 1 : recuperer le code de la page
      //Etape 2 : remplacer les {{ }} par du php <?= \?\>
      //Etape 3 : render la page php pour y afficher la variable =======
      //Etape 4 : afficher le tout dans la page index.php du View




      //Array accessile par parse()
      self::$info = $info;
      //Moteur de template
      ob_start();
      // eval($this->parse($f));
      // eval("echo 'This is some really fine output.';");
      // eval("echo ". $this->parse($f) . ";");
      echo $this->parse($f);
      $view = ob_get_clean();
      // echo '--------<pre>';
      // var_dump($view);
      // echo '<br>--------</br></pre>';

      //BLOC 1
      // ob_start();
      // include($f);
      // $view = ob_get_clean();

      //BLOC 2
      ob_start();
      include(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . '.php');
      self::$_render = ob_get_clean();

      // var_dump($scope);
      // echo '--------<pre>';
      // echo 'DISPLAYING THE PAGE : <br>';
      // echo '--------</br></pre>';
      echo self::$_render;
    }
  }

  protected function parse($f)
  {
    $rp = [
      '/{{(.+)}}/' => '<?= htmlentities() ?>',
    ];
    $content = file_get_contents($f);
    while ($res = preg_match_all('/{{(.+)}}/', $content, $matches)) {
      $content = preg_replace('/{{/', '', $content, 1);
      $content = preg_replace('/}}/', '', $content, 1);
      $var_name = str_replace([' ', '$'], '', $matches[1][0]);
      $var_fullname = str_replace([' '], '', $matches[1][0]);
      $content = str_replace($var_fullname, htmlentities(self::$info[$var_name]), $content);
    }

    //  @if(count($records) === 1)
    if ( $res = preg_match_all('/@if(.*?)@endif/s', $content, $matches)) {
      var_dump($res);
    }
    return $content;
  }
}
