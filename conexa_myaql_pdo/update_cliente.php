<?php
require_once "conexao.php";
$conexao=conectadb();

$nome="maria da silva";
//Carlos Pereira
$endereco="Rua Kalamango,32";
$telefone="(41)5555-5555";
$email="joaosilva@teste.com";

$id_cliente=3;

$stmt=$conexao->prepare("UPDATE cliente SET nome=?,endereco=?,telefone=?,email=? WHERE id_clente=?");
$stmt->bind_param("ssssi",$nome,$endereco,$telefone,$email,$id_cliente);
if($stmt->execute()){
    echo "Cliente atualizado com sucesso!";
}else{
    echo "Erro ao atualizar o cliente".$stmt->error;
}
$stmt->close();
$conexao->close();
?>