<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário tem permissão de admin ou secretaria
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

$produtos = []; // Inicializa para evitar erros

// Se o formulário foi enviado, busca o produto pelo ID ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['busca'])) {
    $busca = $_POST['busca'];

    if (is_numeric($busca)) {
        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
} else {
    $sql = "SELECT * FROM produto ORDER BY nome_prod ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Buscar Produto</title>
    <link rel="stylesheet" href="silvio_pinto_style.css" />
</head>
<body>
    <h2>Silvio José da Silva Pinto</h2>
    <h2>Lista de Produtos</h2>

    <!-- Formulário para buscar produtos -->
    <form action="buscar_produto.php" method="POST">
        <label for="busca">Digite o ID ou nome do produto (opcional):</label>
        <input type="text" id="busca" name="busca" />
        <button type="submit">Pesquisar</button>
    </form>

    <?php if (!empty($produtos)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor Unitário</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= htmlspecialchars($produto['id_produto']) ?></td>
                    <td><?= htmlspecialchars($produto['nome_prod']) ?></td>
                    <td><?= htmlspecialchars($produto['descricao']) ?></td>
                    <td><?= htmlspecialchars($produto['qtde']) ?></td>
                    <td>R$ <?= number_format($produto['valor_unit'], 2, ',', '.') ?></td>
                    <td>
                        <a href="alterar_produto.php?id=<?= htmlspecialchars($produto['id_produto']) ?>">Alterar</a>
                        <a href="excluir_produto.php?id=<?= htmlspecialchars($produto['id_produto']) ?>"
                           onclick="return confirm('Tem certeza que deseja excluir esse produto?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>