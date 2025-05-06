<?php
require_once "conexao.php";
$conexao=conectadb();
$sql="select id_clente,nome,email from cliente";
$result=$conexao->query($sql);
if($result->num_rows>0){
    while($linha=$result->fetch_assoc()){
        echo "ID:".$linha["id_clente"]." nome:".$linha["nome"]." email:".$linha["email"]."<br>";
    }

    }else{
        echo "nenhum cliente cadastrado.";
    }
    $conexao->close();

?>