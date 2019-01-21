<html>
<head>
    <h1>INLS 760 P2 Records</h1>
    <h2>by yiwen April 2018</h2>
    <link rel="stylesheet" type="text/css" href="yiwen_p2_styles.css">
</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js">
</script>
<script type="text/javascript">
    // function for get user input and reload page
    function search()
    {
        var s = document.getElementById("usrInput").value;
        window.location = "yiwen_p2_result.php?search="+s;
    }
    // function for suggestion
    $(document).ready(function(){

        $("#usrInput").keyup(function(){
            var s = document.getElementById("usrInput").value;
            $.post("yiwen_p2_keyword_suggestions.php",
                { usrinput:s },
                function(data,status){
                    $("#C").html(data);
                }
            );
        });
    // function for result detail
        $(".res_row").mouseover(function(){
            var videoid = $(this).attr('videoid');
            $.post("yiwen_p2_result_details.php",
                { videoid:videoid },
                function(data,status){
                    $("#D").html(data);
                }
            );
        });
        $(".res_row").mouseleave(function(){
            $("#D").html("");
        });

    });
</script>

<?php
    //user login part
    session_start();
    if (!isset($_SESSION['valid_user'])){ //if user has not logged in, show a form to let them log in
        echo "<p style=text-align:center><br>You must login to see this page<br></p>
        <form align=\"center\" method=\"post\" action=\"yiwen_p2_login.php\">
                Username:&nbsp;<input type=\"text\" name=\"fuser\"><p>
                Password:&nbsp;<input type=\"password\" name=\"fpass\"><p>
                <input type=\"submit\" value=\"Login\">
        </form>";
    }
    else { //if the user has already logged in, show the result page and provide a log out link
        echo "<p style=text-align:center>Welcome  ".$_SESSION['valid_user'].
             "!!!<a href='yiwen_p2_logout.php'>(logout)</a></p>";
?>

        <body>
        <div class="grid-container">
            <div id="BC"><br>
                <form name="B">
                    <input type="text" id="usrInput" value="<?php echo $_GET['search']; ?>">
                    <input type="button" value="search" onclick="search();">
                </form>
                <span><br>Suggestions</span>
                <div id="C"></div>
            </div>
            <div id="A">
                <table class="gridtable">
                    <tbody>
                    <?php
                    require "yiwen_p2_dbconnect.php";
                    //sanitize user input search word
                    $usrInput = mysqli_real_escape_string($db, $_GET['search']);
                    $query = "select * from p2records where match (title,description,keywords) against ('$usrInput')";
                    $result = mysqli_query($db, $query);
                    $row = mysqli_fetch_assoc($result);
                    if (!empty($row) && $usrInput != "") { ?>
                        <br>Showing results for:  <?php echo $usrInput. "<br><br>";
                    } ?>
                    <?php
                    if ($result = mysqli_query($db, $query)) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['videoid'];
                            $imgurl = "http://www.open-video.org/surrogates/keyframes/" . $id . "/" . $row['keyframeurl'];
                            $url = "http://www.open-video.org/details.php?videoid=" . $id;
                            echo "
                        <tr class=\"res_row\" videoid=\"$id\">
                            <td><a href=$url><img src=$imgurl></a></td>
                            <td><b><a href=$url>" . $row['title'] . " (" . $row['creationyear'] . ")</a><br>" . "</b>" . mb_substr($row['description'], 0, 200) . "</td>
                        </tr>";
                        }
                    }//end show the result
                    mysqli_close($db);
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="D"><br></div>
        </div>

        </body>

<?php
    }?>

</html>



