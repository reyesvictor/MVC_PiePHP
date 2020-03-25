<?php

// CONNECT TO THE DATABASE HOST
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $dbName = "piephp";
    // private $host = "remotemysql.com";
    // private $user = "lTsiPIi4Qh";
    // private $pwd = "nUKWNJXLKN";
    // private $dbName = "lTsiPIi4Qh";

    //CONNEXION TO THE DATABASE
    protected function connect() 
    {
        $dsn = 'mysql:host=' . $this->host . ';port=3306;dbname=' . $this->dbName;
        $pdo = new PDO($dsn,  $this->user,  $this->pwd);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}