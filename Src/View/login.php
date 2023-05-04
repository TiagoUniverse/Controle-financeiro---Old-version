<?php

/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                               CONTROLE FINANCEIRO                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: Login                                                                                         │  ║
 * ║  | @dir: View                                                                                                  │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 09/03/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 */

require_once "conexao.php";

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Usuario's section                                                              │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once "../Model/Usuario_repositorio.php";
use model\Usuario_repositorio;

require_once "../Model/Usuario.php";
use model\Usuario;

$Usuario = new Usuario();
$Usuario_repositorio = new Usuario_repositorio();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../../Assets//Css//login.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
  <div class="parent clearfix">
    <div class="bg-illustration">
      <img src="https://i.ibb.co/Pcg0Pk1/logo.png" alt="logo">

      <div class="burger-btn">
        <span></span>
        <span></span>
        <span></span>
      </div>

    </div>

    <div class="login">
      <div class="container">
        <h1>Controle<br />monetário</h1>

        <?php

        if (isset($_POST['status_login'])) {
          $mensagemVermelha = true;

          $return = $Usuario_repositorio->login($_POST['email'], $_POST['senha'], $pdo);

          if ($return) {
            $mensagem = "Login efetuado com sucesso!";

           $Usuario = $Usuario_repositorio->consultar_usuario($_POST['email'], $_POST['senha'], $pdo);

            $_SESSION['connected'] = 1;
            $_SESSION['user_email'] = $_POST['email'];
            $_SESSION['user_name'] = $Usuario->getNome();
            $_SESSION['user_id'] = $Usuario->getId();

            header("location: home.php");
          } else {
            $mensagem = "Falha no login!";
          }

          // Mensagem do resultado
          if ($mensagemVermelha) {
            echo "<div class='alert alert-danger' role='alert'> ";
          } else {
            echo "<div class='alert alert-success' role='alert'> ";
          }
          echo $mensagem;
          echo "</div>";
        }
        ?>

        <div class="login-form" style="margin-top:90px">
          <form action="login.php" method="post">
            <input type="hidden" name="status_login" value="FAZENDO LOGIN">
            <input type="email" placeholder="E-mail" name="email" required>
            <input type="password" placeholder="Senha" name="senha" required>

            <div class="forget-pass">
              <a href="nova_conta.php">Criar Conta</a>
            </div>

            <button type="submit">Acessar</button>

          </form>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>


</html>