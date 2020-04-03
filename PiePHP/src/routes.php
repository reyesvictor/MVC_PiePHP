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

Core\Router::connect ('/user/{id}', ['controller' => 'user', 'action' => 'show']);


//TEST PARAMETRIQUE
//J'aimerai créer une variable `globale partir du lien dans ce fichier,
//pour m'en resservir dans le show($id)
//cependant ce fichier permet de créer un array...
//Décomposer le REQUEST['URI'] ? et créer une supergloable en fonction ? AAAAAAAAH Je comprends rien.
// Core\Router::connect ( '/user' . '/' . path(),  ['controller' => 'user', 'action' => 'show']);
// Core\Router::connect ( '/user' . '/'. path() . '/',  ['controller' => 'user', 'action' => 'show']);

// function path() {
//   //verifier si lutilisateur existe
//   $path = array_values(array_filter((explode('/', $_SERVER['REQUEST_URI'])), function ($v) {
//     return $v !== 'PiePHP' && $v !== '';
//   }, ARRAY_FILTER_USE_BOTH));
//   if ( isset($path) && count($path) > 1 ) {
//     $GLOBAL['id'] = $path[1];
//   } else { //sinon rediriger vers 404
//     $GLOBAL['id'] = '';
//   }
//   return $GLOBAL['id'];
// }