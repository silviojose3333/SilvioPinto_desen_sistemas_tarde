<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $name="Silvio pinto";
    echo "<br>".$name;
    $length=strlen($name);
    echo "<br>". $length;
    $cmp=strcmp($name,"luiz c. vaz");
    echo "<br>".$cmp;
    $index=strpos($name,"p");
    echo "<br>".$index;
    $first=substr($name,7,5);
    echo "<br>".$first;
    $name=strtoupper($name);
    echo "<br>".$name;
    ?>
    <?php
        $cidade="Joinville";
        $estado="SC";
        $idade="174";
        $frase_capital="A cidade de $cidade é a maior cidade em população";
        $frase_idade="$cidade tem mais de $idade anos";
        echo "<h3>$frase_capital</h3>";
        echo "<h4>$frase_idade</h4>";
    ?>
</body>
</html>