<?php

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

echo '<h3>HomePage</h3>';
// echo "\n\n\n\n\n\n\n\n";
// echo '============POST===============</br>' . PHP_EOL;
// var_dump($_POST);
// echo '</br>'  ;
// echo '=============GET===============' . PHP_EOL;
// var_dump($_GET);
// echo '============SERVER===============' . PHP_EOL;
// var_dump($_SERVER);
// echo '============END===============</br>' . PHP_EOL;
// echo "\n\n\n\n\n\n\n\n";
// echo '</pre>';
