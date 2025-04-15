<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $umidade=91;
        $vaiChover=($umidade>90);
        if ( $vaiChover)
        {
            echo "Vai chover com toda certeza absoluta da terra!";
        }
    ?>
    <?php
        $a=17;
        if($a>16)
        {
            print "maior de idade".<br/>;
        }else{
            print "menor de idade".<br/>;
        }
    ?>
</body>
</html>