<?php
require_once "conexao.php";



function mostrarNovidades(){
    global $pdo;
    $sql_s_obra="SELECT s.*, ROUND(AVG(a.nota), 1) AS media_nota
FROM serie s
LEFT JOIN temporada t ON t.idserie = s.id_serie
LEFT JOIN episodio e ON e.idtemporada = t.id_temporada
LEFT JOIN avaliacao a ON a.idepisodio = e.id_episodio
GROUP BY s.id_serie
ORDER BY  s.id_serie  DESC LIMIT 10";
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
    $sqlS_e="SELECT ROUND(AVG(a.nota), 1) AS media_nota,e.* FROM episodio e JOIN avaliacao a ON a.idepisodio = e.id_episodio WHERE e.idtemporada=:idtemporada GROUP BY e.id_episodio";
    $stmt=$pdo->prepare($sqlS_e);
    $stmt->bindParam(":idtemporada",$id);
    try{$stmt->execute();
        $serie=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente3:".$e->getMessage());
            echo"Erro ao cadastrar cliente3.";
        }
}
/*function selecionarTotalAvaliacoes($id){
    global $pdo;
    $sqlS_e="SELECT COUNT(a.idepisodio) AS quantidade, 1) AS media_nota,e.* FROM episodio e JOIN avaliacao a ON a.idepisodio = e.id_episodio WHERE a.idepisodio=:idepisodio GROUP BY e.id_episodio";
    $stmt=$pdo->prepare($sqlS_e);
    $stmt->bindParam(":idepisodio",$id);
    try{$stmt->execute();
        $serie=$stmt->fetch(PDO::FETCH_ASSOC);
        return $serie;
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente3:".$e->getMessage());
            echo"Erro ao cadastrar cliente3.";
        }
}*/
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
    $sqlS_e="SELECT ROUND(AVG(a.nota), 1) AS media_nota,e.* FROM episodio e 
    JOIN avaliacao a ON a.idepisodio = e.id_episodio WHERE e.idtemporada=:idtemporada ORDER BY id_episodio ASC LIMIT 1";
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

function avaliar($usuario,$id_episodio,$nota){
    global $pdo;
    
    
    
    $sql_va="SELECT idusuario,idepisodio FROM avaliacao WHERE idusuario=:idusuario AND idepisodio=:idepisodio";
    $stmt=$pdo->prepare($sql_va);
    $stmt->bindParam(":idusuario",$usuario);
    $stmt->bindParam(":idepisodio",$id_episodio);
    
    try{
        $stmt->execute();
        $dados=$stmt->fetchAll();
        if (count($dados) > 0) {
            echo "<script>return confirm('voce ja avaliou essa obra,você deseja alterar a nota ');</script>";
            echo"fogo no cu";
        } else {
            

            $dataAtual = date('Y-m-d H:i:s');
    
            $sql_a="INSERT INTO avaliacao (data_nota,  nota , idusuario, idepisodio ) VALUES (:data_nota,  :nota , :idusuario, :idepisodio)";
            $stmt=$pdo->prepare($sql_a);
            $stmt->bindParam(":data_nota",$dataAtual);
            $stmt->bindParam(":nota",$nota);
            $stmt->bindParam(":idusuario",$usuario);
            $stmt->bindParam(":idepisodio",$id_episodio);
            try{$stmt->execute();
            }catch(PDOException $e){
                error_log("Erro ao inserir cliente3:".$e->getMessage());
                echo"Erro ao cadastrar cliente3.";
            }
        }
    }catch(PDOException $e){
        error_log("Erro ao inserir cliente3:".$e->getMessage());
        echo"Erro ao cadastrar cliente3.";
    }
    
}

function pesquisar($nome,$tipo,$genero,$order){
    global $pdo;
        
    $genero_p = implode("%", $genero);
    
    $nomeParam = "%$nome%";
    $tipoParam = "%$tipo%";
    $generoParam = !empty($genero_p) ? "%$genero_p%" : "%";
    switch ($order) {
        case'Z':
            $order_p="ORDER BY s.nome_serie ASC ";
            break;
        case'A':
            $order_p="ORDER BY media_nota DESC  ";
            break;
        case'R':
            $order_p="ORDER BY s.id_serie DESC   ";
            break;
        default:
       $order_p="ORDER BY s.nome_serie ASC ";
    } 
    $sql_P="SELECT s.*, ROUND(AVG(a.nota), 1) AS media_nota
FROM serie s
LEFT JOIN temporada t ON t.idserie = s.id_serie
LEFT JOIN episodio e ON e.idtemporada = t.id_temporada
LEFT JOIN avaliacao a ON a.idepisodio = e.id_episodio

WHERE s.nome_serie LIKE :nome_serie AND s.tipo LIKE :tipo AND s.genero LIKE :genero 
GROUP BY s.id_serie   $order_p;  ";
    $stmt=$pdo->prepare($sql_P);
    

    $stmt->bindParam(":nome_serie", $nomeParam);
    $stmt->bindParam(":tipo", $tipoParam);
    $stmt->bindParam(":genero", $generoParam);
    try{$stmt->execute();
        $serie=$stmt->fetchAll(PDO::FETCH_ASSOC);
        return $serie;
    }catch(PDOException $e){
        error_log("Erro ao inserir cliente3:".$e->getMessage());
        echo"Erro ao cadastrar cliente3.";
    }
}
function inserirEpisodio($id,$des,$titulo){
    global $pdo;
    $sql_add_e="INSERT INTO episodio (descrisao_ep, titulo,idtemporada) VALUES (:descrisao_ep, :titulo,:idtemporada );";
    $stmt=$pdo->prepare($sql_add_e);
    $stmt->bindParam(":descrisao_ep", $des);
    $stmt->bindParam(":titulo", $titulo);
    $stmt->bindParam(":idtemporada", $id);
    try{$stmt->execute();
        $sql_p_e="SELECT id_episodio FROM episodio  WHERE idtemporada=:idtemporada ORDER BY id_episodio DESC LIMIT 1";
        $stmt=$pdo->prepare($sql_p_e);
        $stmt->bindParam(":idtemporada", $id);
        
        try{
            $stmt->execute();
            $episodio=$stmt->fetch(PDO::FETCH_ASSOC);
            $usuario="1";
            $nota="0";
            $id_episodio= $episodio['id_episodio'];
            avaliar($usuario,$id_episodio,$nota);
        }catch(PDOException $e){
        error_log("Erro ao inserir cliente3:".$e->getMessage());
        echo"Erro ao cadastrar cliente3.";
        }
    }catch(PDOException $e){
        error_log("Erro ao inserir cliente3:".$e->getMessage());
        echo"Erro ao cadastrar cliente3.";
    }
}
function inserirTemporada($id,$des){
    global $pdo;
    $sql_add_t="INSERT INTO temporada (descrisao_tem, idserie) VALUES (:descrisao_tem,:idserie );";
    $stmt=$pdo->prepare($sql_add_t);
    $stmt->bindParam(":descrisao_tem", $des);
    $stmt->bindParam(":idserie", $id);
    try{$stmt->execute();
        $sql_p_t="SELECT id_temporada FROM temporada  WHERE idserie=:idserie ORDER BY id_temporada DESC LIMIT 1";
        $stmt=$pdo->prepare($sql_p_t);
        $stmt->bindParam(":idserie", $id);
        try{
            $stmt->execute();
            $temporada=$stmt->fetch(PDO::FETCH_ASSOC);
            $des_e="Episodio";
            $titulo="Episodio Fantasma";
            try{
                inserirEpisodio($temporada['id_temporada'],$des_e,$titulo);
            }catch(PDOException $e){
                error_log("Erro ao inserir cliente3:".$e->getMessage());
                echo"Erro ao cadastrar cliente3.";
            }
        }catch(PDOException $e){
            error_log("Erro ao inserir cliente3:".$e->getMessage());
            echo"Erro ao cadastrar cliente3.";
        }
    }catch(PDOException $e){
        error_log("Erro ao inserir cliente3:".$e->getMessage());
        echo"Erro ao cadastrar cliente3.";
    }
}


?>