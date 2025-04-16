<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Tabuada</h3>
    <table border="1">
    <?php
    for($l=1;$l<=10;$l++){
        echo "<tr>";
        for($c=1;$c<=10;$c++){
            echo "<td>$l X $c = ".$l*$c."</td>";
        }
        echo "</tr>  ";
    }

    ?>
    </table>
    <h3>Silvio José da Silva Pinto</h3>
</body>
</html>