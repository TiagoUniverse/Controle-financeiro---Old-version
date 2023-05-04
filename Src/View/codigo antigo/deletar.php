<?php
// Tiago César da Silva Lopes || 20/01/23
require_once "conexao.php";

//Variables
$id_comida = $_POST['id_comida'];

if (isset($_POST['confirmacao_deletar']) != null) {
    $confirmacao_deletar = $_POST['confirmacao_deletar'];
} else {
    $confirmacao_deletar = null;
}

//Mysql codes
if ($confirmacao_deletar != null) {
    $sql_code = "DELETE from comida where id = '{$id_comida}' ; ";
    $mysqli->query($sql_code) or die("Erro na exclusão: " . $mysqli->error);
}

$sql_code = "SELECT * from comida where id = '{$id_comida}' ";
$sql_query = $mysqli->query($sql_code) or die("Error na consulta: " . $mysqli->error);
$dados = $sql_query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir registro</title>
</head>

<body>
    <h1>Excluir registro</h1>
    <a type="button" href="index.php">Voltar</a>

    <?php
    if (isset($_POST['confirmacao_deletar']) != null && $_POST['confirmacao_deletar'] == 1) {
    ?>
        <h1> Registro excluído com sucesso!</h1>
    <?php
    }
    if ($confirmacao_deletar == null) {
    ?>

        <form method="post" action="deletar.php">
            <input type="hidden" name="confirmacao_deletar" value='1'>
            <input type="hidden" name="id_comida" value='<?php echo $id_comida;  ?> '>

            <h2>Deseja excluir o registro abaixo:</h2>
            <h7>Nome do alimento:</h7>
            <input type="text" name="nome" disabled value="<?php echo $dados['nome']; ?>" placeholder="Nome do alimento:">

            <br><br>
            <h7>Preço:</h7>
            <input type="int" name="preco" disabled value="<?php echo $dados['preco']; ?>" placeholder="Preço: (1.00)">

            <br><br>
            <?php

            ?>
            <button type="submit">Excluir</button>
        <?php
    }
        ?>

        </form>
</body>

</html>