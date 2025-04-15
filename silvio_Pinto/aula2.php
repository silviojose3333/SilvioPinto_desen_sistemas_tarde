<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        //Função para definir fuso horario padrão 
        date_default_timezone_set('America/Los_Angeles');
        //Manipulando HMTL e PHP
        $data_hoje = date("d/m/y",time());
    ?>
    <p align="center">Hoje é dia <?php echo $data_hoje;?>
    </p>
    <?php
        echo"texto";
        echo"Olá Mundo";
        echo"Isso Abrange 
        varias linhas. As novas linhas serão
        saidas também";
        echo"Isso abrange\nmultiplas linhas. As novas linhas sera \na saidas também";
        echo"Caracteres Escaping são feitos \"Como sees\".";
    ?>
    <br>
    <?php
        $comida_favorita="Italiana";
        print $comida_favorita[2];
        $comida_favorita=" Cozinha ".$comida_favorita;
        echo '<br>';
        print $comida_favorita;
    ?>
</body>
</html>