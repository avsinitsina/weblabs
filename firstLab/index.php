<?php
    require 'classes/Student.php'
?>
<html>
<head>
</head>
<body>
<?php
    for($i = 0; $i < 5; $i++)
    {
        $student = new Student();
    }
    echo $student->toString();
?>
</body>
</html>
