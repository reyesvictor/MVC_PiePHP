<?php

Core\Router::connect ('/', ['controller' => 'app', 'action' => 'index']);
Core\Router::connect ('/register', ['controller' => 'user', 'action' => 'add']);
Core\Router::connect ('/register/', ['controller' => 'user', 'action' => 'add']);
Core\Router::connect ('/login', ['controller' => 'user', 'action' => 'login']);
Core\Router::connect ('/login/', ['controller' => 'user', 'action' => 'login']);
Core\Router::connect ('/show', ['controller' => 'user', 'action' => 'show']);
Core\Router::connect ('/show/', ['controller' => 'user', 'action' => 'show']);
Core\Router::connect ('/logout', ['controller' => 'user', 'action' => 'logout']);
Core\Router::connect ('/logout/', ['controller' => 'user', 'action' => 'logout']);