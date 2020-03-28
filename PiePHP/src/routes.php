<?php

// echo 'src\routes.php [ OK ]' . PHP_EOL;

Core\Router::connect ('/', ['controller' => 'app', 'action' => 'index']);
Core\Router::connect ('/register', ['controller' => 'user', 'action' => 'add']);
Core\Router::connect ('/register/', ['controller' => 'user', 'action' => 'add']); 
Core\Router::connect ('/login', ['controller' => 'user', 'action' => 'login']);
Core\Router::connect ('/login/', ['controller' => 'user', 'action' => 'login']); 

//FORM REGISTER USER
// Core\Router::connect ('/registerthisuser', ['controller' => 'user', 'action' => 'register']);
// Core\Router::connect ('/registerthisuser/', ['controller' => 'user', 'action' => 'register']);