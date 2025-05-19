<?php
require_once "conexao.php";
require_once "funcao.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id=$_POST['nome'];
    echo "id serie".$_POST['nome'];
    $series=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $campo1 = $_POST['campo1'] ?? '';
    $campo2 = $_POST['campo2'] ?? '';
    //echo "<p>Você digitou:</p>";
    //echo "Campo 1: " . htmlspecialchars($campo1) . "<br>";
    //echo "Campo 2: " . htmlspecialchars($campo2) . "<br>";
    
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #customAlert {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }
        #alertBox {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 10px;
        }
        
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
    body.modal-open {
      overflow: hidden;
    }
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 10;
    }
    .modal {
      background: white;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
      text-align: center;
    }
    .modal input {
      margin: 10px 0;
      width: 90%;
      padding: 8px;
    }
  </style>
</head>
<body>
    <?php foreach($series as $serie):?>
    <?php
    echo "<img src='" . htmlspecialchars($serie['imagem']) . "' width='200'><br><br>";
    echo"<h1>". htmlspecialchars($serie['nome_serie'])."</h1>";
    echo"<h2>". htmlspecialchars($serie["tipo"])."</h2>";
    echo"<h3>". htmlspecialchars($serie["genero"])."</h3>";
    echo"<p>". htmlspecialchars($serie["sinopse"])."</p>";
    ?> <button onclick="abrirModal('<?= htmlspecialchars($serie['id_serie']);?>','<?= htmlspecialchars($serie['id_serie']);?>','meuModal')">Selecionar <?= htmlspecialchars($serie['nome_serie']) ?></button><br><br><?php

    foreach($temporadas as $temporada):
        echo"<div class=\"submenu-wrapper\">";
        ?><button type="button" onclick="toggleSubmenu()"><?=htmlspecialchars($temporada['id_temporada'])?></button>
        <button onclick="abrirModal('<?= htmlspecialchars($temporada['id_temporada']);?>','<?= htmlspecialchars($serie['id_serie']);?>','meuModal')">Selecionar <?= htmlspecialchars($temporada['id_temporada']) ?></button><br><br><?php

        $id_temporada=$temporada['id_temporada'];
        echo"<div class=\"submenu\" id=\"submenuForm\">";
            $episodios=selecionarEpisodio($id_temporada);
                 foreach ($episodios as $episodio): ?>
                    <label>
                    <button onclick="abrirModal('<?= htmlspecialchars($episodio['id_episodio']);?>','<?= htmlspecialchars($serie['id_serie']);?>','meuModal')">Selecionar <?= htmlspecialchars($episodio['id_episodio']) ?></button><br><br>
                        <?=htmlspecialchars($episodio['titulo']); ?>
                    </label>
                    <button onclick="abrirModal('<?= htmlspecialchars($episodio['id_episodio']);?>','<?= htmlspecialchars($serie['id_serie']);?>','meuModal2')">Abrir Alerta com Inputs</button>
                    
                <?php endforeach;
            echo"</div>";
         endforeach;
    
?>
<?php endforeach;?>
<div class="overlay" id="meuModal">
  <form class="modal" method="POST" action="detales_obra.php">
    <h3>Confirmar seleção</h3>
    <p>Você selecionou: <span id="nomeEscolhido"></span></p>


    <input type="hidden" name="nome" id="inputNome">
    <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
    <output name="outputNota">5</output><br><br>
    <button type="submit">Enviar</button>
  </form>
</div>



<!-- Modal -->
<div class="overlay" id="meuModal2">
  <form class="modal" method="POST" action="detales_obra.php">
    <h3>Confirmar seleção</h3>
    <p>Você selecionou: <span id="nomeEscolhido"></span></p>


    <input type="hidden" name="nome" id="inputNome">
    
    <button type="submit">Enviar</button>
  </form>
</div>

<?php 

?>


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

    function abrirModal(nome,serie,form) {
  document.getElementById(form).style.display = "flex";
  document.getElementById("nomeEscolhido").textContent = nome;
  document.getElementById("inputNome").value = serie;
  document.body.classList.add("modal-open");
}
function abrirAlerta(serie) {
    document.getElementById("customAlert").style.display = "flex";
    document.getElementById("inputNome").value = serie;
}

function fecharAlerta() {
    document.getElementById("customAlert").style.display = "none";
}
</script>
</body>
</html>