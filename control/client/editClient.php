<?php
  include_once("../../database/conexaoMysql.php");

  $connectionDB = mysqlConnect();

  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username'] ?? ""));
    $cpf = htmlspecialchars(trim($_POST['cpf'] ?? ""));
    $birthday = htmlspecialchars(trim($_POST['birthday'] ?? ""));
    $email = htmlspecialchars(trim($_POST['email'] ?? ""));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ""));

    $sql = <<<SQL
      UPDATE client 
      SET
        username = ?,
        cpf = ?,
        birthday = ?,
        email = ?,
        phone = ?
      WHERE id = $id;
    SQL;

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("sssss", $username, $cpf, $birthday, $email, $phone);

    if(!$stmt->execute()) throw new Error("Erro ao executar a consulta SQL");

    header("Location: ../../listing/listOfActiveClients.php");
    exit();
  }

  $sql = "SELECT * FROM client WHERE id = $id LIMIT 1";

  $result = $connectionDB->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Cliente</title>
  <link rel="stylesheet" href="../../css/register.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">Breezy <span>Clientes</span></div>
    <ul class="menu">
      <li><a href="../index.html">Início</a></li>
      <li><a href="../register/registerForm.html">Cadastro</a></li>
      <li><a href="#" class="active">Editar Cliente</a></li>
      <li><a href="../listing/listOfInactiveClients.php">Clientes inativos</a></li>
      <li><a href="../listing/listOfActiveAddresses.php">Endereços ativos</a></li>
      <li><a href="../listing/listOfInactiveAddresses.php">Endereços inativos</a></li>
    </ul>
  </nav>

  <!-- Formulário -->
  <div class="container text-left my-4">
    <h2 class="fw-bold">Editar</h2>
    <p class="text-muted">Atualize as informações abaixo e clique em "Atualizar".</p>

    <form class="row g-3" action="editClient.php?id=<?php echo $id; ?>" method="post">
      <?php while($client = $result->fetch_assoc()) { ?>
        <div class="col-md-6">
          <label for="username" class="form-label">Nome completo</label>
          <input type="text" name="username" id="username" class="form-control" required 
            value="<?php echo htmlspecialchars($client['username']); ?>">
        </div>

        <div class="col-md-6">
          <label for="phone" class="form-label">Telefone</label>
          <input type="tel" name="phone" id="phone" class="form-control" required 
            value="<?php echo htmlspecialchars($client['phone']); ?>">
        </div>

        <div class="col-md-6">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" name="email" id="email" class="form-control" required 
            value="<?php echo htmlspecialchars($client['email']); ?>">
        </div>

        <div class="col-md-6">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" name="cpf" id="cpf" class="form-control" required 
            value="<?php echo htmlspecialchars($client['cpf']); ?>">
        </div>

        <div class="col-md-6">
          <label for="birthday" class="form-label">Data de nascimento</label>
          <input type="date" name="birthday" id="birthday" class="form-control" required 
            value="<?php echo htmlspecialchars($client['birthday']); ?>">
        </div>
      <?php } ?>

      <div class="col-12 d-flex justify-content-center gap-5 mt-4">
        <a href="../../listing/listOfActiveClients.php" class="btn btn-outline-danger">Cancelar</a>
        <button type="submit" class="btn btn-success">Atualizar</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>