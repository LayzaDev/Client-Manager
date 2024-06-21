<?php
  include_once("../database/conexaoMysql.php");
  $connectionDB = mysqlConnect();

  // Informações da tabela client
  $username = htmlspecialchars(trim($_POST["username"] ?? ""));
  $cpf = htmlspecialchars(trim($_POST["cpf"] ?? ""));
  $sex = htmlspecialchars(trim($_POST["sex"] ?? ""));
  $birthday = htmlspecialchars(trim($_POST["birthday"] ?? ""));
  $maritalStatus = htmlspecialchars(trim($_POST["maritalStatus"] ?? ""));
  $email = htmlspecialchars(trim($_POST["email"] ?? ""));
  $phone = htmlspecialchars(trim($_POST["phone"] ?? ""));
  
  // Informações da tabela address_base
  $cep = htmlspecialchars(trim($_POST["cep"] ?? ""));
  $street = htmlspecialchars(trim($_POST["street"] ?? ""));
  $houseNumber = htmlspecialchars(trim($_POST["houseNumber"] ?? ""));
  $neighborhood = htmlspecialchars(trim($_POST["neighborhood"] ?? ""));
  $uf = htmlspecialchars(trim($_POST["uf"] ?? ""));
  $city = htmlspecialchars(trim($_POST["city"] ?? ""));

  $sql1 = "INSERT INTO client (username, cpf, sex, birthday, maritalStatus, email, phone) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $sql2 = "INSERT INTO address_base (cep, street, houseNumber, neighborhood, uf, city, idClient) VALUES (?, ?, ?, ?, ?, ?, ?)";

  try {
    $connectionDB->begin_transaction();
    
    $stmt1 = $connectionDB->prepare($sql1);
    if (!$stmt1) {
      throw new Exception("Prepare failed: " . $connectionDB->error);
    }
    $stmt1->bind_param("sssssss", $username, $cpf, $sex, $birthday, $maritalStatus, $email, $phone);
    if (!$stmt1->execute()) {
      throw new Exception("Execute failed: " . $stmt1->error);
    }

    $idClient = $connectionDB->insert_id;

    $stmt2 = $connectionDB->prepare($sql2);
    if (!$stmt2) {
      throw new Exception("Prepare failed: " . $connectionDB->error);
    }
    $stmt2->bind_param("sssissi", $cep, $street, $houseNumber, $neighborhood, $uf, $city, $idClient);
    if (!$stmt2->execute()) {
      throw new Exception("Execute failed: " . $stmt2->error);
    }

    $connectionDB->commit();
    header("Location: listingClient.php");
    exit();

  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>
