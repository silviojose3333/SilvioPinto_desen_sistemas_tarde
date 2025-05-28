<?php
//função para dimencionar a imagem

function redimencionarImagem($imagem,$largura,$altura){
    //obtem as dimenso~es originais da imagem
    list($larguraOriginal,$alturaOriginal)=getimagesize($imagem);

    //cria uma nova imagem com as dimensões especificadas
    $novaImagem=imagecreatetruecolor($largura,$altura);

    //cria uma imagem a partir do arquivo original(formato jpeg)
    $imagemOriginal=imagecreatefromjpeg($imagem);

    //copia e redimenciona a imagem original para a nova imagem
    imagecopyresamplet($novaImagem,$imagemOriginal,0,0,0,0,$largura,$altura,$larguraOriginal,$alturaOriginal);

    //inicia a saida em buffer para capturar os dados da imagem
    ob_start();
    imagejprg($novaImagem);
    $dadosImagem=ob_get_clean();//essa linha que obtem os dados da imagem no buffer

    //libera a memoria 
    imagedestroy($novaImagem);
    imagedestroy($imagemOriginal);

    return $dadosImagem;//retorna os dados da imagem redimencionada


}
// conexao com o banco de dados
$host="localhost";
$dbname="bd_imagem";
$username="root";
$passaword="";

try{
    //cria uma nova instancia de pdo para conectar ao banco de dados
    $pdo= new PDO("mysql:host=$host;dbname=$dbname",$username,$passaword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    if($_SERVER['REQUEST_METHOD'] =='POST' && isset($_FILES['foto'])){
        //codigo abaixo verifica se não ouve erro no upload da foto
        
        if($_FILES['foto']['error']==0){
            $nome=$_POST['nome'];
            $telefone=$_POST['telefone'];
            $nomeFoto=$_FILES['foto']['name'];
            $tipoFoto=$_FILES['foto']['type'];

            //redimenciona  a imagem para 300x400px
            $foto=redimencionarImagem($_FILES['foto']['tmp_name'],300,400);

            //prepara a instrução sql para inserir os dados do funcionaro nos dados do funcionario
            $sql="INSERT INTO funcionarios(nome,telefone,nome_foto,tipo_foto,foto) VALUE (:nome,:telefone,:nome_foto,:tipo_foto,:foto)";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':telefone',$telefone);
            $stmt->bindParam(':nome_foto',$nomeFoto);
            $stmt->bindParam(':tipo_foto',$tipoFoto);
            //o codigo abaixo define o parametro da foto com large object(lob)
            $stmt->bindParam(':foto',$foto,PDO::PARAM_LOB);
            if($stmt->execute()){
                echo "Funcionario cadastrado com sucesso!";
            }else{
                echo"erro ao cadstrar o funcionario";
            }

        }else{
            echo"erro ao fazer upload da foto".$_FILES['foto']['error'];
        }
    }
}catch(PDOException $e){
    echo"erro".$e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de imagems</title>
</head>
<body>
    <h1>Lista de imagems</h1>
<!-- Link para listar funcionarios -->
    <a href="consutar_funcionario.php">Listar funcionarios</a>
</body>
</html>