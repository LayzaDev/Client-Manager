<?php
  include_once("../database/conexaoMysql.php");

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

    header("Location: listingAddress.php");
    exit();
  }

  $sql = "SELECT * FROM address_base WHERE id = $id LIMIT 1";

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
  <a href="listingAddress.php">Voltar</a>
  <div class="container">
    <main>
      <form class="form" action="editAddress.php?id=<?php echo $id; ?>" method="POST">
        <?php
          while($address = $result->fetch_assoc()){
        ?>
          <fieldset>
          <legend>Dados do Endereço</legend>
          <div class="row g-2">
            <!-- CEP e logradouro -->
            <div class="col-sm-3">
              <label for="cep" class="form-label">CEP</label>
              <input type="text" name="cep" id="cep" class="form-control" required value="<?php echo htmlspecialchars($address['cep']);?>">
            </div>
            <div class="col-sm-9">
              <label for="street" class="form-label">Logradouro</label>
              <input type="text" name="street" id="street" class="form-control" required value="<?php echo htmlspecialchars($address['street']);?>">
            </div>
            <!-- Numero e Bairro -->
            <div class="col-sm-3">
              <label for="houseNumber" class="form-label">Número</label>
              <input type="number" name="houseNumber" id="houseNumber" class="form-control" required value="<?php echo htmlspecialchars($address['houseNumber']);?>">
            </div>
            <div class="col-sm-9">
              <label for="neighborhood" class="form-label">Bairro</label>
              <input type="text" name="neighborhood" id="neighborhood" class="form-control" required value="<?php echo htmlspecialchars($address['neighborhood']);?>">
            </div>
            <!-- Estado e Cidade -->
            <div class="col-sm-3">
              <label for="uf" class="form-label">Estado</label> 
              <select name="uf" id="uf" class="form-select" required value="<?php echo htmlspecialchars($address['uf']);?>">
                <option value="">Selecione</option>
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MT">MT</option>
                <option value="MS">MS</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option>
                <option value="SP">SP</option>
                <option value="SE">SE</option>
                <option value="TO">TO</option>
              </select>
            </div>
            <div class="col-sm-9">
              <label for="city" class="form-label">Cidade</label>
              <input type="text" name="city" id="city" class="form-control" required value="<?php echo htmlspecialchars($address['city']);?>">
            </div>
          </div>
        </fieldset>
        <?php
          }
        ?>
        <div class="col-12" id="button">
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
      </form>
    </main>
  </div>
  <script src="ajax.js"></script>
</body>
</html>