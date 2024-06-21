<?php
  include_once("../database/conexaoMysql.php");

  $connectionDB = mysqlConnect();

  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username'] ?? ""));
    $cpf = htmlspecialchars(trim($_POST['cpf'] ?? ""));
    $sex = htmlspecialchars(trim($_POST['sex'] ?? ""));
    $birthday = htmlspecialchars(trim($_POST['birthday'] ?? ""));
    $maritalStatus = htmlspecialchars(trim($_POST['maritalStatus'] ?? ""));
    $email = htmlspecialchars(trim($_POST['email'] ?? ""));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ""));

    $sql = <<<SQL
      UPDATE client 
      SET
        username = ?,
        cpf = ?,
        sex = ?,
        birthday = ?,
        maritalStatus = ?,
        email = ?,
        phone = ?
      WHERE id = $id;
    SQL;

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("sssssss", $username, $cpf, $sex, $birthday, $maritalStatus, $email, $phone);

    if(!$stmt->execute()) throw new Error("Erro ao executar a consulta SQL");

    header("Location: listingClient.php");
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
  <link rel="stylesheet" href="index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body id="body">
  <a href="listingClient.php">Voltar</a>
  <div class="container">
    <main>
      <form class="form" action="editClient.php?id=<?php echo $id; ?>" method="post">
        <?php
          while($client = $result->fetch_assoc()){
        ?>
          <fieldset>
            <legend>Dados do Cliente</legend>
            <div class="row g-2">
              <div class="col-9">
                <label for="username" class="form-label">Nome completo</label>
                <input type="text" name="username" class="form-control" id="username" required value="<?php echo htmlspecialchars($client['username']); ?>">
              </div>
              <div class="col-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" id="cpf" required value="<?php echo htmlspecialchars($client['cpf']); ?>">
              </div>
              <div class="col-sm">
                <label for="sex" class="form-label">Sexo</label>
                <select name="sex" id="sex" class="form-select" required value="<?php echo htmlspecialchars($client['sex']); ?>">
                  <option value="">Selecione</option>
                  <option value="F" <?php if($client['sex'] == 'F') echo 'selected'?>>Feminino</option>
                  <option value='M' <?php if($client['sex'] == 'M') echo 'selected'?>>Masculino</option>
                </select>
              </div>
              <div class="col-sm">
                <label for="birthday" class="form-label">Data de nascimento</label>
                <input type="date" name="birthday" class="form-control" id="birthday" required value="<?php echo htmlspecialchars($client['birthday']); ?>">
              </div>
              <div class="col-sm">
                <label for="maritalStatus" class="form-label">Estado Civil</label>
                <select name="maritalStatus" class="form-select" id="maritalStatus" required value="<?php echo htmlspecialchars($client['maritalStatus']); ?>">
                  <option selected>Selecione</option>
                  <option value="solteiro" <?php if($client['maritalStatus'] == 'solteiro') echo 'selected'?>>Solteiro</option>
                  <option value="casado" <?php if($client['maritalStatus'] == 'casado') echo 'selected'?>>Casado</option>
                  <option value="viuvo" <?php if($client['maritalStatus'] == 'viuvo') echo 'selected'?>>Viúvo</option>
                  <option value="outro" <?php if($client['maritalStatus'] == 'outro') echo 'selected'?>>Outro</option>
                </select>
              </div>
            </div>
            <div class="row g-2">
              <div class="col-sm-9">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" id="email" required value="<?php echo htmlspecialchars($client['email']); ?>">
              </div>
              <div class="col-sm-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="tel" name="phone" id="phone" class="form-control" required value="<?php echo htmlspecialchars($client['phone']); ?>">
              </div>
            </div>
          </fieldset>
        <?php
          }
        ?>
        <div class="col-12" id="button">
          <button type="submit" class="btn btn-primary">Confirmar</button>
        </div>
      </form>
    </main>
  </div>
  <script src="ajax.js"></script>
</body>
</html>