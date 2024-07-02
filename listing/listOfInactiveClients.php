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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listagem de Clientes Inativos</title>
  <link rel="stylesheet" href="../css/listing.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
  <header>
    <h1>Listagem de Clientes Inativos</h1>
    <a href="../index.html">Voltar</a>
  </header>
  <main>
    <table class="table table-striped table-hover">
      <thead>
        <tr>   
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">CPF</th>
          <th scope="col">Sexo</th>
          <th scope="col">Birthday</th> 
          <th scope="col">Estado Civil</th>
          <th scope="col">E-mail</th>
          <th scope="col">Telefone</th>
          <th scope="col">Cadastro</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['cpf']}</td>";
            echo "<td>{$row['sex']}</td>";
            echo "<td>{$row['birthday']}</td>";
            echo "<td>{$row['maritalStatus']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['phone']}</td>";
            echo "<td>{$row['register']}</td>";
            echo "<td>
              <a class='btn btn-sm btn-danger' href='../control/reactivateRegistration.php?id=$row[id]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-lg' viewBox='0 0 16 16'>
                  <path d='M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z'/>
                </svg>
              </a>
            </td>";
            echo "</tr>";
          }
        ?>
      </tbody>
    </table>
  </main>
  <footer>
    <p>@ By Layza Nauane</p>
  </footer>
</body>
</html>