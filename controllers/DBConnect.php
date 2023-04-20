<?php

class DBConnect {

  function __construct() {

    $db_user = $_ENV['system']->db_user;
    $db_pass = $_ENV['system']->db_pass;
    try {
      $conn = new PDO("mysql:host=;dbname=", $db_user, $db_pass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->conn = $conn;
    } catch(PDOException $e) {
      $this->conn = "Connection failed: " . $e->getMessage();
    }
  }

  public function db_query($query, $args) {
    try {
      $q = $this->conn->prepare($query);
      $q->execute($args);
    } catch(PDOException $e) {
      $this->conn = "Insert failed: " . $e->getMessage();
    }
  }
}