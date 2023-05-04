<?php

/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                               CONTROLE FINANCEIRO                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: Register of all money spent                                                                   │  ║
 * ║  | @dir: View                                                                                                  │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 02/02/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 */

require_once "conexao.php";
require_once "Recursos/Navegacao.php";

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

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Despensas de <?php echo $_SESSION['nomeMes']; ?> de <?php echo $_SESSION['ano']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="../../Assets/Css/Content.css" />
  <link rel="stylesheet" href="../../Assets/Css/Footer.css" />
</head>

<body>

  <form action="mes.php" method="post">
    <input type="hidden" name="statusMes" value="<?php echo $_SESSION['statusMes']; ?>">
    <button class="btn btn-link">Voltar</button>
  </form>

  <h1 class="display-5 fw-bold" style="text-align: center;"> <?php echo $_SESSION['quinzena'];  ?> </h1>
  <h2 class="display-5 fw-bold" style="text-align: center;">Trocar senha</h2>

  <?php
  if (isset($_POST['status_alteracao']) && $_POST['status_alteracao'] == "ALTERANDO A SENHA") {

    $mensagemVermelha = true;

    if ($_POST['senha'] != $_POST['repitaSenha']) {
      $mensagem = "Informe senhas iguais!";
    } else {

      $return = $Usuario_repositorio->alterar_senha($_POST['senha'], $_SESSION['user_id'], $pdo);

      if ($return) {
        $mensagem = "Alteração de senha com sucesso!";
        $mensagemVermelha = false;
      } else {
        $mensagem = "Falha na alteração de senha! Por favor, tente novamente.";
      }
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


  <div class="px-4 py-5 my-5 text-center">
    <form action="trocar-senha.php" method="post">
      <input type="hidden" name="status_alteracao" value="ALTERANDO A SENHA">
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Senha</label>
        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="senha" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Repita a senha</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="repitaSenha" required>
      </div>
      <br>
      <button type="submit" class="btn btn-danger">Alterar senha</button>
    </form>
  </div>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>