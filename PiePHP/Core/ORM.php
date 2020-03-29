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
    echo '<pre>';
    echo $sql;
    echo '</pre>';
    Database::executeThis($sql, $this->arr);
    return $this->stmt->rowCount();
  }
  
  public function delete($table, $id) //retourne un booleen
  {
    $sql = "DELETE FROM $table WHERE id = ? ;";
    echo '<pre></br>';
    echo $sql;
    echo '</br></pre>';
    Database::executeThis($sql, $id);
    return $this->stmt->rowCount();
  }

  private function fieldMaker()
  {
    $this->arr = [];
    $this->f = '';
    $this->v = '';
    $this->u = '';
    foreach ($this->fields as $table => $value) {
      if (array_key_last($this->fields) == $table) {
        $this->t .=  "`" . $table . "`";
        $this->v .= "?";
        $this->u .= " $table = ? ";
      } else {
        $this->t .=  "`" . $table . "`, ";
        $this->v .= "? , ";
        $this->u .= " $table = ? , ";
      }
      array_push($this->arr, $value);
    }
  }
}
