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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/universal.css">
  <link rel="stylesheet" href="../../css/edit.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
  <header>
    <h1>Cadastro</h1>
  </header>
  <main>
    <form class="form" action="editClient.php?id=<?php echo $id; ?>" method="post">
      <h2>Editar Cliente</h2>
      <?php
        while($client = $result->fetch_assoc()){
      ?>
        <div class="row">
          <div class="item col-12">
            <label for="username" class="form-label">Nome completo</label>
            <input type="text" name="username" class="form-control" id="username" required value="<?php echo htmlspecialchars($client['username']); ?>">
          </div>
        </div>
        <div class="row">
          <div class="item col-12">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" required value="<?php echo htmlspecialchars($client['email']); ?>">
          </div>
        </div>
        <div class="row">
          <div class="item col-4">
            <label for="birthday" class="form-label">Data de nascimento</label>
            <input type="date" name="birthday" class="form-control" id="birthday" required value="<?php echo htmlspecialchars($client['birthday']); ?>">
          </div>
          <div class="item col-4">
            <label for="cpf" class="form-label">CPF</label>  
            <input type="text" name="cpf" class="form-control" id="cpf" required value="<?php echo htmlspecialchars($client['cpf']); ?>">
          </div>
          <div class="item col-4">
            <label for="phone" class="form-label">Telefone</label>
            <input type="tel" name="phone" id="phone" class="form-control" required value="<?php echo htmlspecialchars($client['phone']); ?>">
          </div>
        </div>
      <?php
        }
      ?>
      <div class="button">
        <a href="../../listing/listOfActiveClients.php" class="btn btn-danger">Cancelar</a>
        <div>
          <button type="submit" class="btn btn-success">Atualizar</button>
        </div>
      </div>
    </form>
  </main>
  <footer>
    <p>@ By Layza Nauane</p>
  </footer>
  <script src="../ajax.js"></script>
</body>
</html>