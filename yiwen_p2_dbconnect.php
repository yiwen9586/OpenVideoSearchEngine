<?php
    $h = 'sql9.freemysqlhosting.net';
    $u = 'sql9253239';
    $p = 'pWuX9wyqPi';
    $dbname = 'sql9253239';
    $db = mysqli_connect($h,$u,$p,$dbname);
    if (mysqli_connect_errno()) {
        echo "Connect failed" . mysqli_connect_error();
        exit();
    }
?>
