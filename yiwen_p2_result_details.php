<?php
    require "yiwen_p2_dbconnect.php";
    //sanitize $_POST input videoid
    $videoid = mysqli_real_escape_string($db, $_POST['videoid']);
    $query = "select * from p2records where videoid=".$videoid;
    $result = mysqli_query($db,$query);
    $row = mysqli_fetch_assoc($result);

    echo "<br><b>" . $row['title'] . "</b><br><br><b>Genre:</b> " . $row['genre']
                               . "<br><b>Keywords:</b> " . $row['keywords']
                               . "<br><b>Duration:</b> " . $row['duration']
                               . "<br><b>Color:</b> " . $row['color']
                               . "<br><b>Sound:</b> " . $row['sound']
                               . "<br><b>Sponsor:</b> " . $row['sponsorname']
?>

