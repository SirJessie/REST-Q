<?php
    session_start();
    require "config.php";
    require "TimeAgo.php";
    require "SMSFunction.php";
    require "hideText.php";

    date_default_timezone_set('Asia/Manila');
    // USER ID
    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
    }

    if(isset($_SERVER['REQUEST_METHOD']) == "POST"){
        if(isset($_POST['Data'])){
            

            if($_POST['Data'] == "PopulateNotifs"){
                $Brgy = $_POST['Brgy'];
                if($YOUR_USER_ROLE== "Global Administrator"){
                    $showNotifs = "SELECT * FROM alertlogs ORDER BY Alert_ID DESC";

                    $showResult = mysqli_query($conn, $showNotifs);

                    if(mysqli_num_rows($showResult) > 0){
                        while($notification_content = mysqli_fetch_array($showResult)){

                            $id = $notification_content['Alert_ID'];
                            $token_id = sha1($id);
                            $timeAgo = date('Y-m-d', strtotime($notification_content['DateNotify'])) . ' ' . date('H:i:s', strtotime($notification_content['TimeNotify']));
                            
                            
                            if($notification_content['isSeen'] == "seen"){
                                echo '<li>
                                        <a href="php/Notifications.php?view_notification&token_id='. $token_id .'" class="notification-content seen">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="notification-item my-auto">
                                                <span class="notify-message">'. $notification_content['alertType'] .'</span>
                                                <span class="notify-dt">' . time_elapsed_string($timeAgo)  . '</span>
                                            </div>
                                        </a>
                                    </li>';
                            }else{
                                echo '<li>
                                        <a href="php/Notifications.php?check_notification&token_id='. $token_id .'" class="notification-content unseen">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="notification-item my-auto">
                                                <span class="notify-message">'. $notification_content['alertType'] .'</span>
                                                <span class="notify-dt">'.  time_elapsed_string($timeAgo) . '</span>
                                            </div>
                                        </a>
                                    </li>';
                            } 
                        }
                    }else{
                        echo '<div class="notification-content no-notifs">
                                    <span class="m-auto p-5">No notification...</span>
                                </div>';
                    }
                }else if($YOUR_USER_ROLE == "User Administrator" || $YOUR_USER_ROLE == "Patient Administrator"){
                    $showNotifs = "SELECT * FROM alertlogs AL, patient_info P WHERE AL.P_ID = P.P_ID AND P.Barangay = '$Brgy' ORDER BY AL.Alert_ID DESC";

                    $showResult = mysqli_query($conn, $showNotifs);

                    if(mysqli_num_rows($showResult) > 0){
                        while($notification_content = mysqli_fetch_array($showResult)){

                            $id = $notification_content['Alert_ID'];
                            $token_id = sha1($id);
                            $timeAgo = date('Y-m-d', strtotime($notification_content['DateNotify'])) . ' ' . date('H:i:s', strtotime($notification_content['TimeNotify']));
                            
                            
                            if($notification_content['isSeen'] == "seen"){
                                echo '<li>
                                        <a href="php/Notifications.php?view_notification&token_id='. $token_id .'" class="notification-content seen">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="notification-item my-auto">
                                                <span class="notify-message">'. $notification_content['alertType'] .'</span>
                                                <span class="notify-dt">' . time_elapsed_string($timeAgo)  . '</span>
                                            </div>
                                        </a>
                                    </li>';
                            }else{
                                echo '<li>
                                        <a href="php/Notifications.php?check_notification&token_id='. $token_id .'" class="notification-content unseen">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="notification-item my-auto">
                                                <span class="notify-message">'. $notification_content['alertType'] .'</span>
                                                <span class="notify-dt">'.  time_elapsed_string($timeAgo) . '</span>
                                            </div>
                                        </a>
                                    </li>';
                            } 
                        }
                    }else{
                        echo '<div class="notification-content no-notifs">
                                    <span class="m-auto p-5">No notification...</span>
                                </div>';
                    }
                }else{
                    $showNotifs = "SELECT * FROM alertpersonnel AP, user_info UI WHERE UI.FromBrgy = '$Brgy' AND AP.U_ID = '$YOUR_USER_ID' ORDER BY AP.ID DESC";

                    $showResult = mysqli_query($conn, $showNotifs);

                    if(mysqli_num_rows($showResult) > 0){
                        while($notification_content = mysqli_fetch_array($showResult)){

                            $id = $notification_content['Alert_ID'];
                            $token_id = sha1($id);
                            $timeAgo = date('Y-m-d', strtotime($notification_content['DateNotify'])) . ' ' . date('H:i:s', strtotime($notification_content['TimeNotify']));
                            
                            
                            if($notification_content['isSeen'] == "seen"){
                                echo '<li>
                                        <a href="php/Notifications.php?view_notification&token_id='. $token_id .'" class="notification-content seen">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="notification-item my-auto">
                                                <span class="notify-message">'. $notification_content['NotifyMessage'] .'</span>
                                                <span class="notify-dt">' . time_elapsed_string($timeAgo)  . '</span>
                                            </div>
                                        </a>
                                    </li>';
                            }else{
                                echo '<li>
                                        <a href="php/Notifications.php?check_notification&token_id='. $token_id .'" class="notification-content unseen">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <div class="notification-item my-auto">
                                                <span class="notify-message">'. $notification_content['NotifyMessage'] .'</span>
                                                <span class="notify-dt">'. time_elapsed_string($timeAgo) . '</span>
                                            </div>
                                        </a>
                                    </li>';
                            } 
                        }
                    }else{
                        echo '<div class="notification-content no-notifs">
                                    <span class="m-auto p-5">No notification...</span>
                                </div>';
                    }
                }
            }

            if($_POST['Data'] == "CountNotifs"){
                if($YOUR_USER_ROLE== "Global Administrator"){
                
                    $count_notifs = "SELECT * FROM alertlogs WHERE isSeen = 'unseen'";
                    $count_result = mysqli_query($conn, $count_notifs);

                    if(mysqli_num_rows($count_result) > 0){  
                        echo mysqli_num_rows($count_result);
                    }else{
                        echo 0;
                    }
                }else if($YOUR_USER_ROLE == "User Administrator" || $YOUR_USER_ROLE == "Patient Administrator"){
                    $count_notifs = "SELECT * FROM alertlogs AL, patient_info P WHERE AL.P_ID = P.P_ID AND P.Barangay = '$Brgy'AND AL.isSeen = 'unseen'";
                    $count_result = mysqli_query($conn, $count_notifs);

                    if(mysqli_num_rows($count_result) > 0){  
                        echo mysqli_num_rows($count_result);
                    }else{
                        echo 0;
                    }
                }else{
                    $count_notifs = "SELECT * FROM alertpersonnel WHERE isSeen = 'unseen'";

                    $count_result = mysqli_query($conn, $count_notifs);

                    if(mysqli_num_rows($count_result) > 0){  
                        echo mysqli_num_rows($count_result);
                    }else{
                        echo 0;
                    }
                }
            }

            if($_POST['Data'] == "SendSMS"){
                $P_ID = $_POST['P_ID'];
                $MessageBody = $_POST['MessageBody'];

                $sel_patient = mysqli_query($conn, "SELECT * FROM patient_info WHERE P_ID = '$P_ID'");

                while($data = mysqli_fetch_array($sel_patient)){
                    $patientCPN = $data['ContactPersonNumber'];
                }

                $newPatientCPN = changeContactFormat($patientCPN);

                SendSMS($newPatientCPN, $MessageBody);
                
            }

            if($_POST['Data'] == "SearchPersonnel"){
                $Brgy = $_POST['Brgy'];
                $SearchValue = $_POST['SearchValue'];

                $searchPersonnel = mysqli_query($conn, "SELECT * FROM user_info WHERE CONCAT(U_ID, Fname, Mname, Sname, Gender) LIKE '%$SearchValue%' AND AvailabilityStatus = 'Online' AND Roles = 'Monitoring Personnel' AND FromBrgy = '$Brgy'");

                if(mysqli_num_rows($searchPersonnel) > 0){
                    while($data = mysqli_fetch_array($searchPersonnel)){
                        $U_ID = $data['U_ID'];
                        $Name = $data['Fname'] . " " . substr($data['Mname'],0,1) . ". " . $data['Sname'];
                        echo <<<EOT
                            <div class="d-flex p-2 border">
                                <input type="checkbox" class="m-1" name="personnelSelect[]" value="$U_ID">
                                <span>[$U_ID] - $Name</span>
                            </div>
                        EOT;
                    }
                }else{
                    echo <<<EOT
                            <div class="d-flex justify-content-center p-5 border border-primary">
                                <span>No available personnel</span>
                            </div>
                        EOT;
                }
            }

            if($_POST['Data'] == "ShowPersonnel"){
                $Brgy = $_POST['Brgy'];

                $searchPersonnel = mysqli_query($conn, "SELECT * FROM user_info WHERE AvailabilityStatus = 'Online' AND Roles = 'Monitoring Personnel' AND FromBrgy = '$Brgy'");

                if(mysqli_num_rows($searchPersonnel) > 0){
                    while($data = mysqli_fetch_array($searchPersonnel)){
                        $U_ID = $data['U_ID'];
                        $Name = $data['Fname'] . " " . substr($data['Mname'],0,1) . ". " . $data['Sname'];
                        echo <<<EOT
                            <div class="d-flex p-2 border">
                                <input type="checkbox" class="m-1" name="personnelSelect[]" value="$U_ID">
                                <span>[$U_ID] - $Name</span>
                            </div>
                        EOT;
                    }
                }else{
                    echo <<<EOT
                            <div class="d-flex justify-content-center p-5 border border-primary">
                                <span>No available personnel</span>
                            </div>
                        EOT;
                }
            }
        }

    }

    if(isset($_SERVER['REQUEST_METHOD']) == "GET" ){
        
        if(isset($_GET['check_notification'])){
            if(isset($_GET['token_id'])){
                $token_id = $_GET['token_id'];

                $seen_query = "SELECT * FROM alertlogs";
                $seen_res = mysqli_query($conn, $seen_query);
                
                while($row = mysqli_fetch_array($seen_res)){
                    
                    $correct_id = $row['Alert_ID'];
                    $encrypt_id = sha1($correct_id);

                    if($token_id == $encrypt_id){
                        
                        $seen_update = "UPDATE alertlogs SET isSeen = 'seen' WHERE Alert_ID = '$correct_id'";

                        if(mysqli_query($conn, $seen_update)){

                            header("Location:../redirect.php?page=notification_view&token_id=$encrypt_id");
                            exit;

                        }
                        
                    }else{
                        $encrypt_id = "";
                    }
                }
                
            }
        }

        if(isset($_GET['view_notification'])){
            if(isset($_GET['token_id'])){
                $encrypt_id = $_GET['token_id'];
                header("Location:../redirect.php?page=notification_view&token_id=$encrypt_id");
                exit;
            }
        }
    }

?>