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
* │                                Variables                                                                      │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if (isset($_POST['quinzena'])) {
  $_SESSION['quinzena'] = $_POST['quinzena'];
}

if (isset($_POST['adicionando_registro'])) {
  $adicionando_registro = $_POST['adicionando_registro'];
} else {
  $adicionando_registro = null;
}

if (isset($_POST['descricao'])) {
  $descricao = $_POST['descricao'];
} else {
  $descricao = null;
}

if (isset($_POST['valor'])) {
  $valor = $_POST['valor'];
} else {
  $valor = null;
}

if (isset($_POST['data'])) {
  $data = $_POST['data'];
} else {
  $data = null;
}

if (isset($_POST['statusDespensa'])) {
  $statusDespensa = $_POST['statusDespensa'];
} else {
  $statusDespensa = null;
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Despensas's section                                                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

require_once "../Model/Despensas_repositorio.php";

use model\Despensas_repositorio;

$Despensas_repositorio = new Despensas_repositorio();


/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │1-                               Cadastro de registros                                                         |
* | Description: Quando a variável está no status de 'SALVANDO REGISTRO ENTRADA', ele só vai salvar se ele não    |
* | encontrar o mesmo registro já salvo .   Data: 16/02/23                                                        │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if ($adicionando_registro != null && $adicionando_registro == "SALVANDO REGISTRO ENTRADA") {

  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Validações                                                                     │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  if (isset($_POST['data'])) {
    $dataDividida = explode("-", $_POST['data']);
  }

  // Mês para validação
  if ($_SESSION['statusMes'] < 10) {
    $mes_selecionado = "0" . $_SESSION['statusMes'];
  } else {
    $mes_selecionado = $_SESSION['statusMes'];
  }

  /**  | @anotacao: Mês limite                                                                                       |
   *   | Funcionamento: A quinzena 2 permite registro do dia 20/mes atual até o dia 04/próximo mes. Para isso, vamos |
   *   | limitar o registro para registrar apenas o mes atual ou o próximo mes                                       |
   *   | Data: 03/03/23                                                                                              |
   */

  if ($mes_selecionado == 12) {
    $mes_limite = 1;
  } else {
    $mes_limite = $mes_selecionado + 1;
  }

  /**  | @anotacao: Mensagem Vermelha                                                                                |
   *   | Funcionamento: A validação começa com ela definida como verdadeira. Se depois de todas as validações as     |
   *   | informações estiverem corretas, então o sistema vai exibir uma mensagem de sucesso e informar que o         |
   *   | cadastro foi feito com sucesso                                                                              |
   *   | Data: 16/02/23                                                                                              |
   */
  $mensagemVermelha = true;



  if (!isset($_POST['data'])) {
    $mensagem = "Informe uma data";
  } else if ($_SESSION['quinzena'] == "Quinzena 1" && $dataDividida[1] != $mes_selecionado) {
    $mensagem = "Selecione uma data do mes de " . $_SESSION['nomeMes'];
  } else if ($_SESSION['quinzena'] == "Quinzena 2" && $dataDividida[1] != $mes_selecionado && $dataDividida[2] > 5) {
    $mensagem = "Informe um valor da segunda quinzena até o dia 4";
  } else if ($dataDividida[1] > $mes_limite) {
    $mensagem = "Para cadastrar na 2ª quinzena, insira registro entre o mês atual e o próximo mês.";
  } else if ($dataDividida[0] != $_SESSION['ano']) {
    $mensagem = "Faça um registro no ano de " . $_SESSION['ano'];
  } else if ($descricao == null) {
    $mensagem = "Por favor, preencha a descrição sobre o registro";
  } else if ($valor <= 0) {
    $mensagem = "Por favor, informe um valor positivo do dinheiro";
  } else if ($_SESSION['quinzena'] == "Quinzena 1" && ($dataDividida[2] < 5 || $dataDividida[2] > 19)) {
    $mensagem = "Por favor, insira um registro dentro dos dias da primeira quinzena (dia 5 até dia 19)";
  } else if ($_SESSION['quinzena'] == "Quinzena 2" && ($dataDividida[2] <= 4 || $dataDividida[2] > 31)) {
    $mensagem = "Por favor, insira um registro dentro dos dias da segunda quinzena (20 até dia 4 do próximo mês)";
  } else {
    // echo "entrei pra registrar";
    $retorno = $Despensas_repositorio->consultarRegistro($descricao, $valor, $data, 3, $pdo);

    if ($retorno == false) {
      $mensagemVermelha = false;
      $mensagem = "Informação registrada com sucesso!";

      if ($_SESSION['tipo_registro'] == "Registros pessoais") {
        $statusDespensa = 3;
      } else {
        $statusDespensa = 1;
      }

      $Despensas_repositorio->cadastro_entrada($descricao, $valor, $data, $_SESSION['ano'], $_SESSION['quinzena'], $_SESSION['statusMes'], $statusDespensa, $_SESSION['user_id'], $pdo);
    } else {
      $mensagem = "Registro já cadastrado!";
    }
  }

  $adicionando_registro = null;

  // Mensagem do resultado
  if ($mensagemVermelha) {
    echo "<div class='alert alert-danger' role='alert'> ";
  } else {
    echo "<div class='alert alert-success' role='alert'> ";
  }
  echo $mensagem;
  echo "</div>";
}


if ($adicionando_registro != null && $adicionando_registro == "SALVANDO REGISTRO SAIDA") {

  /*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
  * │                                Validações                                                                     │
  * └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
  */

  if (isset($_POST['data'])) {
    $dataDividida = explode("-", $_POST['data']);
  }

  // Mês para validação
  if ($_SESSION['statusMes'] < 10) {
    $mes_selecionado = "0" . $_SESSION['statusMes'];
  } else {
    $mes_selecionado = $_SESSION['statusMes'];
  }

  /**  | @anotacao: Mês limite                                                                                       |
   *   | Funcionamento: A quinzena 2 permite registro do dia 20/mes atual até o dia 04/próximo mes. Para isso, vamos |
   *   | limitar o registro para registrar apenas o mes atual ou o próximo mes                                       |
   *   | Data: 03/03/23                                                                                              |
   */

  if ($mes_selecionado == 12) {
    $mes_limite = 1;
  } else {
    $mes_limite = $mes_selecionado + 1;
  }

  /**  | @anotacao: Mensagem Vermelha                                                                                |
   *   | Funcionamento: A validação começa com ela definida como verdadeira. Se depois de todas as validações as     |
   *   | informações estiverem corretas, então o sistema vai exibir uma mensagem de sucesso e informar que o         |
   *   | cadastro foi feito com sucesso                                                                              |
   *   | Data: 16/02/23                                                                                              |
   */
  $mensagemVermelha = true;

  if (!isset($_POST['data'])) {
    $mensagem = "Informe uma data";
  } else if ($_SESSION['quinzena'] == "Quinzena 1" && $dataDividida[1] != $mes_selecionado) {
    $mensagem = "Selecione uma data do mes de " . $_SESSION['nomeMes'];
  } else if ($_SESSION['quinzena'] == "Quinzena 2" && $dataDividida[1] != $mes_selecionado && $dataDividida[2] > 5) {
    $mensagem = "Informe um valor da segunda quinzena até o dia 4";
  } else if ($dataDividida[1] > $mes_limite) {
    $mensagem = "Para cadastrar na 2ª quinzena, insira registro entre o mês atual e o próximo mês.";
  } else if ($dataDividida[0] != $_SESSION['ano']) {
    $mensagem = "Faça um registro no ano de " . $_SESSION['ano'];
  } else if ($descricao == null) {
    $mensagem = "Por favor, preencha a descrição sobre o registro";
  } else if ($valor <= 0) {
    $mensagem = "Por favor, informe um valor positivo do dinheiro";
  } else if ($_SESSION['quinzena'] == "Quinzena 1" && ($dataDividida[2] < 5 || $dataDividida[2] > 19)) {
    $mensagem = "Por favor, insira um registro dentro dos dias da primeira quinzena (dia 5 até dia 19)";
  } else if ($_SESSION['quinzena'] == "Quinzena 2" && ($dataDividida[2] <= 4 || $dataDividida[2] > 31)) {
    $mensagem = "Por favor, insira um registro dentro dos dias da segunda quinzena (20 até dia 4 do próximo mês)";
  } else {

    $retorno = $Despensas_repositorio->consultarRegistro($descricao, $valor, $data, 4, $pdo);

    if ($retorno == false) {
      $mensagemVermelha = false;
      $mensagem = "Informação registrada com sucesso!";

      if ($_SESSION['tipo_registro'] == "Registros pessoais") {
        $statusDespensa = 4;
      } else {
        $statusDespensa = 2;
      }

      $Despensas_repositorio->cadastro_Saida($descricao, $valor, $data, $_SESSION['ano'], $_SESSION['quinzena'], $_SESSION['statusMes'], $statusDespensa, $_SESSION['user_id'], $pdo);
    } else {
      $mensagem = "Registro já cadastrado!";
    }
  }

  $adicionando_registro = null;

  // Mensagem do resultado
  if ($mensagemVermelha) {
    echo "<div class='alert alert-danger' role='alert'> ";
  } else {
    echo "<div class='alert alert-success' role='alert'> ";
  }
  echo $mensagem;
  echo "</div>";
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Consulta dos registro                                                          |
* | Description: Show the registers dependind if the SESSION['tipo_registro'] is about                            │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/

if ($_SESSION['tipo_registro'] == "Registros da casa") {

  $consulta_Entrada = $pdo->query("Select id, descricao, valor, DATE_FORMAT(dataDespensa, '%d/%m/%Y') as dataDespensa, ano, quinzena from despensas where status = 'ATIVO' 
  and ano = '{$_SESSION['ano']}'  and IdStatus_mes = '{$_SESSION['statusMes']}' and quinzena = '{$_SESSION['quinzena']}' 
  and ( idStatus_despensa = 1) and idUsuario = '{$_SESSION['user_id']}'  Order By month(dataDespensa)        ");

  $consulta_Saida = $pdo->query("Select id, descricao, valor, DATE_FORMAT(dataDespensa, '%d/%m/%Y') as dataDespensa, ano, quinzena from despensas where status = 'ATIVO' 
  and ano = '{$_SESSION['ano']}'  and IdStatus_mes = '{$_SESSION['statusMes']}' and quinzena = '{$_SESSION['quinzena']}' 
  and ( idstatus_despensa = 2 )  and idUsuario = '{$_SESSION['user_id']}'   Order By month(dataDespensa)        ");
} else {

  $consulta_Entrada = $pdo->query("Select id, descricao, valor, DATE_FORMAT(dataDespensa, '%d/%m/%Y') as dataDespensa, ano, quinzena from despensas where status = 'ATIVO' 
  and ano = '{$_SESSION['ano']}'  and IdStatus_mes = '{$_SESSION['statusMes']}' and quinzena = '{$_SESSION['quinzena']}' 
  and ( idStatus_despensa = 3)  and idUsuario = '{$_SESSION['user_id']}'   Order By month(dataDespensa)        ");

  $consulta_Saida = $pdo->query("Select id, descricao, valor, DATE_FORMAT(dataDespensa, '%d/%m/%Y') as dataDespensa, ano, quinzena from despensas where status = 'ATIVO' 
  and ano = '{$_SESSION['ano']}'  and IdStatus_mes = '{$_SESSION['statusMes']}' and quinzena = '{$_SESSION['quinzena']}' 
  and ( idstatus_despensa = 4 )  and idUsuario = '{$_SESSION['user_id']}'   Order By month(dataDespensa)        ");
}

/*┌───────────────────────────────────────────────────────────────────────────────────────────────────────────────┐
* │                                Registros do gasto e da receita                                                |
* | Description: After viewing the SQL, we are going to calculate how many money do we have                       │
* └───────────────────────────────────────────────────────────────────────────────────────────────────────────────┘
*/
$dinheiroEntrada = 0;
$dinheiroSaida = 0;

$Entrada_fetch = $consulta_Entrada->fetchAll(PDO::FETCH_ASSOC);
$Saida_fetch = $consulta_Saida->fetchAll(PDO::FETCH_ASSOC);

foreach ($Entrada_fetch as $row) {
  $dinheiroEntrada +=  $row['valor'];
}

foreach ($Saida_fetch as $row) {
  $dinheiroSaida +=  $row['valor'];
}

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
  <h2 class="display-5 fw-bold" style="text-align: center;">Despensas: gastos pessoais</h2>
  <h3 style="text-align: center;">Quando estiver pronto, clique no botão de avançar para registrar as despensas</h3>

  <!-- Dinheiro total -->
  <br>
  <div class="col-lg-6 mx-auto" style="background-color:cadetblue">

    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
      <table class="table">
        <thead>
          <tr>
            <th scope="col"> Gasto total </th>
            <th scope="col">Receita total</th>
            <th scope="col">Resultado da subtração</th>
          </tr>
        </thead>

        <tbody style="color: #fff8f1;">
          <tr>
            <th scope="col"><?php echo "R$" . $dinheiroSaida; ?> </th>
            <th scope="col"><?php echo "R$" . $dinheiroEntrada; ?> </th>
            <th scope="col"  style="color:#e61e19;"><?php echo "R$" . ($dinheiroEntrada - $dinheiroSaida) ; ?> </th>
            </th>
          </tr>
        </tbody>
      </table>

    </div>
  </div>


  <div class="px-4 py-5 my-5 text-center">
    <?php
    if ($_SESSION['quinzena'] == "Quinzena 1") {
      echo "<img class='d-block mx-auto mb-4' src='../../Assets/img/dia 15.png' alt='' width='72' height='70'> ";
    } else {
      echo "<img class='d-block mx-auto mb-4' src='../../Assets/img/dia 30.png' alt='' width='72' height='70'> ";
    }
    ?>

    <h1 class="display-5 fw-bold" id="Saida_title">Saída</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Por favor, digite um ano e mês válido na tela inicial.</p>
      <a href="#Entrada_title"> Navegar até os registros de Entrada</a>
      <br><br>

      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center" style="background-color:#c79797">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Nª</th>
              <th scope="col">Descrição</th>
              <th scope="col">valor</th>
              <th scope="col">Data</th>
              <th scope="col">Alteração</th>
              <th scope="col">Exclusão</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $contador = 1;
            foreach ($Saida_fetch as $linha) {
            ?>
              <tr>
                <!-- <th scope="row">1</th> -->
                <td> <?php echo $contador; ?> </td>
                <td> <?php echo $linha['descricao']; ?> </td>
                <td> <?php echo "R$" . $linha['valor']; ?> </td>
                <td> <?php echo $linha['dataDespensa']; ?> </td>
                <td>

                  <form action="alterar.php" method="post">
                    <input type="hidden" value=" <?php echo $linha['id']; ?>" name="id">
                    <input type="hidden" value="DESPENSAS" name="pagina_inicial">
                    <button type="submit"> <img src="../../Assets//Icons//pencil.png" class="icon_exclusao"></button>
                  </form>

                </td>
                <td>

                  <form action="excluir.php" method="post">
                    <input type="hidden" value=" <?php echo $linha['id']; ?>" name="id">
                    <input type="hidden" value="DESPENSAS" name="pagina_inicial">
                    <button type="submit"> <img src="../../Assets//Icons//x-mark-xxl.png" class="icon_exclusao"></button>
                  </form>

                </td>
              </tr>
            <?php
              $contador++;
            }

            if ($adicionando_registro != null && $adicionando_registro == "REGISTRANDO SAIDA") {
            ?>
              <form method="post">
                <input type="hidden" name="adicionando_registro" value='SALVANDO REGISTRO SAIDA'>
                <input type="hidden" name="statusDespensa" value='3'>
                <tr>
                  <th scope="col">Nª</th>
                  <th scope="col">
                    <input type="text" name="descricao">
                  </th>
                  <th scope="col">
                    <input type="number" min="1" step="any" name="valor">
                  </th>
                  <th scope="col">
                    <input type="date" name="data" value='<?php echo date("Y-m-d"); ?>'>
                  </th>

                </tr>


              <?php
            }

              ?>
          </tbody>

        </table>

      </div>
      <?php
      if ($adicionando_registro != null && $adicionando_registro == "REGISTRANDO SAIDA") {
      ?>

        <div class="row g-0 text-center">
          <div class="col-sm-6 col-md-6">
            <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
          </div>
          <div class="col-6 col-md-6">
            <form action="despensas.php" method="post">
              <input type="hidden" value="" name="adicionando_registro">
              <button type="submit" class="btn btn-secondary">Cancelar</button>
            </form>
          </div>
        </div>


      <?php
      }

      if ($adicionando_registro == null) {
      ?>
        <form action="despensas.php" method="post">
          <input type="hidden" value="REGISTRANDO SAIDA" name="adicionando_registro">
          <button type="submit" class="btn btn-primary">Adicionar um novo registro</button>
        </form>
      <?php
      }
      ?>

    </div>
  </div>

  
  <div class="px-4 py-5 my-5 text-center">

    <?php
    if ($_SESSION['quinzena'] == "Quinzena 1") {
      echo "<img class='d-block mx-auto mb-4' src='../../Assets/img/dia 15.png' alt='' width='72' height='70'> ";
    } else {
      echo "<img class='d-block mx-auto mb-4' src='../../Assets/img/dia 30.png' alt='' width='72' height='70'> ";
    }
    ?>

    <h1 class="display-5 fw-bold" id="Entrada_title">Entrada</h1>
    <p class="lead mb-4">Por favor, digite um ano e mês válido na tela inicial.</p>
    <a href="#Saida_title"> Navegar até os registros de Saída</a>
    <br><br>

    <div class="col-lg-6 mx-auto" style="background-color:#c79797">

      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Nª</th>
              <th scope="col">Descrição</th>
              <th scope="col">valor</th>
              <th scope="col">Data</th>
              <th scope="col">Alteração</th>
              <th scope="col">Exclusão</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $contador = 1;
            foreach ($Entrada_fetch as $linha) {
            ?>
              <tr>
                <!-- <th scope="row">1</th> -->
                <td> <?php echo $contador; ?> </td>
                <td> <?php echo $linha['descricao']; ?> </td>
                <td> <?php echo "R$" . $linha['valor']; ?> </td>
                <td> <?php echo $linha['dataDespensa']; ?> </td>
                <td>

                  <form action="alterar.php" method="post">
                    <input type="hidden" value=" <?php echo $linha['id']; ?>" name="id">
                    <input type="hidden" value="DESPENSAS" name="pagina_inicial">
                    <button type="submit"> <img src="../../Assets//Icons//pencil.png" class="icon_exclusao"></button>
                  </form>

                </td>
                <td>

                  <form action="excluir.php" method="post">
                    <input type="hidden" value=" <?php echo $linha['id']; ?>" name="id">
                    <input type="hidden" value="DESPENSAS" name="pagina_inicial">
                    <button type="submit"> <img src="../../Assets//Icons//x-mark-xxl.png" class="icon_exclusao"></button>
                  </form>

                </td>

              </tr>
            <?php
              $contador++;
            }

            if ($adicionando_registro != null && $adicionando_registro == "REGISTRANDO ENTRADA") {
            ?>
              <form method="post">
                <input type="hidden" name="adicionando_registro" value='SALVANDO REGISTRO ENTRADA'>
                <input type="hidden" name="statusDespensa" value='3'>
                <tr>
                  <th scope="col">Nª</th>
                  <th scope="col">
                    <input type="text" name="descricao">
                  </th>
                  <th scope="col">
                    <input type="number" min="1" step="any" name="valor">
                  </th>
                  <th scope="col">
                    <input type="date" name="data" value='<?php echo date("Y-m-d"); ?>'>
                  </th>

                </tr>

              <?php
            }

              ?>
          </tbody>

        </table>

      </div>
      <?php
      if ($adicionando_registro != null && $adicionando_registro == "REGISTRANDO ENTRADA") {
      ?>

        <div class="row g-0 text-center">
          <div class="col-sm-6 col-md-6">
            <button type="submit" class="btn btn-primary">Registrar</button>
            </form>
          </div>
          <div class="col-6 col-md-6">
            <form action="despensas.php" method="post">
              <input type="hidden" value="" name="adicionando_registro">
              <button type="submit" class="btn btn-secondary">Cancelar</button>
            </form>
          </div>
        </div>


      <?php
      }

      if ($adicionando_registro == null) {
      ?>
        <form action="despensas.php" method="post">
          <input type="hidden" value="REGISTRANDO ENTRADA" name="adicionando_registro">
          <button type="submit" class="btn btn-primary">Adicionar um novo registro</button>
        </form>
      <?php
      }
      ?>

    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>