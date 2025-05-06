<?php
require_once "conexao.php";
$conexao=conectadb();


$id_cliente=1;

$stmt=$conexao->prepare("DELETE FROM cliente WHERE id_clente=?");
$stmt->bind_param("i",$id_cliente);

if($stmt->execute()){
    echo"cliente removido com sucesso!";
}else{
    echo "Erro ao remover cliente:".$stmt->erro;
}
$stmt->close();
$conexao->close();
?>