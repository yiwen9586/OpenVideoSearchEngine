<?php

    if (isset($_POST['fuser']) && isset($_POST['fpass'])) {
        require "yiwen_p2_dbconnect.php";
    // user has provided a username and password, so try to log them in
        //sanitize $_POST input user name
        $fuser = mysqli_real_escape_string($db, $_POST['fuser']);
        $sha1_pass = sha1($_POST['fpass']);
        $query = "select * from p2users where uname = '$fuser' " . "and upass = '$sha1_pass'";

        if ($result = mysqli_query($db,$query)) {
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                session_start();
                $row = mysqli_fetch_row($result);
                $_SESSION['valid_user'] = $fuser;
                Header("HTTP/1.1 303 See Other");
                Header("Location: yiwen_p2_result.php");
                exit;
            }
            else
                echo "You are not registered!<br><a href=\"yiwen_p2_result.php\">Back</a>";
        }

    mysql_close($db);
}
?>
