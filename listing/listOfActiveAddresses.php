<?php
  include_once("../database/conexaoMysql.php");
  $connectionDB = mysqlConnect();

  try {

    $sql = <<< SQL
      SELECT 
        c.id, c.username, a.cep, a.street, a.houseNumber, a.neighborhood, a.uf, a.city, a.register
      FROM client c, address_base a
      WHERE a.idClient = c.id AND a.register = "Ativo"
      ORDER BY c.id;
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
  <title>Listagem de Endereços Ativos</title>
  <link rel="stylesheet" href="../css/listing.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
  <header>
    <h1>Listagem de Endereços Ativos</h1>
    <a href="../index.html">Voltar</a>
  </header>
  <div class=".table-responsive{-sm|-md|-lg|-xl}">
    <table class="table table-striped table-hover overflow-y: hidden">
      <thead>
        <tr>   
          <th scope="col" >#</th>
          <th scope="col" >Cliente</th>
          <th scope="col" >CEP</th>
          <th scope="col" >Logradouro</th>
          <th scope="col" >Numero</th>
          <th scope="col" >Bairro</th>
          <th scope="col" >Estado</th>
          <th scope="col" >Cidade</th>
          <th scope="col" >Cadastro</th>
          <th scope="col"></th>
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
              <a class='btn btn-sm btn-primary' href='../control/address/editAddress.php?id=$row[id]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'> 
                  <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                </svg>
              </a>
              <a class='btn btn-sm btn-danger' href='../control/address/cancelRegistrationAddress.php?id=$row[id]'>
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
  </div>
  <footer>
    <p>@ By Layza Nauane</p>
  </footer>
</body>
</html>