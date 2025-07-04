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
    $notas = $_POST['rating'] ?? 0;
    $avaliacaoRepetida = avaliar($_SESSION['id_usuario'], $_POST['nome'], $notas);

    if ($avaliacaoRepetida == TRUE) {
      echo "<script>
          window.onload = function() {
              confirmAction(" . json_encode($_SESSION['id_usuario']) . ", " . json_encode($_POST['nome']) . ", " . json_encode($id) . ");
          };
      </script>";
      $avaliacaoRepetida= FALSE;
  }
    
    
    

  }
  elseif($tipo==="alterar"){
    $id=$_POST['id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])){
      
      alterarTemporada($_POST['nome'],$_POST['text']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao2'])){
      alterarEpisodio($_POST['nome'],$_POST['text'],$_POST['titulo']);
    }

  }
  elseif($tipo==="inserir"){
    $id=$_POST['id'];
    
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])){
      inserirEpisodio($_POST['nome'],$_POST['text'],$_POST['titulo']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao2'])){
      inserirTemporada($_POST['nome'],$_POST['text']);
    }
  }else{
    $id=$_POST['nome'];
    
    
  }
    
}elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
  $id=$_GET['nome'];
    
   

}

if(empty($id)){
  header("Location:login.php");
  exit();
}
$serie=selecionarObra($id);
$temporadas=selecionarTemporada($id);
$temporada_f=selecionarTemporada1($id);
$episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
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
    <style>
    .star-rating {
      direction: rtl;
      unicode-bidi: bidi-override;
      font-size: 2rem;
      display: inline-flex;
      cursor: pointer;
    }

    .star {
      color: #ccc;
      transition: color 0.2s;
    }

    .star.filled {
      color: gold;
    }
  </style>
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
    
    <div class="layoutSerie">
      <img src= "<?=htmlspecialchars($serie['imagem'])?>" width='200'><br><br>
      <h1><?=htmlspecialchars($serie["nome_serie"])?></h1>
      <h2><?=htmlspecialchars($serie["tipo"])?></h2>
      <h3><?=htmlspecialchars($serie["genero"])?></h3>
      
      <p><?=htmlspecialchars($serie["sinopse"])?></p>
      <?php $nota = $episodio_f1['media_nota'] !== null ? number_format($episodio_f1['media_nota'], 1) : '0.0';?>
    <p class="nota"><?=htmlspecialchars($nota)?>/10</p>
    <?php $avaliacoesOb= selecionarTotalAvaliacoes($episodio_f1['id_episodio'])?>
        <label for="qtdNota"><p>N.A:<?= htmlspecialchars($avaliacoesOb['quantidade'])?></p>
        <a href="editar_serie.php?id=<?= $serie['id_serie'] ?>" style="padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
        Editar Série
        </a>    
    <?php if ($serie['ativo'] && $id_perfil==1): ?>
      <a class="btn" href="status.php?id=<?= $serie['id_serie'] ?>&acao=desativar&tabela=serie&serie=<?= $id ?>">Desativar</a>
    <?php elseif($id_perfil==1): ?>
      <a class="btn" href="status.php?id=<?= $serie['id_serie'] ?>&acao=ativar&tabela=serie&serie=<?= $id ?>">Ativar</a>
    <?php endif; ?>
    </div>
      <?php if($id_perfil==2):?>
      <button class="serieAvaliar" onclick="abrir('modalAvaliação<?= $episodio_f1['id_episodio'] ?>')">avliar2</button>
    
      <div id="modalAvaliação<?= $episodio_f1['id_episodio'] ?>" class="overlay">
          <div class="modal">
              <form method="POST" action="detales_obra.php">
                <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                <input type="hidden" name="tipo_form" value="avaliacao">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f1['id_episodio']) ?>">
                <!--<input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
                <output name="outputNota">5</output><br><br>-->
                
                <div class="star-rating" id="rating-container">
                  
                  <span class="star" data-value="9">&#9733;</span>
                  <span class="star" data-value="8">&#9733;</span>
                  <span class="star" data-value="7">&#9733;</span>
                  <span class="star" data-value="6">&#9733;</span>
                  <span class="star" data-value="5">&#9733;</span>
                  <span class="star" data-value="4">&#9733;</span>
                  <span class="star" data-value="3">&#9733;</span>
                  <span class="star" data-value="2">&#9733;</span>
                  <span class="star" data-value="1">&#9733;</span>
                  <span class="star" data-value="0">&#9733;</span>
                </div>
    <input type="hidden" id="rating-value" name="rating" value="0">
                <button type="submit">Enviar</button>
                <button type="button" onclick="fechar('modalAvaliação<?= $episodio_f1['id_episodio'] ?>')">Cancelar</button>
            </form>
          </div>
      </div>
      <?php else:?>
          <button class="serieAvaliar" onclick="pedidoLogar()">alvaliar2</button><br><br>
      <?php endif;?>
      <?php
    if($serie['tipo']=="Anime" || $serie['tipo']=="Serie"):
      foreach(array_slice($temporadas, 1) as $index => $temporada):
        if($temporada['ativo']==1  ||  $id_perfil==1):
        $episodio_f=selecionarEpisodio1($temporada['id_temporada']);
        
        echo"<div class=\"submenu-wrapper\">";
        ?><button type="button" class="botao-principal" data-target="submenu-<?= $index ?>"  onclick="toggleSubmenu(<?= $index ?>)"><?=htmlspecialchars($temporada['descrisao_tem'])?></button>
        <?php $nota = $episodio_f['media_nota'] !== null ? number_format($episodio_f['media_nota'], 1) : '0.0';?>
        <?php $avaliacoesTem=selecionarTotalAvaliacoes($episodio_f['id_episodio'])?>
        <label for="qtdNota"><p>N.A:<?= htmlspecialchars($avaliacoesTem['quantidade'])?></p>
        
        <p class="nota"><?=htmlspecialchars($nota)?>/10</p>
        <?php if ($temporada['ativo']  && $id_perfil==1 ): ?>
                        <a class="btn" href="status.php?id=<?= $temporada['id_temporada'] ?>&acao=desativar&tabela=temporada&serie=<?= $id ?>">Desativar</a>
                    <?php elseif($id_perfil==1): ?>
                        <a class="btn" href="status.php?id=<?= $temporada['id_temporada'] ?>&acao=ativar&tabela=temporada&serie=<?= $id ?>">Ativar</a>
                    <?php endif; ?>
        <?php if($id_perfil==2):?>
        <button class="temporadaAvaliar" onclick="abrir('modalAvaliação<?= $episodio_f['id_episodio']?>')">avliar</button>
        <?php if($id_perfil==1):?>
          <button class="temporadaAlterar" onclick="abrir('modalAlterar<?= $episodio_f['id_episodio']?>')">avliar</button>
          <?php endif;?>
        <div id="modalAvaliação<?= $episodio_f['id_episodio'] ?>" class="overlay">
          <div class="modal">
            <form method="POST" action="detales_obra.php">
                <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                <input type="hidden" name="tipo_form" value="avaliacao">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio_f['id_episodio']) ?>">
                <div class="star-rating" id="rating-container">
                  
                  <span class="star" data-value="9">&#9733;</span>
                  <span class="star" data-value="8">&#9733;</span>
                  <span class="star" data-value="7">&#9733;</span>
                  <span class="star" data-value="6">&#9733;</span>
                  <span class="star" data-value="5">&#9733;</span>
                  <span class="star" data-value="4">&#9733;</span>
                  <span class="star" data-value="3">&#9733;</span>
                  <span class="star" data-value="2">&#9733;</span>
                  <span class="star" data-value="1">&#9733;</span>
                  <span class="star" data-value="0">&#9733;</span>
                </div>
    <input type="hidden" id="rating-value" name="rating" value="0">
                <button type="submit">Enviar</button>
                <button type="button" onclick="fechar('modalAvaliação<?= $episodio_f['id_episodio'] ?>')">Cancelar</button>
            </form>
          </div>
        </div>
        <?php else:?>
            <button class="temporadaAvaliar" onclick="pedidoLogar()">avliar</button><br><br>
          <?php endif;?>
              <?php if($id_perfil==1):?>
                
                <div id="modalAlterar<?= $episodio_f['id_episodio'] ?>" class="overlay">
                  <div class="modal">
                    <form method="POST" action="detales_obra.php">
                      <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                      <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                      <input type="hidden" name="tipo_form" value="alterar">
                      <input type="hidden" name="nome" value="<?= htmlspecialchars($temporada['id_temporada']) ?>">
                      <input type="text" id="text" name="text" value="<?php echo htmlspecialchars($temporada['descrisao_tem']) ?>" >
                      <br>
                      <button type="submit" name="acao" value="1">Enviar</button>
                      <button type="button" onclick="fechar('modalAlterar<?= $episodio_f['id_episodio'] ?>')">Cancelar</button>
                    </form>
                  </div>
                </div>
              <?php endif;?>
                
        <?php

          $id_temporada=$temporada['id_temporada'];?>
          <div class="submenu" id="submenu-<?= $index ?>">
          <?php $episodios=selecionarEpisodio($id_temporada);
          
            foreach (array_slice($episodios, 1) as $episodio):
            if($episodio['ativo']==1  ||  $id_perfil==1): ?>

              <label>
              <?php if($id_perfil==2):?>
                <button class="episodioAvaliar" onclick="abrir('modalAvaliação<?= $episodio['id_episodio'] ?>')">avaliar <?= $episodio['descrisao_ep'] ?></button>
    
                <div id="modalAvaliação<?= $episodio['id_episodio'] ?>" class="overlay">
                  <div class="modal">
                    <form method="POST" action="detales_obra.php">
                      <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                      <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                      <input type="hidden" name="tipo_form" value="avaliacao">
                      <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio['id_episodio']) ?>">
                      <div class="star-rating" id="rating-container">
                  
                  <span class="star" data-value="9">&#9733;</span>
                  <span class="star" data-value="8">&#9733;</span>
                  <span class="star" data-value="7">&#9733;</span>
                  <span class="star" data-value="6">&#9733;</span>
                  <span class="star" data-value="5">&#9733;</span>
                  <span class="star" data-value="4">&#9733;</span>
                  <span class="star" data-value="3">&#9733;</span>
                  <span class="star" data-value="2">&#9733;</span>
                  <span class="star" data-value="1">&#9733;</span>
                  <span class="star" data-value="0">&#9733;</span>
                </div>
    <input type="hidden" id="rating-value" name="rating" value="0">
                      <button type="submit">Enviar</button>
                      <button type="button" onclick="fechar('modalAvaliação<?= $episodio['id_episodio'] ?>')">Cancelar</button>
                    </form>
                  </div>
                </div>
                <?php else:?>
                  <button class="episodioAvaliar" onclick="pedidoLogar()">avaliar <?= $episodio['descrisao_ep'] ?></button><br><br>
              <?php endif;?>
                <p><?=htmlspecialchars($episodio['titulo']); ?></p>
                <?php $nota = $episodio['media_nota'] !== null ? number_format($episodio['media_nota'], 1) : '0.0';?>
                
                <p><?=htmlspecialchars($nota)?>/10</p>
                <?php if ($episodio['ativo']  &&  $id_perfil==1 ): ?>
                        <a class="btn" href="status.php?id=<?= $episodio['id_episodio'] ?>&acao=desativar&tabela=episodio&serie=<?= $id ?>">Desativar</a>
                    <?php elseif($id_perfil==1): ?>
                        <a class="btn" href="status.php?id=<?= $episodio['id_episodio'] ?>&acao=ativar&tabela=episodio&serie=<?= $id ?>">Ativar</a>
                    <?php endif; ?>
                
                <?php $avaliacoesEp=selecionarTotalAvaliacoes($episodio['id_episodio'])?>
                <label><p>N.A:<?= htmlspecialchars($avaliacoesEp['quantidade'])?></p>
              </label>

              <?php if($id_perfil==1):?>
                <button class="episodioAlterar" onclick="abrir('modalAlterar-<?= $episodio['id_episodio']?>')">avliar</button>
              <div id="modalAlterar-<?= $episodio['id_episodio'] ?>" class="overlay">
          <div class="modal">
            <form method="POST" action="detales_obra.php">
                <h3>Comentar sobre <?= htmlspecialchars($serie['nome_serie'] ) ?></h3>
                <input type="hidden" name="id" value="<?= $serie['id_serie']  ?>">
                <input type="hidden" name="tipo_form" value="alterar">
                <input type="hidden" name="nome" value="<?= htmlspecialchars($episodio['id_episodio']) ?>">
                <input type="text" id="text" name="text" value="<?php echo htmlspecialchars($episodio['descrisao_ep']) ?>" >
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($episodio['titulo']) ?>">
                <br>
                <button type="submit" name="acao2" value="2">Enviar</button>
                <button type="button" onclick="fechar('modalAlterar-<?= $episodio['id_episodio'] ?>')">Cancelar</button>
            </form>
          </div>
        </div>
              <?php endif;?>
              
              <?php endif;?>
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
              <?php endif;
              echo "</div>";
              endif;
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
              <?php endif;
              endif;
    
            ?>
            <script>
    function inicializarAvaliacao() {
  const estrelas = document.querySelectorAll('.star');
  const inputRating = document.getElementById('rating-value');

  estrelas.forEach(estrela => {
    estrela.addEventListener('click', function () {
      const valor = this.getAttribute('data-value');
      atualizarEstrelas(valor);
      salvarValor(valor);
    });
  });

  function atualizarEstrelas(valorSelecionado) {
    estrelas.forEach(estrela => {
      const valorEstrela = estrela.getAttribute('data-value');
      estrela.classList.toggle('filled', valorEstrela <= valorSelecionado);
    });
  }

  function salvarValor(valor) {
    const valorIncrementado = parseInt(valor) + 1;
  inputRating.value = valorIncrementado;
  }
}

    // Inicializa ao carregar a página
    window.addEventListener('DOMContentLoaded', inicializarAvaliacao());
  </script>
</body>
</html>