<?php
  function mysqlConnect(){
    $db_host = "sql200.infinityfree.com";
    $db_username = "if0_36476911";
    $db_password = "projects2024";
    $db_name = "if0_36476911_mysql";
    $db_port = "3306";

    $options = [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $url = "mysql:host=$db_host;port=$db_port;dbname=$db_name";
      $pdo = new PDO($url, $db_username, $db_password, $options);
      return $pdo;
    } catch(Exception $e){
      exit("Falha na conexão com o MySQL: " . $e->getMessage());
    }
  }
?>