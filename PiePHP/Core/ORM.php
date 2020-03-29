<?php

namespace Core;

class ORM extends Database
{
  private $db;

  public function __construct() {
    $this->db = $this->connect();
  } 

  public function create ($table, $fields) {

    $orm = new ORM () ;
$orm -> create ('articles', array (
'titre ' => "un super titre" ,
'content ' => 'et voici une super article de blog',
'author ' => 'Rodrigue'
) ) ;

//-------------------------------------

$column = '';
$values = '';
$inValues = '';
foreach($fields as $key => $value)
{
    $column .= "$key";
    $values .= "$value";  
    $inValues .= "?"; 
    if (array_key_last($fields) !== $key)
        $column .= ', ';
    if (end($fields) !== $value)
    {
        $values .= ', ';
        $inValues .= ", ";
    }
        
        
}
$values = explode(',', $values);

$sql = "INSERT INTO $table ($column) VALUES ($inValues)";
$stmt = $this->connect()->prepare($sql);
$stmt->execute($values);

//----------------------------------------
$executeArray = [];
$query = "INSERT INTO $table (";

foreach ($fields as $key => $value) {
    $query .= "$key ,";
}

$query = substr($query, 0, -2);
$query .= ") VALUES (";

foreach ($fields as $key => $value) {
    $query .= "?, ";
    array_push($executeArray, $value);
}

$query = substr($query, 0, -2);
$query .= ")";

$req = $this->conn->prepare($query);
$req->execute($executeArray);
return $this->conn->lastInsertId();

    // return id;
  } // retourne un id

}
