<?php

/** 
 * Author: Tiago César da Silva Lopes
 * Description: Homepage of a specific month and year
 * Date: 01/02/23
 */

require_once "conexao.php";

//Variáveis

if (isset($_POST['nomeMes'])) {
  $_SESSION['nomeMes'] = $_POST['nomeMes'];
}

if (isset($_POST['statusMes'])) {
  $_SESSION['statusMes'] = $_POST['statusMes'];
}


require_once "Recursos/Navegacao.php";

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_SESSION['nomeMes']; ?> de <?php echo $_SESSION['ano']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="../../Assets/Css/Content.css" />
  <link rel="stylesheet" href="../../Assets/Css/Footer.css" />
</head>

<body>

  <?php
  if ($_SESSION['nomeMes'] == "" || $_SESSION['ano'] == "") {
  ?>
    <div class="px-4 py-5 my-5 text-center">
      <img class="d-block mx-auto mb-4" src="../../Assets/img/error.png" alt="" width="72" height="70">

      <h1 class="display-5 fw-bold">Error de ano</h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">Por favor, digite um ano e mês válido na tela inicial.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <a href="home.php" class="btn btn-primary btn-lg px-4 gap-3"> Voltar</a>
        </div>
      </div>
    </div>
  <?php
  } else {
  ?>
    <div class="px-4 py-5 my-5 text-center">
      <h1 class="display-5 fw-bold"> <?php echo "Poupança de " . $_SESSION['ano'];  ?> </h1>
      <br><br>
      <form action="poupancas.php" method="post">
        <button type="submit" class="btn btn-outline-secondary btn-lg px-4">Registrar poupanças</button>
      </form>
    </div>

    <div class="px-4 py-5 my-5 text-center">
      <img class="d-block mx-auto mb-4" src="../../Assets/img/dia 15.png" alt="" width="72" height="70">

      <h1 class="display-5 fw-bold">Despensas: Primeira quinzena</h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">Registre os gastos entre o dia 05 até o dia 19, que são os dias da entrada de salário da casa.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <form action="despensas.php" method="post">
            <input type="hidden" value="<?php echo $_SESSION['statusMes'];  ?>" name="statusMes">
            <input type="hidden" value="Quinzena 1" name="quinzena">
            <button type="submit" class="btn btn-primary btn-lg px-4 gap-3">Registrar despensas</button>
          </form>




        </div>
      </div>
    </div>

    <div class="px-4 py-5 my-5 text-center">
      <img class="d-block mx-auto mb-4" src="../../Assets/img/dia 30.png" alt="" width="72" height="70">
      <h1 class="display-5 fw-bold">Despensas: Segunda quinzena</h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">Registre os gastos entre o dia 20 até dia 04 do próximo mês, antes de começar uma nova quinzena.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <!-- <button type="button" class="btn btn-primary btn-lg px-4 gap-3">Registrar despensas</button> -->

          <form action="despensas.php" method="post">
            <input type="hidden" value="<?php echo $_SESSION['statusMes'];  ?>" name="statusMes">
            <input type="hidden" value="Quinzena 2" name="quinzena">
            <button type="submit" class="btn btn-primary btn-lg px-4 gap-3">Registrar despensas</button>
          </form>


        </div>
      </div>
    </div>
  <?php
  }
  ?>














  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>