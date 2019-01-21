<?php
    require "yiwen_p2_dbconnect.php";
    //sanitize $_POST input search word
    $usrinput = mysqli_real_escape_string($db, $_POST['usrinput']);
    $query = "select * from p2phrases where phrase like '".$usrinput."%' limit 10";
    if($result = mysqli_query($db,$query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<br>" . $row['phrase'];
        }
    }
?>