<?php


function talogado()
{
  if ($_SESSION['connected'] !== 1) {
    header("location: login.php");
  }
}


talogado();

?>


<!-- Header -->
<div class="container">
  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="home.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32">
        <use xlink:href="#bootstrap"></use>
      </svg>

      <?php
      if (isset($_SESSION['nomeMes'])  && isset($_SESSION['ano'])) {
      ?>
        <span class="fs-4">Controle monetário: <b> <?php echo $_SESSION['nomeMes']; ?> de <?php echo $_SESSION['ano']; ?> </b> </span>
      <?php
      } else {
      ?>
        <span class="fs-4">Controle monetário</span>
      <?php
      }
      ?>
    </a>

    <?php
    /**
     * Tipo de registro
     * Fucnionamento: Os tipos de registros se classificam em registros pessoais e em registros da casa. Cada um deles possui poupança e despensas
     * Data: 07/03/23
     */

    if (!isset($_SESSION['tipo_registro'])) {
      $_SESSION['tipo_registro'] = "Registros pessoais";
    }


    if (isset($_POST['tipo_registro'])) {
      $_SESSION['tipo_registro'] = $_POST['tipo_registro'];
    }


    ?>



    <ul class="nav nav-pills">

      <?php

      if ($_SESSION['tipo_registro'] == "Registros pessoais") {
      ?>

        <li class="nav-item">

          <form action="home.php" method="post">
            <input type="hidden" name="tipo_registro" value="Registros pessoais">
            <button type="submit" class="btn btn-success">Registros pessoais</button>
          </form>
        </li>


        <li class="nav-item">

          <form action="home.php" method="post">
            <input type="hidden" name="tipo_registro" value="Registros da casa">
            <button type="submit" class="btn btn-secondary" style="margin-right:0.5cm;">Registros da casa</button>
          </form>
        </li>

      <?php
      } else {
      ?>

        <li class="nav-item">

          <form action="home.php" method="post">
            <input type="hidden" name="tipo_registro" value="Registros pessoais">
            <button type="submit" class="btn btn-secondary">Registros pessoais</button>
          </form>
        </li>


        <li class="nav-item">

          <form action="home.php" method="post">
            <input type="hidden" name="tipo_registro" value="Registros da casa">
            <button type="submit" class="btn btn-success" style="margin-right:0.5cm;">Registros da casa</button>
          </form>
        </li>

      <?php
      }
      ?>


      <div class="dropdown text-end">
        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
        </a>
        <ul class="dropdown-menu text-small">

          <?php
          $nome_dividido = explode(" ", $_SESSION['user_name']);
          ?>

          <li><a class="dropdown-item" href="#"><?php echo "Perfil: <b>" . $nome_dividido[0] . "</b>"; ?> </a></li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="trocar-senha.php">Trocar senha</a></li>
          <li><a class="dropdown-item" href="logoff.php">Sair</a></li>
        </ul>
      </div>
    </ul>
  </header>
</div>
<?php
if ((isset($_POST['nomeMes']) && $_POST['ano']) || (isset($_POST['nomeMes']) && $_POST['ano'] == "")) {
?>
  <a href="home.php" class="botao-voltar">Voltar</a>
<?php
}
?>


<footer>
  Tiago Universe, PE 2023.
</footer>