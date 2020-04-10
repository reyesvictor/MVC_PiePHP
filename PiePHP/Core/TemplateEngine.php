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

    //testvide
    $vide = FALSE;
    $a = 45;
    $b =8;
    extract($scope);
    $pregverif = [
      'foreach' => '/\@foreach(.*)\)/',
      'isset' => '/\@isset/',
      'if' => '/\@if/', 
      'echo' => '/{{(.+)}}/', 
      'empty' => '/\@empty/', 
      'html' => '/<(.*)>/s'
    ];
    
    $pregrep = [
      'foreach' => [ //if its all in the same line
        ['/@foreach(.*)\)/', '/\@endforeach/'],
        ["foreach $1 ) {", '}']
      ],
      'isset' => [
        ['/\@isset(.*)\)/', '/\@endisset/'],
        ['if ( isset $1 ) ) {', '}']
      ], 
      'if' => [
        ['/@if(.*)\)/', '/\@elseif(.*)\)/', '/\@else/', '/\@endif/'],
        ['if $1 ) {', '} else if $1 ) {', '} else {', '}']
      ],
      'echo' => [
        ['/{{(.+)}}/'],
        ['echo $1 ;']
      ],
      'empty' => [
        ['/@empty(.*)\)/'],
        [ 'if ( empty $1 ) ) {']
        ],
      'html' => [
        ['/<(.*)>/'],
        ['echo "<$1>";']
      ]
    ];

    $all_lines = explode(PHP_EOL, static::$content);
    $list = [];
      foreach ($pregverif as $key => $regex) {
        if (preg_match_all($regex, static::$content, $matches)) {
          static::$content = preg_replace($pregrep[$key][0], $pregrep[$key][1], static::$content);
        }
      }
    eval(static::$content);
  }
}