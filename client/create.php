<?php
  require "../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  // Informações da tabela client
  $username = $_POST["username"] ?? "";
  $cpf = $_POST["cpf"] ?? "";
  $sex = $_POST["sex"] ?? "";
  $birthday = $_POST["birthday"] ?? "";
  $maritalStatus = $_POST["maritalStatus"] ?? "";
  $email = $_POST["email"] ?? "";
  $phone = $_POST["phone"] ?? "";
  
  // Informações da tabela address_base
  $cep = $_POST["cep"] ?? "";
  $street = $_POST["street"] ?? "";
  $houseNumber = $_POST["houseNumber"] ?? "";
  $neighborhood = $_POST["neighborhood"] ?? "";
  $uf = $_POST["uf"] ?? "";
  $city = $_POST["city"] ?? "";

  $sql1 = <<< SQL
    INSERT INTO client (username, cpf, sex, birthday, maritalStatus, email, phone)
    VALUES(?, ?, ?, ?, ?, ?, ?)
  SQL;

  $sql2 = <<< SQL
    INSERT INTO address_base (cep, street, houseNumber, neighborhood, uf, city, idClient)
    VALUES(?, ?, ?, ?, ?, ?, ?)
  SQL;

  try {
    $pdo->beginTransaction();
    
    $stmt1 = $pdo->prepare($sql1);
    if(!$stmt1->execute([
      $username,
      $cpf,
      $sex, 
      $birthday, 
      $maritalStatus, 
      $email, 
      $phone
    ]))throw new Exception('Falha na primeira inserção');
    
    $idClient = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare($sql2);
    if(!$stmt2->execute([
      $cep, 
      $street, 
      $houseNumber, 
      $neighborhood, 
      $uf, 
      $city, 
      $idClient
    ]))throw new Exception('Falha na segunda inserção');
    
    $pdo->commit();
    header("location: index.php");
    exit();

  } catch (Exception $e) {
    $pdo->rollBack();
    if ($stmt1->errorInfo()[1] === 1062)
      exit('Dados duplicados: ' . $e->getMessage());
    else
      exit('Falha ao cadastrar os dados: ' . $e->getMessage());
  }
?>