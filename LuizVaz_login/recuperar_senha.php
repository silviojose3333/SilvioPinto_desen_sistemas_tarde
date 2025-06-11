<?php
session_start();
require_once 'conexao.php';
require_once 'funcoes_email.php';
//arquivo com as funções que gera  senha e simular envio

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST['email'];

    //verifica se o email existe no banco
    $sql="SELECT * FROM usuario WHERE email=:email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario=$stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        //gera uma senha temporaria aleatoria
        $senha_temporaria= gerarsenhatemporaria();
        //senha criptografada
        $senha_hash=password_hash($senha_temporaria,PASSWORD_DEFAULT);

           //atualiza a senha do usuario do banco
           $sql="UPDATE usuario SET senha=:senha ,senha_temporaria=TRUE WHERE email=:email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            //simula o envio do email(grava em 1x1)

            simularEnvioEmail($email, $senha_temporaria);

            echo"<script>alert('Um senha temporaria foi gerado e enviada(simulaçâo).Verifique o arquivo emails_simulados.txt');window.location.href='login.php';</script>";
        
    }else{
        echo "<script>alert('Emial não encontrado')</cript>";
    }
}

?>
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Recuperar Senha</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <h2>Recuperar Senha</h2>
            <form action="recuperar_senha.php" method="POST">
            <label for="email">Digite o email Cadastrado</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Enviar senha Temporaria</button>
        </body>
        </html>