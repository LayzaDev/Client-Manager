<?php
  include_once("../database/conexaoMysql.php");
  $connectionDB = mysqlConnect();

  try {
    $sql = <<<SQL
      SELECT 
        c.id, 
        c.username, 
        a.cep, 
        a.street, 
        a.houseNumber, 
        a.neighborhood, 
        a.uf, 
        a.city, 
        a.register
      FROM client AS c
      INNER JOIN address_base AS a ON a.idClient = c.id
      WHERE a.register = ?
      ORDER BY c.id
    SQL;

    $stmt = $connectionDB->prepare($sql);
    $status = "Ativo";
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();

  } catch (Exception $e) {
    exit('Ocorreu uma falha na consulta ao Banco de Dados: ' . $e->getMessage());
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Endereços Ativos</title>
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
      <li><a href="#" class="active">Endereços Ativos</a></li>
      <li><a href="../listing/listOfInactiveAddresses.php">Endereços inativos</a></li>
    </ul>
  </nav>

  <!-- Título -->
  <div class="container text-left my-4">
    <h2 class="fs-4">Endereços Ativos</h2>
    <p class="subtitle">Lista de todos os endereços com cadastro ativo</p>
  </div>

  <!-- Tabela -->
  <div class="container">
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
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['username']) ?></td>
              <td><?= htmlspecialchars($row['cep']) ?></td>
              <td><?= htmlspecialchars($row['street']) ?></td>
              <td><?= htmlspecialchars($row['houseNumber']) ?></td>
              <td><?= htmlspecialchars($row['neighborhood']) ?></td>
              <td><?= htmlspecialchars($row['uf']) ?></td>
              <td><?= htmlspecialchars($row['city']) ?></td>
              <td><?= htmlspecialchars($row['register']) ?></td>
              <td>
                <a class="btn btn-sm btn-outline-primary" href="../control/address/editAddress.php?id=<?= urlencode($row['id']) ?>">Editar</a>
                <a class="btn btn-sm btn-outline-danger" href="../control/address/cancelRegistrationAddress.php?id=<?= urlencode($row['id']) ?>">Inativar</a>
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
</body>
</html>