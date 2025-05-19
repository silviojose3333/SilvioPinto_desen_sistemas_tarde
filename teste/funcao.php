<?php
require_once "conexao.php";



function mostrarNovidades(){
    $conexao=conectarBanco();
    $sql_s_obra="SELECT  e.id_episodio,t.id_temporada,s.id_serie,s.imagem,s.genero,s.tipo ,s.sinopse,s.nome_serie FROM episodio e JOIN temporada t on e.idtemporada = t.id_temporada JOIN serie s on t.idserie = s.id_serie  GROUP BY id_serie ORDER BY id_serie  DESC LIMIT 10";
    $stmt=$conexao->prepare($sql_s_obra);
            
    $stmt->execute();
    $serie=$stmt->fetchAll();
    return $serie;
}


function selecionarObra($id){
    $conexao=conectarBanco();
    $sqlS_o="SELECT id_serie,imagem ,genero,tipo,sinopse,nome_serie FROM serie WHERE id_serie=:id_serie";
    $stmt=$conexao->prepare($sqlS_o);
    $stmt->bindParam(":id_serie",$id);
    try{$stmt->execute();
    $serie=$stmt->fetchAll();
    return $serie;
    }catch(PDOException $e){
        error_log("Erro ao inserir cliente:".$e->getMessage());
        echo"Erro ao cadastrar cliente.";
    }
}


function selecionarTemporada($id){
    $conexao=conectarBanco();
    $sqlS_t="SELECT id_temporada,descrisao_tem,idserie FROM temporada WHERE idserie=:idserie";
    $stmt=$conexao->prepare($sqlS_t);
    $stmt->bindParam(":idserie",$id);
    try{$stmt->execute();
        $serie=$stmt->fetchAll();
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente2:".$e->getMessage());
            echo"Erro ao cadastrar cliente2.";
        }
}
function selecionarEpisodio($id){
    $conexao=conectarBanco();
    $sqlS_e="SELECT id_episodio,descrisao_ep, titulo,idtemporada FROM episodio WHERE idtemporada=:idtemporada";
    $stmt=$conexao->prepare($sqlS_e);
    $stmt->bindParam(":idtemporada",$id);
    try{$stmt->execute();
        $serie=$stmt->fetchAll();
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente3:".$e->getMessage());
            echo"Erro ao cadastrar cliente3.";
        }
}



?>
