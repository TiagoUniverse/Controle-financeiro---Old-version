<?php
// Tiago César da Silva Lopes || 18/01/23
require_once "conexao.php";

$id_comida = $_POST['id_comida'];

$sql_code = "SELECT * from comida where id = '{$id_comida}' ";
$sql_query = $mysqli->query($sql_code) or die("Error na alteração: " . $mysqli->error);
$dados = $sql_query->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração de registros</title>
</head>

<body>
    <h1>Alteração de registros</h1>
    <a type="button" href="index.php">Voltar</a>

    <form method="post" action="alterar2.php">
        <input type="hidden" name="id_comida"  value="<?php echo $id_comida; ?>">

        <h2>Altere o registro abaixo:</h2>
        <h7>Nome do alimento:</h7>
        <input type="text" name="nome" value="<?php echo $dados['nome']; ?>" placeholder="Nome do alimento:">

        <br><br>
        <h7>Preço:</h7>
        <input type="int" name="preco" value="<?php echo $dados['preco']; ?>" placeholder="Preço: (1.00)">

        <br><br>
        <button type="submit">Alterar</button>
    </form>
</body>

</html>