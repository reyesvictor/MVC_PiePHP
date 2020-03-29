<?php

namespace Core;

class ORM extends Database
{

  private $t;
  private $v;
  private $u;
  private $arr;
  private $fields;

  protected function create($table, $fields) //return last id
  {
    $this->fields = $fields;
    self::fieldMaker();
    $sql = "INSERT INTO {$table} ( $this->t ) VALUES ( $this->v ) ;";
    Database::executeThis($sql, $this->arr);
    return $this->id = $this->db->lastInsertId();
  }

  protected function read($table, $id) // retourne un tableau associatif de l' enregistrement
  {
    $sql = "SELECT * FROM $table WHERE id = ? ;";
    return Database::executeThis($sql, $id);
  }

  protected function update($table, $id, $fields) // retourne un booleen
  {
    $this->fields = $fields;
    self::fieldMaker();
    $sql = "UPDATE $table SET $this->u WHERE id = $id ;";
    Database::executeThis($sql, $this->arr);
    return $this->stmt->rowCount();
  }

  protected function delete($table, $id) //retourne un booleen
  {
    $sql = "DELETE FROM $table WHERE id = ? ;";
    Database::executeThis($sql, $id);
    return $this->stmt->rowCount();
  }
  
  public function find($table, $params) { // retourne un tableau d'enregistrements
    $this->fields = $params['WHERE'];
    self::fieldMaker();
    $ord = '';
    $lim = '';
    if (isset($params['ORDER BY'])) {
      $ord = "ORDER BY {$params['ORDER BY']} ";
    }
    if (isset($params['LIMIT'])) {
      $lim = "LIMIT {$params['LIMIT']} ";
    }
    $sql = "SELECT * FROM $table WHERE $this->where $ord $lim ;";
    echo '<pre></br>';
    echo $sql;
    echo '</br></pre>';
    return Database::executeThis($sql, $this->arr);
  }

  private function fieldMaker()
  {
    $this->arr = [];
    $this->t = '';
    $this->v = '';
    $this->u = '';
    $this->where = '';
    foreach ($this->fields as $table => $value) {
      if (array_key_last($this->fields) == $table) {
        $this->t .=  "`" . $table . "`";
        $this->v .= "?";
        $this->u .= " $table = ? ";
        $this->where .= " $table = ? ";
      } else {
        $this->t .=  "`" . $table . "`, ";
        $this->v .= "? , ";
        $this->u .= " $table = ? , ";
        $this->where .= " $table = ? AND ";
      }
      array_push($this->arr, $value);
    }
  }
}
