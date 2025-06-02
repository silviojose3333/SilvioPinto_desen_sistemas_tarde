<?php
    session_start();
    require_once 'conexao.php';
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
    $pesquisa=isset($_POST['pesquisa'])?
    $_POST['pesquisa']:' ';
    $opc=isset($_POST['a'])?
    $_POST['a']:' ';
    $interesses=isset($_POST['generos'])?
    $_POST['generos']:[];
    $opcoes = ['Anime', 'Serie', 'Filme', 'Livro','Jogo'];
    $selecionada = $_POST['tipo'] ?? ' ';
    
    
    $genero=["ação","animação","aventura","biografia ou autobiografia","comedia","corrida","documentário","drama","esporte",
            "estratégia","fantasia","ficcao cientifica","fps","historico","isekai","josei","literatura clássica","mecha","mmorpg","uusical","nao ficcao",
            "plataforma","policial ou crime","puzzle","rpg","romance","seinen","shōjo","shōnen","simulação","slice of life","suspense ou thriller",
            "terror ou horror","terro psicológico","terror de sobrevivencia"];
    $series=pesquisar(isset($_POST['pesquisa'])?$_POST['pesquisa']:'', $_POST['tipo'] ?? '',isset($_POST['generos'])?$_POST['generos']:[],isset($_POST['a'])?$_POST['a']:'Z');
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
        <title>Pesquisa</title>
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
    <body>
    <nav>
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
                <input type="text" name="pesquisa" class="pesquisa" id="pesquisa"  placeholder="Pesquisa" value="<?php echo htmlspecialchars($pesquisa)?>">
                    
                
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
    
    <br>
    <label><input name="a" type="radio" value="Z"<?php if ($opc=='Z') echo 'checked';?> />A-Z</label>
    <label><input name="a" type="radio" value="A" <?php if ($opc=='A') echo 'checked';?>/>Melhor avaliado</label>
    <label><input name="a" type="radio" value="R"<?php if ($opc=='R') echo 'checked';?> />Mais Recente</label>
    <br>
    
    <div class="submenu-wrapper">
            <!--TRAVES DA FUNCAO TOGGLESUBMENU VAZ UM SUB-MENU AO CLICAR NO BOTAO-->
            <button type="button"  onclick="toggleSubmenu(1)">Mais opçoes</button>


            <!-- Submenu com checkboxes (criado com foreach) -->
            <div class="submenu" id="submenu-1">
        <?php
        
        for($i=0;$i<count($genero);$i++){
            
            $valor=$genero[$i];
            $checked=in_array($valor,$interesses)? 'checked':'';
            echo'<li><label>';

            echo '<input type="checkbox" name="generos[]" value="'.htmlspecialchars($valor).'"'.$checked.'>';
             echo $valor;
             echo "</li></label>";
        }
        ?>
        </div>
    </div>
    <select name="tipo" id="tipo"> 
    <!-- Opção para não selecionar nenhum tipo -->
    <option value="" <?= empty($selecionada) ? 'selected' : '' ?>>-- Todos os tipos --</option>

    <?php foreach ($opcoes as $opcao): ?>
        <option value="<?php echo $opcao; ?>" <?= $opcao == $selecionada ? 'selected' : '' ?>>
            <?php echo $opcao; ?>
        </option>
    <?php endforeach; ?>
</select>

        <input type="submit" value="Executar">
    </form>

    <?php foreach($series as $serie):
        if($serie['ativo']==1  ||  $id_perfil==1): ?>
        
<form action="detales_obra.php" method="POST">
    <button type="submit" name="nome" value="<?=htmlspecialchars($serie["id_serie"])?>" style="all: unset; cursor: pointer;">
    <div style="border: 1px solid #ccc; padding: 20px; margin: 10px; display: flex; gap: 20px; align-items: center; background-color: #f9f9f9;">
    <div>
    <?php
    $temporada_f=selecionarTemporada1($serie['id_serie']);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
    ?>
    <div class="mostrarSerie">
    <img src= "<?=htmlspecialchars($serie['imagem'])?>" width='200'><br><br>
    <h1><?=htmlspecialchars($serie["nome_serie"])?></h1>
    <h2><?=htmlspecialchars($serie["tipo"])?></h2>
    <h3><?=htmlspecialchars($serie["genero"])?></h3>
    <p><?=htmlspecialchars($serie["sinopse"])?></p>
    <?php $nota = $episodio_f1['media_nota'] !== null ? number_format($episodio_f1['media_nota'], 1) : '0.0';?>
    <p><?=htmlspecialchars($nota)?>/10</p>
    <input type="hidden" name="tipo_form" value="obra">
    </div>
</div>
</div>
</button>
</form>
<?php if($id_perfil==2):?>
<button class="avaliarSerie" onclick="abrirModal('<?= htmlspecialchars($serie['nome_serie']);?>','<?= htmlspecialchars($serie['id_serie']);?>','meuModal')">Selecionar <?= htmlspecialchars($serie['nome_serie']) ?></button><br><br>


<?php else:?>
    <button class="avaliarSerie" onclick="pedidoLogar()">Selecionar <?= htmlspecialchars($serie['nome_serie']) ?></button><br><br>
<?php endif;?>
<?php endif;?>
<?php endforeach;?>

<div class="overlay" id="meuModal">
  <form class="modal" method="POST" action="principal.php">
    <h3>Confirmar seleção</h3>
    <p>Você selecionou: <span id="nomeEscolhido"></span></p>


    <input type="hidden" name="serie" id="inputNome">
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
  </form>
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
    inputRating.value = (valor+1);
  }
}

    // Inicializa ao carregar a página
    window.addEventListener('DOMContentLoaded', inicializarAvaliacao());
  </script>
    </body>
    </html>