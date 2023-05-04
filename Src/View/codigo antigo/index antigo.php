<?php

require_once "conexao.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de busca</title>
</head>

<body>
    <h1>Lista de comidas</h1>
    <form action="">
        <input name="busca" placeholder="Digite os termos de pesquisa" value="<?php if (isset($_GET['busca'])) echo $_GET['busca']; ?>" style="width: 200px;" type="text">
        <button type="submit">Pesquisar</button>
    </form>

    <br>
    <a type="button" href="cadastro.php">Cadastrar comidas</a>
    <br>

    <br>
    <table border="1" width="700px">
        <tr>
            <th>Número</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Alterar</th>
            <th>Deletar</th>
        </tr>
        <?php
        if (!isset($_GET['busca'])) {
        ?>
            <tr>
                <td colspan="5">Digite algo para pesquisar...</td>
            </tr>
            <?php
        } else {
            $pesquisa = $mysqli->real_escape_string($_GET['busca']);
            $sql_code = "SELECT * from comida where nome LIKE '%$pesquisa%' or preco LIKE '%$pesquisa%' ";
            $sql_query = $mysqli->query($sql_code) or die("Error ao consultar: " . $mysqli->error);

            if ($sql_query->num_rows ==  0) {
            ?>
                <tr>
                    <td colspan="2">Nenhum resultado encontrado.</td>
                </tr>
                <?php
            } else {
                $contador = 1;
                while ($dados = $sql_query->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $contador . "ª"; ?></td>
                        <td><?php echo $dados['nome']; ?></td>
                        <td><?php echo $dados['preco']; ?></td>
                        <form method="POST" action="alterar.php">
                            <input type="hidden" name="id_comida" value="<?php echo $dados['id']; ?>">
                            <td><button type="submit">Alterar registro</button></td>
                        </form>
                        <form method="POST" action="deletar.php">
                            <input type="hidden" name="id_comida" value="<?php echo $dados['id']; ?>">
                            <td><button type="submit">Excluir</button></td>
                        </form>
                    </tr>
        <?php
                    $contador++;
                }
            }
        }
        ?>

    </table>
</body>

</html>