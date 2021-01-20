<?php
$a = 'foo' & 5;
echo $a;
$a = 'foo' | 5;
echo $a;
$a = 5 < 4 && 1;
echo $a;
$a = '' . 2 & 1;
echo $a;
$a = 4/5 > 5 || 1&4 . '0';
echo $a;
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Задание 1</title>
</head>
<body>
    <form action="matrix.php" method="post">
        <div>
            <label for="size">Размер матрицы: </label>
            <input type="number" name="size" min="2">
            <input type="submit" value="Отправить">
        </div>
    </form>
</body>
</html>
