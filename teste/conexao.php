<?php
function conectarBanco(){
    $dsn="mysql:host=localhost;dbname=test_1;charset=utf8";
    $usuario="root";
    $senha="";
    try{
        $conexao=new PDO($dsn,$usuario,$senha,[PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
        return $conexao;
    } catch(PDOexception $e){
        error_log("erro ao conectar ao banco:".$e->getMessage());
        //log sem expor erro ao ususario
        die("erro ao conectar ao banco.");
    }
}
?>