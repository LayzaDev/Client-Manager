<?php
  include_once("../database/conexaoMysql.php");
  $connectionDB = mysqlConnect();

  try {

    $sql = <<< SQL
      SELECT 
        c.id, c.username, a.cep, a.street, a.houseNumber, a.neighborhood, a.uf, a.city, a.register
      FROM client c, address_base a
      WHERE a.idClient = c.id AND a.register = "Inativo"
      ORDER BY c.id;
    SQL;

    $result = $connectionDB->query($sql);

  } catch (Exception $e) {
    exit('Ocorreu uma falha na consulta ao Banco de Dados: ' . $e->getMessage());
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Endereços Inativos</title>
  <link rel="stylesheet" href="../css/index2.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">Breezy <span>Clientes</span></div>
    <ul class="menu">
      <li><a href="../index.html">Início</a></li>
      <li><a href="register/registerForm.html">Cadastro</a></li>
      <li><a href="listing/listOfActiveClients.php">Clientes Ativos</a></li>
      <li><a href="listing/listOfInactiveClients.php">Clientes Inativos</a></li>
      <li><a href="listing/listOfActiveAddresses.php">Endereços Ativos</a></li>
      <li><a href="#" class="active">Endereços Inativos</a></li>
    </ul>
  </nav>

  <div class="container text-left my-4">
    <h2 class="fs-4">Endereços Inativos</h2>
    <p class="text-muted">Lista de todos os endereços com cadastro inativo</p>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Cliente</th>
            <th>CEP</th>
            <th>Logradouro</th>
            <th>Número</th>
            <th>Bairro</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['cep']}</td>";
            echo "<td>{$row['street']}</td>";
            echo "<td>{$row['houseNumber']}</td>";
            echo "<td>{$row['neighborhood']}</td>";
            echo "<td>{$row['uf']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['register']}</td>";
            echo "<td>
                    <a class='btn btn-sm btn-outline-success' href='../control/address/reactivateRegistrationAddress.php?id={$row['id']}'>Reativar</a>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
      <!-- Footer -->
  <footer class="text-center py-4 border-top">
    <p class="mb-0">@ By Layza Nauane</p>
  </footer>
    </div>
  </div>
</body>
</html>