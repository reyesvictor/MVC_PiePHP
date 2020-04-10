<?php

namespace Core;

class TemplateEngine extends Controller
{
  static $content;
  public function parse($scope, $f)
  {







    
    foreach ($scope as $key => $value) {
      $this->{$key} = $value;
    }
    static::$content = file_get_contents($f);

    //Compileur fait main, à l'ancienne
    $all_lines = explode(PHP_EOL, static::$content);
    $list = [];
    for ($i = 0; $i < count($all_lines); $i++) { //Analyse line by line the page
      if (preg_match_all('/\@foreach/', $all_lines[$i])) {
        array_push($list, 'parseforeach');
      } else if (preg_match_all('/\@if/', $all_lines[$i])) {
        array_push($list, 'parseif');
      } else if (preg_match_all('/{{(.+)}}/', $all_lines[$i])) {
        array_push($list, 'parsestring');
      } else if (preg_match_all('/\@isset/', $all_lines[$i])) {
        array_push($list, 'parseisset');
      }
    }
    for ($i = 0; $i < count($list); $i++) { //Call all the functions in order
      $this->{$list[$i]}();
    }
    return static::$content;
  }

  public function parseforeach()
  {
    // if (preg_match_all('/@foreach(.*?)@endforeach/s', static::$content, $matches)) {
    // }
    $arr = preg_split("@(?=\@foreach)@", static::$content, 2, PREG_SPLIT_DELIM_CAPTURE); // $arr[0] => text before, $arr[1] => text with foreach
    $arr[1] = preg_replace('/@foreach/', 'foreach', $arr[1], 1);
    $arr[1] = preg_replace('/\)/', ') {', $arr[1], 1);
    $arr[1] = preg_replace('/@endforeach/', '}-end-', $arr[1], 1);
    $foreach = preg_split("/-end-/", $arr[1], 2); //foreach[0] => foreach php code, foreach[1] => following content

    //Parsetag before eval()
    echo $arr[0]; //text before foreach
    if (preg_match_all('/<(.*)>/s', $foreach[0], $tag)) {
      $parsed = "echo \"" . $tag[0][0] . "\";";
      $foreach[0] = preg_replace('/<(.*)>/s', $parsed, $foreach[0], 1);
    }
    eval($foreach[0]); //foreach
    static::$content = $foreach[1]; //text after foreach
  }

  public function parseif($opt = null)
  {
    if ( isset($opt) ) {

    }
    // if (preg_match_all('/@if(.*?)@endif|\):|@else:/s', static::$content, $matches)) {
    static::$content = preg_replace('/@if/', 'if', static::$content, 1);
    while (preg_match_all('/@elseif/', static::$content, $matches)) {
      static::$content = preg_replace('/@elseif/', '} else if', static::$content, 1);
    }
    while (preg_match_all('/\)\:/', static::$content, $matches)) {
      static::$content = preg_replace('/\)\:/', ') {', static::$content, 1);
    }
    static::$content = preg_replace('/@else:/', '} else {', static::$content, 1);
    static::$content = preg_replace('/@endif/', '}-end-', static::$content, 1);
    // }
    $a = 8;
    $b = 13;
    $arr = preg_split("@(?=if \()@", static::$content, 2, PREG_SPLIT_DELIM_CAPTURE);
    $if = preg_split("/-end-/", $arr[1], 2);

    echo $arr[0]; //text before if
    eval($if[0]); //if
    static::$content = $if[1]; //after if
  }

  public function parsestring()
  {
    preg_match_all('/{{(.+)}}/', static::$content, $matches);
    static::$content = preg_replace('/{{/', '', static::$content, 1);
    static::$content = preg_replace('/}}/', '', static::$content, 1);
    $var_name = str_replace([' ', '$'], '', $matches[1][0]);
    $var_fullname = str_replace([' '], '', $matches[1][0]);
    static::$content = str_replace($var_fullname, htmlentities($this->{$var_name}), static::$content);
  }

  public function parseisset()
  {
    $arr = preg_split("@(?=\@isset)@", static::$content, 2, PREG_SPLIT_DELIM_CAPTURE); // $arr[0] => text before, $arr[1] => text with foreach
    $arr[1] = preg_replace('/\@isset/', 'if ( isset', $arr[1], 1);
    $arr[1] = preg_replace('/\)/', ') ) {', $arr[1], 1);
    $arr[1] = preg_replace('/\@endisset/', '}-end-', $arr[1], 1);
    $foreach = preg_split("/-end-/", $arr[1], 2); //foreach[0] => foreach php code, foreach[1] => following content

    //Parsetag before eval()
    echo $arr[0]; //text before foreach
    if (preg_match_all('/<(.*)>/s', $foreach[0], $tag)) {
      $parsed = "echo \"" . $tag[0][0] . "\";";
      $foreach[0] = preg_replace('/<(.*)>/s', $parsed, $foreach[0], 1);
    }
    static::$content = $foreach[1]; //text after foreach
    var_dump($foreach[0]);
    if ( preg_match_all('/\@foreach|\@if|{{(.+)}}|\@isset|\@empty/', $foreach[0], $matches)) {
      $function = "parse" . substr($matches[0][0], 1);
      $var = $this->{$function}($foreach[0]);
      eval($var);
    } else {
      eval($foreach[0]); //foreach
    }
  }




}
