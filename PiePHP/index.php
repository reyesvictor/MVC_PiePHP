<?php

// if (!file_exists($_SERVER['SCRIPT_FILENAME'])) {
//   header("Location: /PiePHP/");
//   exit();
// } 

// var_dump($_SERVER);
// echo __DIR__;

//REDIRECT IF LOOKING FOR INDEX.PHP FILE
// if ( $_SERVER['SCRIPT_FILENAME'] == 'C:/xampp/htdocs/PiePHP/index.php' ) {
//   header("Location: /PiePHP/");
//   exit();
// }

//FUNCTION / \ REPLACER
function url($value)
{
  return str_replace('\\', '/', $value);
}

//CREATE CONSTANT AND REDIRECT
define('AUTOLOADER_URI', url(__DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, ['Core', 'autoload.php'])));
define('PATH_ORIGIN', url(__DIR__ . DIRECTORY_SEPARATOR));

// echo 'origin:  ' . __DIR__ . PHP_EOL;
// echo 'path:  ' . PATH_ORIGIN . PHP_EOL;
// echo 'auto:  ' . AUTOLOADER_URI . PHP_EOL;


require_once AUTOLOADER_URI;

//CLASS DECLARE
$app = new Core\Core();
$app->run();

// define ('BASE_URI', url( substr ( __DIR__ , strlen ( $_SERVER['REDIRECT_URL']) ) ) );
// define('AUTOLOADER_URI', $_SERVER['PATH_TRANSLATED'] . $_SERVER['REDIRECT_URL'] . url( implode ( DIRECTORY_SEPARATOR , ['Core', 'autoload.php']) ));
// require_once AUTOLOADER_URI ;

// $app = new Core\Core () ;
// $app -> run () ;


// echo "\n\n\n\n\n\n\n\n";
// echo '============POST===============' . PHP_EOL;
// var_dump($_POST);
// echo '=============GET===============' . PHP_EOL;
// var_dump($_GET);
// echo '============SERVER===============' . PHP_EOL;
// var_dump($_SERVER);
// echo '============END===============' . PHP_EOL;
// echo "\n\n\n\n\n\n\n\n";