<?php
  include_once("../../database/conexaoMysql.php");

  $connectionDB = mysqlConnect();

  $id = $_GET['id'];

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cep = htmlspecialchars(trim($_POST['cep'] ?? ""));
    $street = htmlspecialchars(trim($_POST['street'] ?? ""));
    $houseNumber = htmlspecialchars(trim($_POST['houseNumber'] ?? ""));
    $neighborhood = htmlspecialchars(trim($_POST['neighborhood'] ?? ""));
    $uf = htmlspecialchars(trim($_POST['uf'] ?? ""));
    $city = htmlspecialchars(trim($_POST['city'] ?? ""));

    $sql = <<<SQL
      UPDATE address_base 
      SET
        cep = ?,
        street = ?,
        houseNumber = ?,
        neighborhood = ?,
        uf = ?,
        city = ?
      WHERE id = $id;
    SQL;

    $stmt = $connectionDB->prepare($sql);
    $stmt->bind_param("ssssss", $cep, $street, $houseNumber, $neighborhood, $uf, $city);

    if(!$stmt->execute()) throw new Exception("Erro ao executar a consulta SQL");

    header("Location: ../../listing/listOfActiveAddresses.php");
    exit();
  }

  $sql = "SELECT * FROM address_base WHERE id = $id LIMIT 1";

  $result = $connectionDB->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Endereço</title>
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
      <li><a href="../listing/listOfActiveClients.php">Clientes ativos</a></li>
      <li><a href="../listing/listOfInactiveClients.php">Clientes inativos</a></li>
      <li><a href="#" class="active">Editar Endereço</a></li>
      <li><a href="../listing/listOfInactiveAddresses.php">Endereços inativos</a></li>
    </ul>
  </nav>

  <main class="form-container">
    <h1>Editar Endereço</h1>
    <p class="subtitle">Atualize as informações abaixo e clique em "Atualizar".</p>

    <form action="editAddress.php?id=<?php echo $id; ?>" method="POST" class="form-grid">
      <?php while($address = $result->fetch_assoc()){ ?>
        
        <div class="form-group">
          <label for="cep">CEP</label>
          <input type="text" name="cep" id="cep" required value="<?php echo htmlspecialchars($address['cep']);?>">
        </div>

        <div class="form-group full-width">
          <label for="street">Logradouro</label>
          <input type="text" name="street" id="street" required value="<?php echo htmlspecialchars($address['street']);?>">
        </div>

        <div class="form-group">
          <label for="houseNumber">Número</label>
          <input type="number" name="houseNumber" id="houseNumber" required value="<?php echo htmlspecialchars($address['houseNumber']);?>">
        </div>

        <div class="form-group">
          <label for="neighborhood">Bairro</label>
          <input type="text" name="neighborhood" id="neighborhood" required value="<?php echo htmlspecialchars($address['neighborhood']);?>">
        </div>

        <div class="form-group">
          <label for="uf">Estado</label>
          <select name="uf" id="uf" required>
            <option value="">Selecione</option>
            <?php
              $estados = ["AC","AL","AP","AM","BA","CE","DF","ES","GO","MA","MT","MS","MG","PA","PB","PR","PE","PI","RJ","RN","RS","RO","RR","SC","SP","SE","TO"];
              foreach($estados as $estado){
                $selected = ($address['uf'] == $estado) ? "selected" : "";
                echo "<option value='$estado' $selected>$estado</option>";
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="city">Cidade</label>
          <input type="text" name="city" id="city" required value="<?php echo htmlspecialchars($address['city']);?>">
        </div>

      <?php } ?>
      
    </form>
    <div class="col-12 d-flex justify-content-center gap-5 mt-4">
        <a href="..." class="btn btn-outline-danger">Cancelar</a>
        <button type="submit" class="btn btn-success">Atualizar</button>
      </div>
  </main>

  <footer class="text-center py-4 border-top">
    <p>@ By Layza Nauane</p>
  </footer>

  <script src="../ajax.js"></script>
</body>
</html>
