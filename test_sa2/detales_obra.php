<?php
session_start();
require_once "conexao.php";
require_once "funcao.php";


if(isset($_SESSION['id_usuario'])){
  $id_perfil=$_SESSION['perfil'];
  $sqlperfil="SELECT nome_perfil FROM perfil WHERE id_perfil=:id_perfil";
  $stmtperfil=$pdo->prepare($sqlperfil);
  $stmtperfil->bindParam(':id_perfil',$id_perfil);
  $stmtperfil->execute();
  $perfil=$stmtperfil->fetch(PDO::FETCH_ASSOC);
  $nome_perfil=$perfil['nome_perfil'];
}else{
  $id_perfil=3;
  $sqlperfil="SELECT nome_perfil FROM perfil WHERE id_perfil=:id_perfil";
  $stmtperfil=$pdo->prepare($sqlperfil);
  $stmtperfil->bindParam(':id_perfil',$id_perfil);
  $stmtperfil->execute();
  $perfil=$stmtperfil->fetch(PDO::FETCH_ASSOC);
  $nome_perfil=$perfil['nome_perfil'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tipo = $_POST['tipo_form'];

  if($tipo==="avaliacao"){
    $id=$_POST['id'];
    
    $serie=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $temporada_f=selecionarTemporada1($id);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
    avaliar($_SESSION['id_usuario'],$_POST['nome'],$_POST['nota']);

  }
  elseif($tipo==="inserir"){
    $id=$_POST['id'];
    
    
    $serie=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $temporada_f=selecionarTemporada1($id);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])){
      inserirEpisodio($_POST['nome'],$_POST['text'],$_POST['titulo']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao2'])){
      inserirTemporada($_POST['nome'],$_POST['text']);
    }else{

    }
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
$permissoes=[
  1=>["funcao"=>["adicionar_obra.php","relatorio.php","adicionar_adm.php"]],
  
  2=>["funcao"=>["relatorio.php"]],

  3=>["funcao"=>[]]

  
];
//OBTEMDO AS OPÇÕES DISPONIVEIS PARA O PERFIL LOGADO
$opcoes_menu=$permissoes[$id_perfil];




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
<body><nav>
        <ul class="menu">
            <?php foreach($opcoes_menu as $categoria=>$arquivos):?>
                <li class="dropdown">
                    <a href="#"><?=$categoria?></a>
                    <ul class="dropdown-menu">
                        <?php foreach($arquivos as $arquivo):?>
                            <li>
                                <a href="<?=$arquivo?>"><?=ucfirst(str_replace("_"," ",basename($arquivo,".php")))?></a>
                            </li>
                            <?php endforeach;?>
                            <li>
                                <a href="principal.php">Novidades</a>
                            </li>
                    </ul>

                </li>

                <?php endforeach;?>
                <form action="pesquisa.php" method="POST">
                <input type="text" name="pesquisa" class="pesquisa" id="pesquisa"  placeholder="Pesquisar" >
                    <button type="submit">Pesquisar</button>
                </form>
                <li class="dropdown">
                    <a href="#"><?php echo $nome_perfil;?></a>
                    <ul class="dropdown-menu2">
                      <?php if($id_perfil!=3):?>
                        <li>
                            <a href="alterar_cliente.php">atualizar dados</a>
                        </li>
                      <?php endif;?>
                        <li>
                            <a href="login.php">Trocar de conta</a>
                        </li>
                        <li>
                            <a href="logout.php">Sair da conta</a>
                        </li>
                    </ul>
                </li>
        </ul>
    </nav>
    

      <img src= "<?=htmlspecialchars($serie['imagem'])?>" width='200'><br><br>
      <h1><?=htmlspecialchars($serie["nome_serie"])?></h1>
      <h2><?=htmlspecialchars($serie["tipo"])?></h2>
      <h3><?=htmlspecialchars($serie["genero"])?></h3>

      <p><?=htmlspecialchars($serie["sinopse"])?></p>
      <?php $nota = $episodio_f1['media_nota'] !== null ? number_format($episodio_f1['media_nota'], 1) : '0.0';?>
    <p><?=htmlspecialchars($nota)?>/10</p>
    
    
      <?php if($id_perfil==2):?>
      <button onclick="abrir('modalAvaliação<?= $episodio_f1['id_episodio'] ?>')">avliar</button>
    
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
                <button type="button" onclick="fechar('modalAvaliação<?= $episodio_f1['id_episodio'] ?>')">Cancelar</button>
            </form>
          </div>
      </div>
      <?php else:?>
          <button onclick="pedidoLogar()">alvaliar2</button><br><br>
      <?php endif;?>
      <?php
    
      foreach($temporadas as $index => $temporada):
        $episodio_f=selecionarEpisodio1($temporada['id_temporada']);
        echo"<div class=\"submenu-wrapper\">";
        ?><button type="button" onclick="toggleSubmenu(<?= $index ?>)"><?=htmlspecialchars($temporada['descrisao_tem'])?></button>
        <?php $nota = $episodio_f['media_nota'] !== null ? number_format($episodio_f['media_nota'], 1) : '0.0';?>
        <p><?=htmlspecialchars($nota)?>/10</p>
        <?php if($id_perfil==2):?>
        <button onclick="abrir('modalAvaliação<?= $episodio_f['id_episodio']?>')">avliar</button>
    
        <div id="modalAvaliação<?= $episodio_f['id_episodio'] ?>" class="overlay">
          <div class="modal">
            <form method="POST" action="detales_obra.php">
                <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                <input type="hidden" name="tipo_form" value="avaliacao">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f['id_episodio']) ?>">
                <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                <output name="outputNota">5</output><br><br>
                <button type="submit">Enviar</button>
                <button type="button" onclick="fechar('modalAvaliação<?= $episodio_f['id_episodio'] ?>')">Cancelar</button>
            </form>
          </div>
        </div>
        <?php else:?>
                  <button onclick="pedidoLogar()">avliar</button><br><br>
              <?php endif;?>
                
        <?php

          $id_temporada=$temporada['id_temporada'];?>
          <div class="submenu" id="submenu-<?= $index ?>">
          <?php $episodios=selecionarEpisodio($id_temporada);
          
            foreach ($episodios as $episodio): ?>
              <label>
              <?php if($id_perfil==2):?>
                <button onclick="abrir('modalAvaliação<?= $episodio['id_episodio'] ?>')">avaliar <?= $episodio['descrisao_ep'] ?></button>
    
                <div id="modalAvaliação<?= $episodio['id_episodio'] ?>" class="overlay">
                  <div class="modal">
                    <form method="POST" action="detales_obra.php">
                      <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                      <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                      <input type="hidden" name="tipo_form" value="avaliacao">
                      <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio['id_episodio']) ?>">
                      <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                      <output name="outputNota">5</output><br><br>
                      <button type="submit">Enviar</button>
                      <button type="button" onclick="fechar('modalAvaliação<?= $episodio['id_episodio'] ?>')">Cancelar</button>
                    </form>
                  </div>
                </div>
                <?php else:?>
                  <button onclick="pedidoLogar()">avaliar <?= $episodio['descrisao_ep'] ?></button><br><br>
              <?php endif;?>
                <?=htmlspecialchars($episodio['titulo']); ?>
                <?php $nota = $episodio['media_nota'] !== null ? number_format($episodio['media_nota'], 1) : '0.0';?>
                <p><?=htmlspecialchars($nota)?>/10</p>
              </label>
              
                    
              <?php endforeach;
               if($id_perfil==1):?>
                <button onclick="abrir('modaliserção<?= $episodio_f['id_episodio'] ?>')">avliar</button>
      
                <div id="modaliserção<?= $episodio_f['id_episodio'] ?>" class="overlay">
                  <div class="modal" action="detales_obra.php">
                    <form method="POST">
                      <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                      <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                      <input type="hidden" name="tipo_form" value="inserir">
                      <input type="hidden" name="nome" value="<?= htmlspecialchars($temporada['id_temporada']) ?>">
                      <input type="text" id="text" name="text" placeholder="des" required>
                      <input type="text" id="titulo" name="titulo" placeholder="titulo" required>
                      <button type="submit" name="acao" value="1">Enviar</button>
                      <button type="button" onclick="fechar('modaliserção<?= $episodio_f['id_episodio'] ?>')">Cancelar</button>
                    </form>
                  </div>
                </div>
                <?php else:?>
                  <button onclick="pedidoLogar()">avliar</button><br><br>
              <?php endif;
              echo "</div>";
              endforeach;
              if($id_perfil==1):?>
                <!--<button onclick="abrir('modaliserção<?= $episodio_f1['id_episodio'] ?>')">avliar</button>-->
                <button onclick="abrir('modaliserção0')">avliar</button>

                <!--<div id="modaliserção<?= $episodio_f1['id_episodio'] ?>" class="overlay">-->
                <div id="modaliserção0" class="overlay">
                  <div class="modal" action="detales_obra.php">
                    <form method="POST">
                      <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                      <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                      <input type="hidden" name="tipo_form" value="inserir">
                      <input type="hidden" name="nome" value="<?= htmlspecialchars($serie['id_serie']) ?>">
                      <input type="text" id="text" name="text" placeholder="texto" required>
                      <button type="submit" name="acao2" value="2">Enviar</button>
                      <!--<button type="button" onclick="fechar('modaliserção<?= $episodio_f1['id_episodio'] ?>')">Cancelar</button>-->
                      <button type="button" onclick="fechar('modaliserção0')">Cancelar</button>
                    </form>
                  </div>
                </div>
                <?php else:?>
                  <button onclick="pedidoLogar()">avliar</button><br><br>
              <?php endif;
    
            ?>
</body>
</html>