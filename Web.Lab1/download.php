<?php
    if(isset($_POST["usermatrix"])) {        
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment;filename=".basename("usermatrix.txt"));
        readfile("usermatrix.txt");
    }   
?>
