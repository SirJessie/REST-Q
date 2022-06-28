<?php
    session_start();
    require("config.php");

    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){

        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];

    }
    if(isset($_POST['ShowLimit'])){
        $Limit = $_POST['ShowLimit'];
        
        $pop_log_act = mysqli_query($conn, "SELECT * FROM session_logs WHERE U_ID = '$YOUR_USER_ID' ORDER BY ID DESC LIMIT $Limit");

        while($data = mysqli_fetch_array($pop_log_act)){
            $Icon = ($data['Session_Unit'] == "DESKTOP/LAPTOP") ? '<i class="fa-solid fa-desktop icon"></i>' : '<i class="fa-solid fa-mobile-screen-button icon"></i>';
            $date_time = date("F j, Y", strtotime($data['Session_Date'])) . " at " . date("h:i:s A", strtotime($data['Session_Time']));
            echo <<<EOT
                <div class="recent_login_item">
                    <div class="d-flex">
                        $Icon
                        <span class="text">Your account was login on this unit</span>
                    </div>
                    <div class="date-time">
                        <span>$date_time</span>
                    </div>
                </div>
            EOT;
        }
    }

?>