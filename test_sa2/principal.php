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
    //OBTEMDO O NOME DO PERFIL DO USUARIO LOGADO

    //DEFINIÇÃO DAS PERMISSOES POR PERFIL
    $series=mostrarNovidades();
    $permissoes=[
        1=>["funcao"=>["adicionar_obra.php","relatorio.php","adicionar_adm.php"]],
        
        2=>["funcao"=>["relatorio.php"]],

        3=>["funcao"=>[]]

        
    ];
    //OBTEMDO AS OPÇÕES DISPONIVEIS PARA O PERFIL LOGADO
    $opcoes_menu=$permissoes[$id_perfil];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id=$_POST['serie'];
    $serie=selecionarObra($id);
    $temporadas=selecionarTemporada($id);
    $temporada_f=selecionarTemporada1($id);
    $episodio_f1=selecionarEpisodio1($temporada_f['id_temporada']);
    avaliar($_SESSION['id_usuario'],$episodio_f1['id_episodio'],$_POST['nota']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novidades</title>
    <link rel="stylesheet" href="style_sa.css">
    <script src="script.js"></script>
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
    <?php foreach($series as $serie): ?>
<form action="detales_obra.php" method="POST">
    <button type="submit" name="nome" value="<?=htmlspecialchars($serie["id_serie"])?>" style="all: unset; cursor: pointer;">
    <div style="border: 1px solid #ccc; padding: 20px; margin: 10px; display: flex; gap: 20px; align-items: center; background-color: #f9f9f9;">
    <div>

    <img src= "<?=htmlspecialchars($serie['imagem'])?>" width='200'><br><br>
    <h1><?=htmlspecialchars($serie["nome_serie"])?></h1>
    <h2><?=htmlspecialchars($serie["tipo"])?></h2>
    <h3><?=htmlspecialchars($serie["genero"])?></h3>
    <p><?=htmlspecialchars($serie["sinopse"])?></p>
    <?php $nota = $serie['media_nota'] !== null ? number_format($serie['media_nota'], 1) : '0.0';?>
    <p><?=htmlspecialchars($nota)?>/10</p>

    <input type="hidden" name="tipo_form" value="obra">
</div>
</div>
</button>
</form>
<?php if($id_perfil==2):?>
<button onclick="abrirModal('<?= htmlspecialchars($serie['nome_serie']);?>','<?= htmlspecialchars($serie['id_serie']);?>','meuModal')">Selecionar <?= htmlspecialchars($serie['nome_serie']) ?></button><br><br>


<?php else:?>
    <button onclick="pedidoLogar()">Selecionar <?= htmlspecialchars($serie['nome_serie']) ?></button><br><br>
<?php endif;?>
<?php endforeach;?>

<div class="overlay" id="meuModal">
  <form class="modal" method="POST" action="principal.php">
    <h3>Confirmar seleção</h3>
    <p>Você selecionou: <span id="nomeEscolhido"></span></p>


    <input type="hidden" name="serie" id="inputNome">
    <input type="range" id="nota" name="nota" min="1" max="10" value="5" oninput="outputNota.value = nota.value">
    <output name="outputNota">5</output><br><br>
    <button type="submit">Enviar</button>
  </form>
</div>
</body>
</html>