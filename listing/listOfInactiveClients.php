<?php
  include_once("../database/conexaoMysql.php");
  $connectionDB = mysqlConnect();

  try {

    $sql = <<< SQL
      SELECT * FROM client WHERE register = "Inativo";
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
  <title>Clientes Inativos</title>
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
      <li><a href="#" class="active">Clientes Inativos</a></li>
      <li><a href="../listing/listOfActiveAddresses.php">Endereços ativos</a></li>
      <li><a href="../listing/listOfInactiveAddresses.php">Endereços inativos</a></li>
    </ul>
  </nav>

  <!-- Título -->
  <div class="container text-left my-4">
    <h2 class="fs-4">Clientes Inativos</h2>
    <p class="subtitle">Lista de todos os clientes com cadastro inativo</p>
  </div>

  <!-- Tabela -->
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['username'] ?></td>
              <td><?= $row['cpf'] ?></td>
              <td><?= $row['birthday'] ?></td>
              <td><?= $row['email'] ?></td>
              <td><?= $row['phone'] ?></td>
              <td><?= $row['register'] ?></td>
              <td>
                <a class="btn btn-sm btn-outline-success" 
                   href="../control/client/reactivateRegistrationClient.php?id=<?= $row['id'] ?>">
                  Reativar
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center py-4 border-top">
    <p class="mb-0">@ By Layza Nauane</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>