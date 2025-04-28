<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Pesqisa</title>
    <?php
    $pesquisa=isset($_POST['pesquisa'])?
    $_POST['pesquisa']:'';
    $opcao=isset($_POST['a'])?
    $_POST['a']:'';
    $interesses=isset($_POST['generos'])?
    $_POST['generos']:[];
    ?>
    
</head>
<body class="pes">
    
    <form method="POST" action="teste1.php">
    <input type="text" name="pesquisa" class="pesquisa" id="pesquisa"  placeholder="Pesquisa" value="<?php echo htmlspecialchars($pesquisa)?>">
    <br>
    <label><input name="a" type="radio" value="Z"<?php if ($opcao=='Z') echo 'checked';?> />A-Z</label>
    <label><input name="a" type="radio" value="A" <?php if ($opcao=='A') echo 'checked';?>/>Melhor avaliado</label>
    <label><input name="a" type="radio" value="R"<?php if ($opcao=='R') echo 'checked';?> />Mais Recente</label>
    <br>
    <label><input type="checkbox" name="generos[]" value="terror" <?php if(in_array('terror',$interesses)) echo'checked'?>>teste1</label>
    <label><input type="checkbox" name="generos[]" value="romance" <?php if(in_array('romance',$interesses)) echo'checked'?>>teste2</label>
    <ul class="menu">
        <?php
        $genero=["ação","aventura","mult-player"];
        for($i=0;$i<count($genero);$i++){
            $valor=$genero[$i];
            $checked=in_array($valor,$interesses)? 'checked':'';
            echo'<li><label>';

            echo '<input type="checkbox" name="generos[]" value="'.htmlspecialchars($valor).'"'.$checked.'>';
             echo $valor;
             echo "</li></label>";
        }
        ?>
</ul>
    <input type="submit" value="Executar">
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['a'])){
        $acao = $_POST['a'];
        switch ($acao) {
            case'Z':
                echo "<p>A-Z</p>";
                break;
            case'A':
                echo "<p>Melhor avaliado</p>";
                break;
            case'R':
                echo "<p>Mais Recente</p>";
                break;
            default:
            echo "<p>Nada</p>";
        } 
    }
    foreach($interesses as $interesse){
        echo $interesse."<br>";
    }
    echo $pesquisa;
    ?>


</body>
</html>