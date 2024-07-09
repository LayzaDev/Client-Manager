<?php
  include_once("../../database/conexaoMysql.php");

  $connectionDB = mysqlConnect();

  $id = $_GET["id"];

  try {
    $connectionDB->begin_transaction();

    $sql = <<<SQL
      UPDATE client
      SET register = 'Ativo'
      WHERE id = ?
    SQL;

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $connectionDB->commit();
    header("Location: ../../listing/listOfInactiveClients.php");
    exit();
  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>
