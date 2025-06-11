<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISAO

if($_SESSION['perfil']!=1){
    echo"acesso negado";
    exit;

}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nome=$_POST['nome_prod'];
    $descricao=$_POST['descricao'];
    $qtde=$_POST['qtde'];
    $valor=$_POST['valor_unit'];

    $sql="INSERT INTO produto(nome_prod,descricao,qtde,valor_unit) VALUES (:nome_prod,:descricao,:qtde,:valor_unit)";
    $stmt= $pdo->prepare($sql);
    $stmt -> bindParam(':nome_prod',$nome);
    $stmt -> bindParam(':descricao',$descricao);
    $stmt -> bindParam(':qtde',$qtde);
    $stmt -> bindParam(':valor_unit',$valor);   

if($stmt->execute()){
    echo "<script>alert('Produto cadastrado com sucesso!(');</script>";

}else{
    echo "<script>alert('Erro ao cadastrar!');</script>";
}

}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastrar usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastar usuario</h2>
    <form action="cadastro_produto.php" method="POST">
        <label for="nome_prod">Nome do produto:</label>
        <input type="text" id="nome_prod" name="nome_prod" required>

        <label for="descricao">Descrição do produto:</label>
        <input type="text" id="descricao" name="descricao" required>

        <label for="qtde">Quantidade atual do produto:</label>
        <input type="text" id="qtde" name="qtde" required>

        <label for="valor_unit">Valor por unidade do produto:</label>
        <input type="text" id="valor_unit" name="valor_unit" required>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    
    </form>

    <a href="principal.php">Voltar</a>
</body>
</html>
