<?php
  function mysqlConnect(){
    $db_host = "sql200.infinityfree.com";
    $db_username = "if0_36476911";
    $db_password = "projects2024";
    $db_name = "if0_36476911_mysql";
    $db_port = 3306;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
      $connectionDB = new mysqli($db_host, $db_username, $db_password, $db_name, $db_port);
      $connectionDB->set_charset("utf8mb4");

      return $connectionDB;

    } catch (mysqli_sql_exception $e){  

      error_log($e->getMessage());
      exit("Falha na conexão com o MySQL.");

    }
  }
?>
