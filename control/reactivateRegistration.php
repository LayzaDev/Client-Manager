<?php
  include_once("../database/conexaoMysql.php");

  $connectionDB = mysqlConnect();

  $id = $_GET["id"];

  try {
    $connectionDB->begin_transaction();

    $sql1 = <<<SQL
      UPDATE client
      SET register = 'Ativo'
      WHERE id = ?
    SQL;

    $stmt1 = $connectionDB->prepare($sql1);
    $stmt1->bind_param("i", $id);
    $stmt1->execute();

    $sql2 = <<<SQL
      UPDATE address_base
      SET register = 'Ativo'
      WHERE idClient = ?
    SQL;

    $stmt2 = $connectionDB->prepare($sql2);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();

    $connectionDB->commit();
    header("Location: ../listing/listOfActiveClients.php");
    exit();
  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>
