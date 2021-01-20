<?php
    require("classes\Matrix.php");
    // file_put_contents('kek.txt',  json_encode($matrix));
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 1</title>
</head>
<body>
    <?php
        if(isset($_POST["size"]) && !empty($_POST["size"]) && is_int($_POST["size"]) && $_POST["size"]>1){
            $matrix = new Matrix($_POST["size"], null);
        }
        else $matrix = new Matrix(null, null);
        echo "Исходная матрица размера ".$matrix->colsCount."x".$matrix->colsCount."<br>";
        $matrix->print();
        
        // $_SESSION["matrixtosave"] = $matrix->data; 
        // file_put_contents("usermatrix.txt",  json_encode($_SESSION["matrixtosave"]));
        file_put_contents("usermatrix.txt",  json_encode($matrix->data));
        echo "Определитель = ".$matrix->getDeterminant();
        echo "<br> Обратная матрица <br>";    
        $matrix->getReversed()->print();
        echo "<br> Исходная, отзеркалена горизонтально <br>";
        @$matrix->getMirrorH()->print();
        echo "<br> Исходная, отзеркалена вертикально <br>";
        $matrix->getMirrorV()->print();    
    ?>
    
    <form action="download.php" method="post">
        <div><input name="usermatrix" type="submit" value="Сохранить матрицу" /></div>
    </form>
    
</body>
</html>



