<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 2</title>
</head>
<body>
    <form enctype="multipart/form-data" action="matrix2.php" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        Отправить этот файл: <input name="usermatrix" type="file" />
        <div><input type="submit" value="Загрузить матрицу" /></div>
    </form>
</body>
</html>

<?php
    require("classes/Matrix.php");
?>

<?php
    if(isset($_FILES['usermatrix']))
    {
        move_uploaded_file($_FILES['usermatrix']['tmp_name'], 'data\usermatrix.txt');
        $json = file_get_contents('data\usermatrix.txt');
        $matrix = new Matrix(null, json_decode($json));
        echo "Исходная матрица размера ".$matrix->colsCount."x".$matrix->colsCount."<br>";
        $matrix->print();
        echo "<br> Попарное чередование строк <br>";
        @$matrix->pairRows()->print();
        echo "<br> Попарное чередование столбцов <br>";
        $matrix->pairCols()->print();
    }    
?>