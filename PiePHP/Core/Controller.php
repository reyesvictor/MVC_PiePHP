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


      //EVAL marche
      // $nbr = 8;
      // eval("if ( $nbr == 8 ) {
      //   echo '--------<pre>';
      //   echo 'THIS IS NICE MY NIBBA<br>';
      //   echo '<br>--------</br></pre>';
      // }");

      // $a = 6;
      // eval('if ($a == 5) { 
      //   echo "a égale 5"; 
      //   echo "..."; 
      // } else if ($a == 6) { 
      //     echo "a égale 6"; 
      //     echo "!!!"; 
      //   } else { 
      //     echo "a ne vaut ni 5 ni 6"; 
      //   }');

      ob_start();
      // eval($this->parse($f));
      // eval("echo 'This is some really fine output.';");
      // eval("echo ". $this->parse($f) . ";");
      $this->parse($f);
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

    while (preg_match_all('/@if(.*?)@endif/s', $content, $matches)) {
      if (preg_match_all('/@if(.*?)@endif|\):|@else:/s', $content, $matches)) {
        $content = preg_replace('/@if/', 'if', $content, 1);
        while ( preg_match_all('/@elseif/', $content, $matches) ) {
          $content = preg_replace('/@elseif/', '} else if', $content, 1);
        }
        while ( preg_match_all('/\)\:/', $content, $matches) ) {
          $content = preg_replace('/\)\:/', ') {', $content, 1);
        }
        $content = preg_replace('/@else:/', '} else {', $content, 1);
        $content = preg_replace('/@endif;/', '}-end-', $content, 1);
      }
      $a = 8;
      $b = 13;
      $arr = preg_split("@(?=if \()@", $content, 2, PREG_SPLIT_DELIM_CAPTURE);
      $if = preg_split("/-end-/", $arr[1], 2);

      echo $arr[0];
      eval($if[0]);
      $content = $if[1];
      // $input = "The address is http://stackoverflow.com/";
      // $parts = preg_split('@(?=http://)@', $input);
      // var_dump($parts);
    }
    echo $content;
    return $content;
  }
}
