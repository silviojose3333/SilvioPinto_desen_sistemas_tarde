<?php
session_start();
require_once 'conexao.php';
if($_SERVER ["REQUEST_METHOD"]=="POST"){
    $email=$_POST['email'];
    $senha=$_POST['senha'];
    $sql="SELECT * FROM usuario WHERE email=:email";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    $usuario=$stmt->fetch(PDO::FETCH_ASSOC);
    //if($usuario && password_verify($senha,$usuario['senha'])){

    if($usuario && $senha ==$usuario['senha']){
        //LOGIN BEM SUCEDIDO DEFINE ATRAVEIS DE SESSAO
        $_SESSION['usuario']=$usuario['nome'];
        $_SESSION['perfil']=$usuario['idperfil'];
        $_SESSION['id_usuario']=$usuario['id_usuario'];
        
            //redireciona para a pagina principal
        header("Location:principal.php");
        exit();
        }else{
        //LOGIN INVALIDO 
        echo "<script>alert('E-mail ou senha incorretos');window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login</title>
    <link rel="stylesheet" href="style_sa.css">
    <script src="script.js"></script>

</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">email</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Entrar</button>

    </form>
    <p class="linkEsqueciSenha"><a href="enviar_email.php">Esqueci minha senha</a></p>
    <p class="linkCadastro"><a href="cadastrar.php">cadstrar</a></p>
    <p class="linkAnonimo"><a href="principal.php">Entrar em modo Anonimo</a></p>
</body>
</html>