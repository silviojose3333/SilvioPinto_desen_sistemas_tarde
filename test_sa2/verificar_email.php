<?php
require_once "conexao.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

//ARQUIVO COM AS FUNÇOES QUE GERAM SENHA E SIMULAM O ENVIO
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST['email'];
    //VERIFICA SE O EMAIL EXISTE NO BANCO
    $sql="SELECT * FROM usuario WHERE email=:email";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':email',$email);
    $stmt->execute();
    $usuario=$stmt->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        //gera uma senha temporaria aleatoria
        $codigo=bin2hex(random_bytes(4));
        $headers="From:silvio_j_pinto@estudante.sesisenai.org.br";
        $mail= new PHPMailer(true);
        try{
        $mail->isSMTP();
        $mail->host='stmp.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username='silvio_j_pinto@estudante.sesisenai.org.br';
        $mail->Password='senha_de_app';
        $mail->STMPSecure='tls';
        $mail->port=587;

        $mail->setFrom('silvio_j_pinto@estudante.sesisenai.org.br','silvio');
        $mail->addAddress($usuario['email'],$usuario['nome_usuario']);

        $mail->isHTML(true);
        $mail->subject='codigo de verificação do site XXXX';
        $mail->Body="<h2>$codigo</h2>";
        $mail->AltBody="$codigo";

        $mail->send();
        

        }catch(Exception $e){
            echo"Error ao enviar e-mai: {$mail->ErrorInfo}";
        }




    }else{
        echo"<script>alert('email não encontrado!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Recuperar senha</h2>
    <form action="alterar_senha.php" method="POST">
    <label for="cogigo">Colocar o Codigo do email enviado para <?=htmlspecialchars($email)?></label>
    <input type="codigo" id="codigo" name="codigo" required>
    <button type="submit">Enviar codigo</button>


    </form>
</body>
</html>