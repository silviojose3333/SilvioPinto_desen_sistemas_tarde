<?php
//SÃO AS OPÇÕES DE TIPOS DE OBRAS PARA O SELECT
$opcoes = ['Anime', 'Serie', 'Filme', 'Livro','Jogo'];
//SÃO AS OPÇÕES DE GENEROS DE OBRAS PARA FAZER AS CHEACKBOXES
$genero=["ação","aventura","mult-player"];
?>





<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de cliente</title>
    <style>
        /*FAZER FUNCIONAR O SUB-MENU DO TIPO DE CLICAR*/ 
        .submenu-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 10;
        }

        .submenu.show {
            display: block;
        }

        .submenu label {
            display: block;
            margin: 5px 0;
        }

        button[type="submit"] {
            margin-top: 20px;
        }
    </style>
    

</head>
<body>
    <h2>Adicionar Obra</h2>
    <form enctype="multipart/form-data" action="functions.php" method="POST">
        <!-- UM CAMPO PARA COLOCAR O NOME DA OBRA-->
        <label for="nome_obra">Nome da obra:</label>
        <input type="text" id="nome_obra" name="nome_obra" required>

        <!--UM CAMPO PARA COLOCAR O TIPO  DA OBRA-->
        <select name="tipo" id="tipo">
        <!--FAZ O SELECT ATAVES DE UM FOREACH ELE PEGA A VARIAVEL OPCAO COM O NOME DE TODOS OS TIPOS DE OBRAS E MOSTRA ATRAZAS DO PHP-->
        <?php foreach ($opcoes as $opcao): ?>
            <option value="<?php echo $opcao; ?>"><?php echo $opcao; ?></option>
        <?php endforeach; ?>
        </select>

        <!--UM CAMPO PARA COLOCAR O GENERO DA OBRA-->
        <div class="submenu-wrapper">
            <!--TRAVES DA FUNCAO TOGGLESUBMENU VAZ UM SUB-MENU AO CLICAR NO BOTAO-->
            <button type="button" onclick="toggleSubmenu()">Opções Avançadas</button>
            <div class="submenu" id="submenuForm">
                <!--USA UM FOREACH PARA ZAVER OS CAMPOS DE CHECKBOX-->
                <?php foreach ($genero as $valor): ?>
                    <label>
                        <input type="checkbox" name="genero[]" value="<?php echo $valor; ?>">
                        <?php echo $valor; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!--UM CAMPO PARA COLOCAR A  SINOPSE DA OBRA-->
        <label for="sinopse">Sinopse:</label>
        <!--ATRAZES DE UMA TEXTAREA-->
        <textarea name="sinopse" id="sinopse" rows="5" cols="40"></textarea><br><br>


        <!--UM CAMPO PARA COLOCAR UMA IMAGEM PARA A OBRA-->
        <label for="imagem_obra">Selecione uma imagem para a obra:</label><br>
        <!--USANDO UM INPUT TYPE FILE PARA ISSO-->
        <input type="file" name="imagem_obra" id="imagem_obra"><br><br>
        

        <button type="submit">Adicionar Obra</button>
</form>

<script>
    //ESSA É A FUNÇÃO QUE FAZ O SUB-MENU FUNCIONAR
    function toggleSubmenu() {
        const submenu = document.getElementById('submenuForm');
        submenu.classList.toggle('show');
    }

    window.addEventListener('click', function (e) {
        const submenu = document.getElementById('submenuForm');
        const button = document.querySelector('.submenu-wrapper button');
        if (!submenu.contains(e.target) && !button.contains(e.target)) {
            submenu.classList.remove('show');
        }
    });
</script>




</body>
</html>