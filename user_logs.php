<?php include_once "includes/header.php"; ?>
<?php
    // USER ID
    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
    }
?>
    <div class="container-fluid p-4 user_logs_wrapper">
        <div class="p-2 act_logs_wrapper">
            <h5 class="fw-bold p-2">ACTIVITY LOGS</h5>
            <div class="act_logs_scroll">
                <?php
                    if($YOUR_USER_ROLE== "Global Administrator"){
                        $fetch_logs = mysqli_query($conn, "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID_Action AND UL.U_ID_Action <> '$YOUR_USER_ID' ORDER BY UL.ID DESC LIMIT 10");
                    }else if($YOUR_USER_ROLE == "User Administrator"){
                        $fetch_logs = mysqli_query($conn, "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID_Action AND UL.U_ID_Action <> '$YOUR_USER_ID' AND UI.Roles <> 'Global Administrator' ORDER BY UL.ID DESC LIMIT 10");
                    }else if($YOUR_USER_ROLE == "Patient Administrator"){
                        $fetch_logs = mysqli_query($conn, "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID_Action AND UL.U_ID_Action <> '$YOUR_USER_ID' AND UI.Roles <> 'Global Administrator' AND UI.Roles <> 'User Administrator' ORDER BY UL.ID DESC LIMIT 10");
                    }else{
                        $fetch_logs = mysqli_query($conn, "SELECT * FROM user_info UI, user_logs UL WHERE UI.U_ID = UL.U_ID_Action AND UL.U_ID_Action <> '$YOUR_USER_ID' AND UI.Roles <> 'Global Administrator' AND UI.Roles <> 'User Administrator' AND UI.Roles <> 'Patient Administrator' ORDER BY UL.ID DESC LIMIT 10");
                    }

                    if(mysqli_num_rows($fetch_logs) > 0){
                        while($logs = mysqli_fetch_array($fetch_logs)){
                        echo '<div class="act_logs_item">' . $logs['Comments'] . '</div>';
                        }
                    }else{
                        echo '<div class="act_logs_item"><h4 class="fw-bold text-center w-100">NO LOGS FOUND.</h4></div>';
                    }
                    

                ?>
            </div>
        </div>
        <!-- <div class="col-md-6 col-sm-12 p-3">
            <div class="session_logs_wrapper">
                <h5 class="fw-bold p-2 text-center">SESSION LOGS</h5>
                <div class="session_logs_scroll">
                    <div class="session_logs_item px-3">
                        <span>LOG IN</span> 
                        <a href="#" role="button" class="optionButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdownOption" aria-labelledby="dropDownOption">
                            <li><a class="dropdown-item" href="#">Make action</a></li>
                            <li><a class="dropdown-item" href="#">Remove</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
<?php include_once "includes/footer.php";?>