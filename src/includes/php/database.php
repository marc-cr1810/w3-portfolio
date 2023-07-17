<?php 
class MyDB extends SQLite3 {
  function __construct() {
      $this->open('../w3s-dynamic-storage/database.db');
  }
}

global $db;
$db = new MyDB();
?>