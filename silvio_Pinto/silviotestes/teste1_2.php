<?php
if (isset($_POST['a'])) {
    $acao=$_POST['a'];
    echo"<pre>";
    print_r($_POST);
    echo"</pre>";
    switch ($acao) {
        case'Z':
            echo "<p>A-Z</p>";
            break;
        case'A':
            echo "<p>Melhor avaliado</p>";
            break;
        case'R':
            echo "<p>Mais Recente</p>";
            break;
        default:
        echo "<p>Nada</p>";
    } 

} else{
    echo "Ndas Denovos";
}
?>