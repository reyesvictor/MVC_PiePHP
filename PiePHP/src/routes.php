<?php

echo 'src\routes.php [ OK ]' . PHP_EOL;

Core\Router::connect ('/', ['controller' => 'app', 'action' => 'index']) ;
Core\Router::connect ('/register', ['controller' => 'user', 'action' => 'add']) ;