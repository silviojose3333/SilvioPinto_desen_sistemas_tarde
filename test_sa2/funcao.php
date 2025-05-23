<?php
require_once "conexao.php";



function mostrarNovidades(){
    global $pdo;
    $sql_s_obra="SELECT  e.id_episodio,t.id_temporada,s.id_serie,s.imagem,s.genero,s.tipo ,s.sinopse,s.nome_serie FROM episodio e JOIN temporada t on e.idtemporada = t.id_temporada JOIN serie s on t.idserie = s.id_serie  GROUP BY id_serie ORDER BY id_serie  DESC LIMIT 10";
    $stmt=$pdo->prepare($sql_s_obra);
            
    $stmt->execute();
    $serie=$stmt->fetchAll();
    return $serie;
}


function selecionarObra($id){
    global $pdo;
    $sqlS_o="SELECT id_serie,imagem ,genero,tipo,sinopse,nome_serie FROM serie WHERE id_serie=:id_serie";
    $stmt=$pdo->prepare($sqlS_o);
    $stmt->bindParam(":id_serie",$id);
    try{$stmt->execute();
    $serie=$stmt->fetch(PDO::FETCH_ASSOC);
    return $serie;
    }catch(PDOException $e){
        error_log("Erro ao inserir cliente:".$e->getMessage());
        echo"Erro ao cadastrar cliente.";
    }
}


function selecionarTemporada($id){
    global $pdo;
    $sqlS_t="SELECT id_temporada,descrisao_tem,idserie FROM temporada WHERE idserie=:idserie";
    $stmt=$pdo->prepare($sqlS_t);
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
    global $pdo;
    $sqlS_e="SELECT id_episodio,descrisao_ep, titulo,idtemporada FROM episodio WHERE idtemporada=:idtemporada";
    $stmt=$pdo->prepare($sqlS_e);
    $stmt->bindParam(":idtemporada",$id);
    try{$stmt->execute();
        $serie=$stmt->fetchAll();
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente3:".$e->getMessage());
            echo"Erro ao cadastrar cliente3.";
        }
}
function selecionarTemporada1($id){
    global $pdo;
    $sqlS_t="SELECT id_temporada,descrisao_tem,idserie FROM temporada WHERE idserie=:idserie ORDER BY id_temporada ASC LIMIT 1";
    $stmt=$pdo->prepare($sqlS_t);
    $stmt->bindParam(":idserie",$id);
    try{$stmt->execute();
        $serie=$stmt->fetch(PDO::FETCH_ASSOC);
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente2:".$e->getMessage());
            echo"Erro ao cadastrar cliente2.";
        }
}
function selecionarEpisodio1($id){
    global $pdo;
    $sqlS_e="SELECT id_episodio,descrisao_ep, titulo,idtemporada FROM episodio WHERE idtemporada=:idtemporada ORDER BY id_episodio ASC LIMIT 1";
    $stmt=$pdo->prepare($sqlS_e);
    $stmt->bindParam(":idtemporada",$id);
    try{$stmt->execute();
        $serie=$stmt->fetch(PDO::FETCH_ASSOC);
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente3:".$e->getMessage());
            echo"Erro ao cadastrar cliente3.";
        }
}



?>