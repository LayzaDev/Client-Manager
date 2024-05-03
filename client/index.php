<?php
  require "../database/conexaoMysql.php";
  $pdo = mysqlConnect();

  try {
    $sql = <<< SQL
      SELECT c.*, b.* FROM client c 
      INNER JOIN address_base b ON b.idClient = c.id;
    SQL;

    $stmt = $pdo->query($sql);

  } catch (Exception $e) {
    exit('Ocorreu uma falha: ' . $e->getMessage());
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listagem de Clientes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <style>
    body {
      padding-top: 2rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <h3>Clientes e seus endereços</h3>
    <table class="table table-striped table-hover">
      <tr>
        <th></th>
        <th>Cliente</th>
        <th>CPF</th>
        <th>E-mail</th>
        <th>Telefone</th>
        <th>CEP</th>
        <th>Logradouro</th>
        <th>Numero</th>
        <th>Bairro</th>
        <th>Estado</th>
        <th>Cidade</th>
      </tr>

      <?php
        while($row = $stmt->fetch()){
          $username = htmlspecialchars($row['username']);
          $cpf = htmlspecialchars($row['cpf']);
          $email = htmlspecialchars($row['email']);
          $phone = htmlspecialchars($row['phone']);
          $cep = htmlspecialchars($row['cep']);
          $street = htmlspecialchars($row['street']);
          $houseNumber = htmlspecialchars($row['houseNumber']);
          $neighborhood = htmlspecialchars($row['neighborhood']);
          $uf = htmlspecialchars($row['uf']);
          $city = htmlspecialchars($row['city']);

          echo <<<HTML
            <tr>
              <td>$username</td>
              <td>$cpf</td>
              <td>$email</td>
              <td>$phone</td>
              <td>$cep</td>
              <td>$street</td>
              <td>$houseNumber</td>
              <td>$neighborhood</td>
              <td>$uf</td>
              <td>$city</td>
            </tr>
          HTML;
        }
      ?>
    </table>
    <a href="../index.html">Menu de opções</a>
  </div>
</body>
</html>