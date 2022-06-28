<?php
    require("config.php");

    if(isset($_SERVER['REQUEST_METHOD']) == "POST"){

        if($_POST['Data'] == "CountUserLogs"){
                        
            $count_notifs = "SELECT * FROM user_logs WHERE DateOfAction = '$dateNow'";
            $count_result = mysqli_query($conn, $count_notifs);

            if(mysqli_num_rows($count_result) > 0){
                echo mysqli_num_rows($count_result);
            }else{
                echo 0;
            }
        }
    }
?>