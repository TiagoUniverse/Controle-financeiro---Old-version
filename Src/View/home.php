<?php

 /**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                               CONTROLE FINANCEIRO                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: Homepage                                                                                      │  ║
 * ║  | @dir: View                                                                                                  │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 25/01/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 */

require_once "conexao.php";
require_once "Recursos/Navegacao.php";


//Atualizando session
$_SESSION['nomeMes'] = null;
$_SESSION['statusMes'] = null;
$_SESSION['quinzena'] = null;



//Variáveis


if (!isset($_POST['limpaFiltro'])){
  $_SESSION['ano'] = null;
}

if (isset($_POST['limpaFiltro']) && $_POST['limpaFiltro'] == 1){
  $_SESSION['ano'] = null;
} else if (isset($_POST['ano']) != null) {
  $_SESSION['ano'] = $_POST['ano'];
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" 
  integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="../../Assets/Css/Content.css" />
  <link rel="stylesheet" href="../../Assets/Css/Footer.css" />
</head>

<body>
  <form method="POST" action="home.php">
    <div class="input-group mb-3 filtro" >
      <select class="form-control" name="ano">
        <?php
        for ($year = (int)date('Y'); 1900 <= $year; $year--) : ?>
          <option value="<?= $year; ?>" n><?= $year; ?></option>
        <?php endfor; ?>
      </select>
      <button type="submit" class="btn btn-primary">Pesquisar</button>
  </form>

  <form method="POST" action="home.php">
    <input type="hidden" name="limpaFiltro" value="1">
    <button type="submit" class="btn btn-secondary" style="margin-left: 0.3cm;">Limpar resultado</button>
  </form>
  </div>

  <?php
  if ($_SESSION['ano'] != null) {
  ?>
    <div class="container px-4 text-center">
      <h1><?php echo $_SESSION['ano']; ?> </h1>
      <div class="row gx-5">

        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Janeiro";
            ?>
            <input type="hidden" value="1" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Fevereiro";
            ?>
            <input type="hidden" value="2" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Março";
            ?>
            <input type="hidden" value="3" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Abril";
            ?>
            <input type="hidden" value="4" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Maio";
            ?>
            <input type="hidden" value="5" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Junho";
            ?>
            <input type="hidden" value="6" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Julho";
            ?>
            <input type="hidden" value="7" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Agosto";
            ?>
            <input type="hidden" value="8" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Setembro";
            ?>
            <input type="hidden" value="9" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Outubro";
            ?>
            <input type="hidden" value="10" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Novembro";
            ?>
            <input type="hidden" value="11" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box">
          <form action="mes.php" method="post">
            <?php
            $NomeMes = "Dezembro";
            ?>
            <input type="hidden" value="12" name="statusMes">
            <input type="hidden" value="<?php echo $NomeMes; ?>" name="nomeMes">
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo $NomeMes; ?></button>
          </form>
        </div>
        <div class="box_Poupanca">
          <form action="poupancas.php" method="post">
            <?php
            // $NomeMes = "Dezembro";
            ?>
            <input type="hidden" value="<?php echo $_SESSION['ano']; ?>" name="ano">
            <button type="submit" class="btn btn-primary"><?php echo "Poupança de " . $_SESSION['ano']; ?></button>
          </form>
        </div>
      </div>
    </div>
  <?php
  } else {
    ?>
    <div class="px-4 py-5 my-5 text-center">
    <img class="d-block mx-auto mb-4" src="../../Assets/img/calendario.png" alt="" width="72" height="70">
    
    <h1 class="display-5 fw-bold">Busca vazia</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Digite um ano para começar</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
      </div>
    </div>
  </div>
    <?php
  }
  ?>


  <script>

  </script>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>