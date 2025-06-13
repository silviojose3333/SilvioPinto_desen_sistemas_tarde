<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário tem permissão de ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produto = $_POST['id_produto'];
    $nome_prod = trim($_POST['nome_prod']);
    $descricao = trim($_POST['descricao']);
    $qtde = intval($_POST['qtde']);
    $valor_unit = floatval($_POST['valor_unit']);

    try {
        $sql = "UPDATE produto 
                SET nome_prod = :nome_prod, descricao = :descricao, qtde = :qtde, valor_unit = :valor_unit 
                WHERE id_produto = :id_produto";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome_prod', $nome_prod);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':qtde', $qtde, PDO::PARAM_INT);
        $stmt->bindParam(':valor_unit', $valor_unit);
        $stmt->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Produto alterado com sucesso!'); window.location.href='buscar_produto.php';</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao alterar o produto!'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Erro no banco de dados: " . $e->getMessage() . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Método inválido!'); window.location.href='buscar_produto.php';</script>";
}