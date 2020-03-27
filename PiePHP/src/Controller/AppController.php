<?php

// require_once AUTOLOADER_URI;

namespace Controller;

class AppController extends \Core\Controller
{
  public function indexAction()
  {
    echo 'AppController + indexAction ' . PHP_EOL;
  }
}