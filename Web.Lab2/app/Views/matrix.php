<?php
echo esc($title);
if(isset($det)) echo "<br>".esc($det);
echo '<div class="col-md-3"><table class="table table-bordered"> <tbody>';
foreach (esc($matrix) as $row) {  
    echo '<tr>';  
    foreach ($row as $value) {
        echo "<td>".$value."</td>"; 
    }
    echo '</tr>';
}        
echo '</tbody></table></div>';