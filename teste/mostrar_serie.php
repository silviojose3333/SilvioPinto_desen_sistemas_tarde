<?php
require_once "funcao.php";

$series=mostrarNovidades();
//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//    $nota = $_POST['nota'];
  //  echo "Nota escolhida: " . intval($nota);
    //$nome_serie=$_POST['serie'] ?? 'Desconhecido';
    //echo "Nome da serie escolhida:".$nome_serie;
   // $sinopse=$_POST['nome'];
    //echo "sinopse da serie escolhida:".$sinopse;
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
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
    
<?php foreach($series as $serie): ?>
<form action="detales_obra.php" method="POST">
    <button type="submit" name="nome" value="<?=htmlspecialchars($serie["id_serie"])?>" style="all: unset; cursor: pointer;">
    <div style="border: 1px solid #ccc; padding: 20px; margin: 10px; display: flex; gap: 20px; align-items: center; background-color: #f9f9f9;">
    <div>
<?php
    echo "<img src='" . htmlspecialchars($serie['imagem']) . "' width='200'><br><br>";
    echo"<h1>". htmlspecialchars($serie["nome_serie"])."</h1>";
    echo"<h2>". htmlspecialchars($serie["tipo"])."</h2>";
    echo"<h3>". htmlspecialchars($serie["genero"])."</h3>";
    echo"<p>". htmlspecialchars($serie["sinopse"])."</p>";
    $nome_series=$serie["nome_serie"];
?>
</div>
</div>
</button>
</form>
<button onclick="abrirModal('<?= htmlspecialchars($nome_series);?>')">Selecionar <?= htmlspecialchars($nome_series) ?></button><br><br>



<?php endforeach;?>

<div class="overlay" id="meuModal">
  <form class="modal" method="POST" action="mostrar_serie.php">
    <h3>Confirmar seleção</h3>
    <p>Você selecionou: <span id="nomeEscolhido"></span></p>


    <input type="hidden" name="serie" id="inputNome">
    <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
    <output name="outputNota">5</output><br><br>
    <button type="submit">Enviar</button>
  </form>
</div>

<script>
function abrirModal(nome) {
  document.getElementById("meuModal").style.display = "flex";
  document.getElementById("nomeEscolhido").textContent = nome;
  document.getElementById("inputNome").value = nome;
  document.body.classList.add("modal-open");
}
</script>

</body>
</html>
