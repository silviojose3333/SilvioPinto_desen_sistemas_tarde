<?php
session_start();
require 'conexao.php';

// Verifica se o usuário tem permissão de admin ou secretaria
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

$produto = null;

// Se o formulário for enviado, busca o produto pelo ID ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_produto'])) {
        $busca = trim($_POST['busca_produto']);

        if (is_numeric($busca)) {
            $sql = "SELECT * FROM produto WHERE id_produto = :busca";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
        }

        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            echo "<script>alert('Produto não encontrado!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="silvio_pinto_style.css" />
</head>
<body>
    <h2>Alterar Produto</h2>

    <!-- Formulário para buscar produto -->
    <form action="alterar_produto.php" method="POST">
        <label for="busca_produto">Digite o ID ou Nome do produto:</label>
        <input type="text" id="busca_produto" name="busca_produto" required>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($produto): ?>
        <!-- Formulário para alterar produto -->
        <form action="processa_alteracao_produto.php" method="POST">
            <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produto']) ?>">

            <label for="nome_prod">Nome do Produto:</label>
            <input type="text" id="nome_prod" name="nome_prod" required value="<?= htmlspecialchars($produto['nome_prod']) ?>">

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea>

            <label for="qtde">Quantidade:</label>
            <input type="number" id="qtde" name="qtde" min="0" required value="<?= htmlspecialchars($produto['qtde']) ?>">

            <label for="valor_unit">Valor Unitário:</label>
            <input type="number" id="valor_unit" name="valor_unit" step="0.01" min="0" required value="<?= htmlspecialchars($produto['valor_unit']) ?>">

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>