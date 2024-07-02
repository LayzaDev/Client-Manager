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
  
  $birthday = date('Y-m-d', strtotime($birthday));

  // Informações da tabela address_base
  $cep = htmlspecialchars(trim($_POST["cep"] ?? ""));
  $street = htmlspecialchars(trim($_POST["street"] ?? ""));
  $houseNumber = htmlspecialchars(trim($_POST["houseNumber"] ?? ""));
  $neighborhood = htmlspecialchars(trim($_POST["neighborhood"] ?? ""));
  $uf = htmlspecialchars(trim($_POST["uf"] ?? ""));
  $city = htmlspecialchars(trim($_POST["city"] ?? ""));

  $register = "Ativo";
  $sql1 = "INSERT INTO client (username, cpf, sex, birthday, maritalStatus, email, phone, register) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $sql2 = "INSERT INTO address_base (cep, street, houseNumber, neighborhood, uf, city, idClient, register) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

  try {
    $connectionDB->begin_transaction();
    
    $stmt1 = $connectionDB->prepare($sql1);
    if (!$stmt1) {
      throw new Exception("Prepare failed: " . $connectionDB->error);
    }
    $stmt1->bind_param("ssssssss", $username, $cpf, $sex, $birthday, $maritalStatus, $email, $phone, $register);
    if (!$stmt1->execute()) {
      throw new Exception("Execute failed: " . $stmt1->error);
    }

    $idClient = $connectionDB->insert_id;

    $stmt2 = $connectionDB->prepare($sql2);
    if (!$stmt2) {
      throw new Exception("Prepare failed: " . $connectionDB->error);
    }
    $stmt2->bind_param("ssisssis", $cep, $street, $houseNumber, $neighborhood, $uf, $city, $idClient, $register);
    if (!$stmt2->execute()) {
      throw new Exception("Execute failed: " . $stmt2->error);
    }

    $connectionDB->commit();
    header("Location: ../listing/listOfActiveClients.php");
    exit();

  } catch (Exception $e) {
    $connectionDB->rollback();
    exit('Rollback executado: ' . $e->getMessage());
  }
?>
