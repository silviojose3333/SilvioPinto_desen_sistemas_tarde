<?php
session_start();
require 'conexao.php';

// Verifica se o usuário tem permissão de ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!'); window.location.href='principal.php';</script>";
    exit();
}

// Inicializa variáveis
$usuario = null;

// Se o formulário for enviado, busca o usuário pelo ID ou nome
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_produto'])) {
        $busca = trim($_POST['busca_produto']);

        // Verifica se a busca é um número (ID) ou um nome
     
            $busca = $_POST['busca_produto'];
        
            if (is_numeric($busca)) {
                $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod ASC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
            } else {
                $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome ORDER BY nome_prod ASC";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
            }
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        } 
    
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="styles.css">
    
    <!-- Certifique-se de que o JavaScript está sendo carregado corretamente -->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar Usuário</h2>

    <!-- Formulário para buscar usuário pelo ID ou Nome -->
    <form action="alterar_produto.php" method="POST">
        <label for="busca_produto">Digite o ID ou Nome do usuário:</label>
        <input type="text" id="busca_produto" name="busca_produto" required onkeyup="buscarSugestoes()">
        
        <!-- Div para exibir sugestões de usuários -->
        <div id="sugestoes"></div>
        
        <button type="submit">Buscar</button>
    </form>

    <?php if ($usuario): ?>
        <!-- Formulário para alterar usuário -->
        <form action="processa_alteracao_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_produto']) ?>">


            <label for="nome_prod">Nome do produto:</label>
            <input type="text" id="nome_prod"  name="nome_prod" value="<?= htmlspecialchars($usuario['nome_prod']) ?>" required>

            <label for="descricao">Descrição do produto:</label>
            <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($usuario['descricao']) ?>" required>

            <label for="qtde">Quantidade atual do produto:</label>
            <input type="text" id="qtde" name="qtde" value="<?= htmlspecialchars($usuario['descricao']) ?>" required>

            <label for="valor_unit">Valor por unidade do produto:</label>
            <input type="text" id="valor_unit" name="valor_unit" value="<?= htmlspecialchars($usuario['valor_unit']) ?>" required>


            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>

    <a href="principal.php">Voltar</a>
</body>
</html>