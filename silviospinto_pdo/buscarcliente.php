<?php
require_once "conexao.php";

$conexao=conectarBanco();

$sql="SELECT id_clente,nome,endereco,telefone,email FROM cliente ORDER BY nome ASC";
$stmt = $conexao->prepare($sql);
$stmt->execute();
$clientes=$stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Todos os Clientes Cadastrados</h2>
    <?php
    if(!$clientes):
    ?>
    <p style="color:red;">nenhum cliente cadastrado no banco de dados</p>
    <?php
    else:
    ?>
    <table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Endereco</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Ação</th>
</tr>
<?php foreach($clientes as $cliente):?>
<tr>
    <td><?=htmlspecialchars($cliente["id_clente"])?></td>
    <td><?=htmlspecialchars($cliente["nome"])?></td>
    <td><?=htmlspecialchars($cliente["endereco"])?></td>
    <td><?=htmlspecialchars($cliente["telefone"])?></td>
    <td><?=htmlspecialchars($cliente["email"])?></td>
    <td>
        <a href="atualizarcliente.php?id=<?=$cliente["id_clente"]?>">Editar</a>
</td>
</tr>
<?php  endforeach;?>
</table>
<?php endif;?>
</body>
</html>