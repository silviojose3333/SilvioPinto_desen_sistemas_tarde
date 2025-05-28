<!DOCTYPE html>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="contaier">
        <h1>Cadastro</h1>
        <h2>Funcionario</h2>
        <form action="salvar_funcionario.php" method="POST" enctype="multipart/form-date">
            <!-- Campo para inserir o nome do funcionario -->
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required><br>

            <!-- Campo para inserir o telefone do funcionario -->
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" required><br>

            <!-- Campo para fazer upload da foto  do funcionario -->
            <label for="foto">Foto:</label>
            <input type="file" name="foto" id="foto" required><br>

            <!-- botao para enviar o formulario -->
            
            <button type="submit">Cadastrar</button><br>
        </form>
    </div>
</body>
</html>