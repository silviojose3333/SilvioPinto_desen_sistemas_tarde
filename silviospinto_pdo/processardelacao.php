<?php
require_once "conexao.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $conexao=CONECTARbANCO();

    $id=filter_var($_POST["id"],FILTER_SANITIZE_NUMBER_INT);

    //if()

    $sql="DELETE FROM cliente WHERE id_clente=:id";
    $stmt=$conexao->prepare($sql);
    $stmt->bindParam(":id",$id,PDO::PARAM_INT);

    try{
        $stmt->execute();
        echo"Cliente excluido com sucesso!";
    } catch(PDOException $e){
        error_log("Erro ao excluir cliente:".$e->fetMenssage());
        echo"Erro ao excluir cliente";
    }

}
?>