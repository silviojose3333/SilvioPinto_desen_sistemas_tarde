<?php
require_once "conexao.php";

$conexao=conectarBanco();

$idCliente=$_GET['id']?? null;
$cliente=null;
$msgErro="";

function buscarclientePorid($idCliente,$conexao){
    $stmt=$conexao->prepare("SELECT id_clente,nome,endereco,telefone,email FROM cliente WHERE id_clente=:id");
    $stmt->bindParam(":id",$idCliente,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch();
}

if($idCliente && is_numeric($idCliente)){
    $cliente=buscarclientePorid($idCliente,$conexao);
    if(!$cliente){
        $msgErro="Erro:cliente não emcantrado";
    }
}else{
    $msgErro="Digite o ID do cliente para buscar os dados.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Cliente</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function habilitarEdicao(campo){
            document.getElementById(campo).removeAttributs("readonly");
        }
    </script>
</head>
<body>
    <h2>Atualizar Cliente</h2>
    <?php
    if($msgErro):?>
        <p style="color:red;"><?=htmlspecialchars($msgErro)
    ?>
    <form action="atualizarcliente.php" method="GET">
        <label for="id">ID do cliente:</label>
        <input type="number" id="id" name="id" required>
        <button type="submit">Buscar</button>
    </form>
    <?php else:?>

        <form action="processaratualizacao.php" method="POST">
            <input type="hidden" name="id_cliente" value="<?=htmlspecialchars($cliente["id_clente"])?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($cliente["nome"])?>" readony onlick="habilitarEdicao('nome')">

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($cliente["endereco"])?>" readony onlick="habilitarEdicao('endereco')">
        
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?=htmlspecialchars($cliente["telefone"])?>" readony onlick="habilitarEdicao('telefone')">

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?=htmlspecialchars($cliente["email"])?>" readony onlick="habilitarEdicao('email')">

            <button type="submit">Atualizar Cliente</button>
        </form>
        <?php endif;?>
</body>
</html>