<?php
//Definição das credenciais da acesso ao nanco de doados 

$nomeservidor = "localhost"; //Endereço do servidor
$usuario = "root";          //nome dousuario do banco
$senha = "";                //senha do banco
$bancodedados = "empresa";  //nome do bancode dados

//criação da conexão com mysql
$conn=mysqli_connect($nomeservidor,$usuario,$senha,$bancodedados);



//verifica a conexao
if(!$conn){
    die("conexão falhou".mysql_connect_error());
}
mysqli_set_charset($conn,"utf8mb4");

echo"conexão bem-sucedida";
//consulta sql para obter clientes
$sql="select id_clente,nome,email from cliente";
$result=mysqli_query($conn,$sql);
//verifica se há resultados na consulta 
if(mysqli_num_rows($result)>0){
    //itera sobre os resultados
    while($linha=mysqli_fetch_assoc($result)){
        echo "ID:".$linha["id_clente"]."- nome:".$linha["nome"]."-email:".$linha["email"]."<br>";
    }
}else{
    echo"nenhuma resultado encontrado";
}
//fecha a conexão com o banco de dados
mysqli_close($conn);
?>