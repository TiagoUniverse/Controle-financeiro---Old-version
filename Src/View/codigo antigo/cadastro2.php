<?php
require_once "Conexao.php";

$nome =  $_POST['nome'];
$preco = intval ($_POST['preco']);

//Validation if the register already exist in db
$nome_sql = $mysqli->real_escape_string($nome);
$preco_sql = $mysqli->real_escape_string($preco);
$sql_code = "SELECT * from comida where nome = '{$nome_sql}' and preco = '{$preco_sql}' ";
$sql_query = $mysqli->query($sql_code) or die("Error ao cadastrar: " . $mysqli->error);

//Validation
if ($nome == null) {
    $mensagem = "Por favor, digite um nome de comida.";
} else if ($preco == null) {
    $mensagem = "Por favor, digite um preço válido e é números";
} else if (!is_int($preco)) {
    $mensagem = "Por favor, digite um preço no valor numérico (1.00)";
} else if ($preco < 0) {
    $mensagem = "Digite um preço válido e positivo";
} else if ($sql_query->num_rows != 0){
    $mensagem = "Este registro já está cadastrado no banco";
} else {
    $mensagem = "Comida cadastrada com sucesso!";

    $sql_code = "INSERT into comida (nome, preco) values ('{$nome_sql}' , '{$preco_sql}' )";
    $mysqli->query($sql_code) or die("Error ao cadastrar: " . $mysqli->error);
}   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de alimentos</title>
</head>

<body>
    <h1>Cadastro de alimentos</h1>
    <a type="button" href="index.php">Ir pro menu</a>
    <h2>Resultado:</h2>
    <h4><?php echo $mensagem; ?> </h4>
</body>

</html>