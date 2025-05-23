<?php
require_once "conexao.php";
require_once "funcao.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tipo = $_POST['tipo_form'];

  if($tipo==="avaliacao"){
    $id=$_POST['id'];
    
    $serie=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $temporada_f=selecionarTemporada1($id);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
  }
  if($tipo==="inserir"){
    $id=$_POST['id'];
    
    
    $serie=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $temporada_f=selecionarTemporada1($id);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
  }else{
    $id=$_POST['nome'];
    
    $serie=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $temporada_f=selecionarTemporada1($id);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
  }
    
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
    <link rel="stylesheet" href="style_sa.css">
    <script src="script.js"></script>
</head>
<body>
    

      <img src= "<?=htmlspecialchars($serie['imagem'])?>" width='200'><br><br>
      <h1><?=htmlspecialchars($serie["nome_serie"])?></h1>
      <h2><?=htmlspecialchars($serie["tipo"])?></h2>
      <h3><?=htmlspecialchars($serie["genero"])?></h3>
      <p><?=htmlspecialchars($serie["sinopse"])?></p>
    
    
      <button onclick="abrir('modalAvaliação<?= $serie['id_serie'] ?>')">avliar</button>
    
      <div id="modalAvaliação<?= $serie['id_serie'] ?>" class="overlay">
          <div class="modal">
              <form method="POST" action="detales_obra.php">
                <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                <input type="hidden" name="tipo_form" value="avaliacao">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f1['id_episodio']) ?>">
                <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                <output name="outputNota">5</output><br><br>
                <button type="submit">Enviar</button>
                <button type="button" onclick="fechar('modalAvaliação<?= $serie['id_serie'] ?>')">Cancelar</button>
            </form>
          </div>
      </div>
      <?php

      foreach($temporadas as $temporada):
        echo"<div class=\"submenu-wrapper\">";
        ?><button type="button" onclick="toggleSubmenu()"><?=htmlspecialchars($temporada['id_temporada'])?></button>
        <button onclick="abrir('modalAvaliação<?= $serie['id_serie'] ?>')">avliar</button>
    
        <div id="modalAvaliação<?= $serie['id_serie'] ?>" class="overlay">
          <div class="modal">
            <form method="POST" action="detales_obra.php">
                <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                <input type="hidden" name="tipo_form" value="avaliacao">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f1['id_episodio']) ?>">
                <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                <output name="outputNota">5</output><br><br>
                <button type="submit">Enviar</button>
                <button type="button" onclick="fechar('modalAvaliação<?= $serie['id_serie'] ?>')">Cancelar</button>
            </form>
          </div>
        </div>
        <?php

          $id_temporada=$temporada['id_temporada'];
          echo"<div class=\"submenu\" id=\"submenuForm\">";
          $episodios=selecionarEpisodio($id_temporada);
            foreach ($episodios as $episodio): ?>
              <label>
                <button onclick="abrir('modalAvaliação<?= $serie['id_serie'] ?>')">avliar</button>
    
                <div id="modalAvaliação<?= $serie['id_serie'] ?>" class="overlay">
                  <div class="modal">
                    <form method="POST" action="detales_obra.php">
                      <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                      <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                      <input type="hidden" name="tipo_form" value="avaliacao">
                      <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f1['id_episodio']) ?>">
                      <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                      <output name="outputNota">5</output><br><br>
                      <button type="submit">Enviar</button>
                      <button type="button" onclick="fechar('modalAvaliação<?= $serie['id_serie'] ?>')">Cancelar</button>
                    </form>
                  </div>
                </div>
                <?=htmlspecialchars($episodio['titulo']); ?>
              </label>
              <button onclick="abrir('modaliserção<?= $serie['id_serie'] ?>')">avliar</button>
    
              <div id="modaliserção<?= $serie['id_serie'] ?>" class="overlay">
                <div class="modal" action="detales_obra.php">
                  <form method="POST">
                    <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                    <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                    <input type="hidden" name="tipo_form" value="inserir">
                    <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f1['id_episodio']) ?>">
                    <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                    <output name="outputNota">5</output><br><br>
                    <button type="submit">Enviar</button>
                    <button type="button" onclick="fechar('modaliserção<?= $serie['id_serie'] ?>')">Cancelar</button>
                  </form>
                </div>
              </div>
                    
              <?php endforeach;
              echo "</div>";
              endforeach;
    
            ?>









</body>
</html>