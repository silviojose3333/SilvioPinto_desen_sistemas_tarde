<?php
//habilita relatorio detalhado de erros no mysqli
mysqli_report(MYSQLI_REPORT_ERROR/MYSQLI_REPORT_STRICT);
/*FUNÇÃO PARA CONECTAR AO BANCO DE DADOS 
RETORNA um objeto de concção mysqli ou interonpe o script em caso de erro*/ 

function conectadb(){
    $endereco="localhost";
    $usuario="root";
    $senha="";
    $banco="empresa";
    try{
        $con=new mysqli($endereco,$usuario,$senha,$banco);

        $con->set_charset("utf8mb4");
        return $con;
    
    }catch(Exception $e){
        die("Erro na conexão:".$e->getMessage());
    }
}
?>