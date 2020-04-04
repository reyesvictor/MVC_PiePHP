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
    /*highlight_string("<?php\n\$data =\n" . var_export($array) . ";\n?>");    */
    $content = file_get_contents($f);
    // var_dump($content);
    if ($res = preg_match_all('/{{(.+)}}/', $content, $matches) != false) {
      // var_dump($matches);
      // $content = preg_replace('/{{/', '<?= htmlentities( ', $content);
      /*
      $content = preg_replace('/{{/', '<?= ( ', $content);
      $content = preg_replace('/}}/', ' ) ?>', $content);
      */
      $content = preg_replace('/{{/', '', $content);
      $content = preg_replace('/}}/', '', $content);

      if (array_key_exists($key = str_replace([' ', '$'], '', $matches[1][0]), self::$info)) { // si la variable existe dans le array, on le replace

        $var_preg = '/' . str_replace(' ', '', $matches[1][0]) . '/';
        $var_name = str_replace(' ', '', $matches[1][0]);
        $content = preg_replace($var_preg, self::$info[$key], $content);
        $content = preg_replace("/$var_name/", self::$info[$key], $content);
        $content = preg_replace("/" . $var_name . "/", self::$info[$key], $content);
        $content = preg_replace("/^" . $var_name . "/", self::$info[$key], $content);
        $content = preg_replace('/' . $var_name . '/', self::$info[$key], $content);
        $content = preg_replace('/^' . $var_name . '/', self::$info[$key], $content);
        $content = preg_replace("/^$var_name/", self::$info[$key], $content);
        //ca remplace les 'e', why ????
        $content = preg_replace('/:$cheval\b/i', self::$info[$key], $content);
        $content = preg_replace('/:' . $var_name .  '\b/i', self::$info[$key], $content);
        $content = preg_replace('/\b' . $var_name .  '\b/i', self::$info[$key], $content);
        $content = preg_replace('/:' . $var_name .  '\b/', self::$info[$key], $content);
        $content = preg_replace("/:$var_name\b/i", self::$info[$key], $content);
        $content = preg_replace("/\b$var_name\b/i", self::$info[$key], $content);
        $content = preg_replace("/:$var_name\b/", self::$info[$key], $content);
        $content = preg_replace("/\b$var_name\b/", self::$info[$key], $content);

        //WORKS 
        $content = str_replace($var_name, self::$info[$key], $content);
        // echo '--------<pre>';
        // echo $key;
        // echo '<br>';
        // var_dump($var_name);
        // echo '<br>';
        // echo self::$info[$key];
        // echo '</br>--------</br></pre>';
      }
    }
    return $content;
  }
}
