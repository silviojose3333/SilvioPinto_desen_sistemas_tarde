<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISAO

if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2){
    echo"<script>alert('acesso negado');window.location.href='principal.php';</script>";
    exit();
}
$usuarios=[];//INICIALIZA A VALIAVEL PARA EVITAR ERRO

//SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO POR ID E NOME
if($_SERVER["REQUEST_METHOD"]=="POST"  && !empty($_POST['busca'])){
    $busca=trim($_POST['busca']);
    //Verifica se a posca é um numero ou um nome

    if(is_numeric($busca)){
        $sql="SELECT * FROM usuario WHERE id_usuario=:busca ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);

    }
    else{
        $sql="SELECT * FROM usuario WHERE nome LIKE :busca_nome ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);

        $stmt->bindValue(':busca_nome',"%$busca%",PDO::PARAM_STR);
    }
}else{
        $sql="SELECT * FROM usuario  ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
    }
    $stmt->execute();
    $usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);



?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Lista de usuarios</h2>
    <!--Formulario para buscar usuarios -->
    <form action="buscar_usuario.php" method="POST">
        <label for="busca">Digite o ID ou NOME:</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>
    <?php if(!empty($usuarios)):?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>EMAIL</th>
                <th>PERFIL</th>
                <th>AÇÕES</th>
            </tr>
            <?php foreach($usuarios as $usuario):?>
                <tr>
                    <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                    <td><?=htmlspecialchars($usuario['nome'])?></td>
                    <td><?=htmlspecialchars($usuario['email'])?></td>
                    <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                    <td>
                        <a href="alterar_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>">Alterar</a>
                    </td>
                    <td>
                        <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>"onclick="return confirm('tem certeza que deseja excluir esse usuario?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach;?>
        </table>
        <?php else:?>
            <p>Nenhum usuario encontrado.</p>
        
        <?endif;?>
        <a href="principal.php">voltar</a>
</body>
</html>