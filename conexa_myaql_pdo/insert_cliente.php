<?php
require_once"conexao.php";
$conexao=conectadb();

$nome="silvio josé da silva pinto";
$endereco="Rua Kalamango,32";
$telefone="(41)5555-5555";
$email="joaosilva@teste.com";

$stmt=$conexao->prepare("insert into cliente (nome,endereco,telefone,email) values(?,?,?,?)");
$stmt->bind_param("ssss",$nome,$endereco,$telefone,$email);

if($stmt->execute()){
    echo"cliente adicionado com sucesso!";
}else{
    echo "Erro ao adicionar cliente:".$stmt->erro;
}
$stmt->close();
$conexao->close();
?>