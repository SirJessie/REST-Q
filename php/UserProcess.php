<?php
    session_start();
    if(isset($_SESSION['RESTQ_USER-ID'])){
        require "config.php";
        require "GenerateFunctions.php";
        require "hideText.php";

        date_default_timezone_set('Asia/Manila');
        $dateNow = date("Y-m-d");
        $timeNow = date("G:i:s");

        $user_id = mysqli_real_escape_string($conn, $_SESSION['RESTQ_USER-ID']);

        $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$user_id'";

        $check_user_result = mysqli_query($conn, $check_user_query);

        $fetch_data = mysqli_fetch_array($check_user_result);

        //FETCH DATA
        $uname_action = substr($fetch_data['Fname'], 0, 1) . ". " . $fetch_data['Sname'];
        $user_role = $fetch_data['Roles'];
        $from_brgy = $fetch_data['FromBrgy'];

        $Description = "";

        

        if(isset($_SERVER["REQUEST_METHOD"]) == "POST") {

            //ADD NEW USER
            if(isset($_POST['btnAdd'])){
                if(!empty($_POST['U_ID']) && !empty($_POST['FromBrgy']) && !empty($_POST['Fname']) && !empty($_POST['Lname']) && !empty($_POST['Gender']) && !empty($_POST['Cntct']) && !empty($_POST['Role']) && !empty($_POST['Addr'])){
                    
                    //SANITIZING ALL THE DATA
                    $U_ID = mysqli_real_escape_string($conn, $_POST['U_ID']);
                    $Password = DefaultWebPassword();
                    $AvailabilityStatus = "Offline";
                    $SigninStatus = "Unblock";
                    $VerificationStatus = "Not Verify";
                    $AccountStatus = "Active";
                    $OTP_Code = substr(number_format(time() * rand(), 0, '', '', ), 0, 5);
                    $Gender = mysqli_real_escape_string($conn, $_POST['Gender']);
                    if($Gender == "Male"){
                        $DefaultImage = "default_avatar_male.png";
                    }else if($Gender == "Female"){
                        $DefaultImage = "default_avatar_female.jpg";
                    }
                    $frm_brgy = mysqli_real_escape_string($conn, $_POST['FromBrgy']);
                    $Sname = mysqli_real_escape_string($conn, $_POST['Lname']);
                    $Fname = mysqli_real_escape_string($conn, $_POST['Fname']);
                    $Mname = mysqli_real_escape_string($conn, $_POST['Mname']);
                    $ContactNum = mysqli_real_escape_string($conn, $_POST['Cntct']);
                    $EmailAdd = mysqli_real_escape_string($conn, $_POST['Email']);
                    $Addr = mysqli_real_escape_string($conn, $_POST['Addr']);
                    $Role = mysqli_real_escape_string($conn, $_POST['Role']);

                    //INSERT USER ACCOUNT
                    $insert_query = "INSERT INTO user_info (AvailabilityStatus,SigninStatus,VerificationStatus,OTPCode,U_ID,Roles,FromBrgy,Image,Passwd,AccountStatus,Sname,Fname,Mname,Gender,ContactNumber,EmailAddress,Addr,JoinDate) VALUES ('$AvailabilityStatus','$SigninStatus','$VerificationStatus','$OTP_Code','$U_ID','$Role','$frm_brgy','$DefaultImage','$Password','$AccountStatus','$Sname','$Fname','$Mname','$Gender','$ContactNum','$EmailAdd','$Addr','$dateNow')";
                    if(mysqli_query($conn,$insert_query)){

                        $Description = $uname_action . "(" . $user_id . ")" . " added a new user. New User ID = " . $U_ID;

                        // INSERT LOGS
                        $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'AddNewUser','$Description', '$dateNow', '$timeNow')";
                        mysqli_query($conn, $insert_logs_query);

                        header("Location:../redirect.php?page=active_user&success_adding");
                        exit;
                    }else{
                        header("Location:../redirect.php?page=active_user&error_adding");
                        exit;
                    }
                }
            }
            // EDIT USER
            if(isset($_POST['btnSave'])){
                if(!empty($_POST['U_ID']) && !empty($_POST['Fname']) && !empty($_POST['Lname']) && !empty($_POST['Addr']) ){
                    //SANITIZING ALL THE DATA
                    $img_name = $_FILES['imgFile']['name'];
                    $img_size = $_FILES['imgFile']['size'];
                    $tmp_name =$_FILES['imgFile']['tmp_name'];
                    $error = $_FILES['imgFile']['error'];

                    $U_ID = mysqli_real_escape_string($conn ,$_POST['U_ID']);
                    $Fname = mysqli_real_escape_string($conn ,$_POST['Fname']);
                    $Mname = mysqli_real_escape_string($conn ,$_POST['Mname']);
                    $Sname = mysqli_real_escape_string($conn ,$_POST['Lname']);
                    $Gender = mysqli_real_escape_string($conn ,$_POST['Gender']);
                    $ContactNum = mysqli_real_escape_string($conn ,$_POST['Cntct']);
                    $EmailAdd = mysqli_real_escape_string($conn ,$_POST['Email']);
                    $Role = mysqli_real_escape_string($conn ,$_POST['Role']);
                    $Addr = mysqli_real_escape_string($conn ,$_POST['Addr']);
                    $Description = $uname_action . " made changes in data of " . $U_ID;

                    if(!empty($img_name)){
                        if($error === 0){
                            //GET THE EXTENSION OF FILENAME
                            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                            $img_ex_lc = strtolower($img_ex);

                            // ALLOW SOME EXTENSION ONLY
                            $allowed_exs = array("jpg","jpeg","png");

                            if(in_array($img_ex_lc, $allowed_exs)){
                                
                                $new_img_name = uniqid("IMG-",true) . '.' . $img_ex_lc;
                                $img_upload_path = "../resources/images/UserAvatars/" . $new_img_name;
                                move_uploaded_file($tmp_name, $img_upload_path);

                                $update_query = "UPDATE user_info SET Image = '$new_img_name', Fname = '$Fname', Mname = '$Mname', Sname = '$Sname', Gender = '$Gender', ContactNumber = '$ContactNum', EmailAddress = '$EmailAdd', Roles = '$Role', Addr = '$Addr' WHERE U_ID = '$U_ID'";
                                if(mysqli_query($conn,$update_query)){

                                    // INSERT LOGS
                                    $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'EditUser','$Description', '$dateNow', '$timeNow')";
                                    mysqli_query($conn, $insert_logs_query);
                    
                                    header("Location:../redirect.php?page=active_user&success_updating");
                                    exit;
                                }else{
                                    header("Location:../redirect.php?page=active_user&query_error");
                                    exit;
                                }

                            }else{
                                header("Location:../redirect.php?page=active_user&error_file_exts");
                                exit;
                            }
                        }else{
                            header("Location:../redirect.php?page=active_user&unknown_error");
                            exit;
                        }
                        
                    }else{

                        $update_query = "UPDATE user_info SET Fname = '$Fname', Mname = '$Mname', Sname = '$Sname', Gender = '$Gender', ContactNumber = '$ContactNum', EmailAddress = '$EmailAdd', Roles = '$Role', Addr = '$Addr' WHERE U_ID = '$U_ID'";
                        if(mysqli_query($conn,$update_query)){

                            // INSERT LOGS
                            $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Description, DateOfAction, TimeOfAction) VALUES ('$U_ID', '$user_id', '$uname_action', 'EditUser','$Description', '$dateNow', '$timeNow')";
                            mysqli_query($conn, $insert_logs_query);

                            header("Location:../redirect.php?page=active_user&success_updating");
                            exit;
                        }else{
                            header("Location:../redirect.php?page=active_user&query_error");
                            exit;
                        }
                    }  
                }
            }
            // RESET PASSWORD
            if(isset($_POST['btnResetPass'])){
                $IDsToReset = $_POST['IDsToReset'];
                $Password = DefaultWebPassword();

                foreach($IDsToReset as $UserID){
                    $resetpass_query = "UPDATE user_info SET Passwd = '$Password' WHERE U_ID = '$UserID'";
                    mysqli_query($conn,$resetpass_query);
                    
                    $Description = $uname_action . "(" . $user_id . ")" . " reset password of " . $UserID;

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'EditUser','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);
                }

                header("Location:../redirect.php?page=active_user&password_reset");
                exit;
            }
            // DELETE USERS
            if(isset($_POST['btnDeleteUser'])){
                $IDsToDelete = $_POST['IDsToDelete'];

                foreach($IDsToDelete as $UserID){
                    //DELETE QUERY
                    $delete_query = "UPDATE user_info SET AccountStatus = 'Deleted', DeletedDate = '$dateNow' WHERE U_ID = '$UserID'";
                    mysqli_query($conn,$delete_query);

                    $Description = "Account of " . $UserID . " was move to deleted by " . $uname_action . "(" . $user_id . ")";

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$UserID', '$user_id', '$uname_action', 'DeleteUser', '$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);
                }

                header("Location:../redirect.php?page=active_user&success_deleting");
                exit;
            }
            // RESTORE USER
            if(isset($_POST['btnRestoreUser'])){
                $UserID = mysqli_real_escape_string($conn, $_POST['U_ID']);
                $Description = "";

                // RESTORE QUERY
                $restore_query = "UPDATE user_info SET AccountStatus = 'Active', DeletedDate = '' WHERE U_ID = '$UserID'";
                if(mysqli_query($conn,$restore_query)){

                    $Description = "Account of " . $UserID . " was restored by " .  $uname_action . "(" . $user_id . ")";

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$UserID', '$user_id', '$uname_action', 'RestoreUser','$Description', '$dateNow','$timeNow')";
                    mysqli_query($conn, $insert_logs_query);

                    header("Location:../redirect.php?page=deleted_user&success_restoring");
                    exit;
    

                }else{
                    header("Location:../redirect.php?page=deleted_user&query_error");
                    exit;
                }
            }
            

            //MODAL BUTTONS
            if(isset($_POST['ModalButton'])){
                //SAVE NUMBER
                if($_POST['ModalButton'] == "BtnSaveNumber"){
                    $UserID = mysqli_real_escape_string($conn, $_POST['UserID']);
                    $CurrentNumber = mysqli_real_escape_string($conn, $_POST['CurrentNumber']);
                    $NewNumber = mysqli_real_escape_string($conn, $_POST['NewNumber']); 

                    $changeNumber = $conn->query("UPDATE user_info SET ContactNumber = '$NewNumber' WHERE U_ID = '$UserID'");

                    if($changeNumber){
                        echo hideContact($NewNumber);
                    }else{
                        echo hideContact($CurrentNumber);
                    }
                }
                //SAVE EMAIL ADDRESS
                if($_POST['ModalButton'] == "BtnSaveEmail"){
                    $UserID = mysqli_real_escape_string($conn, $_POST['UserID']);
                    $CurrentEmail = mysqli_real_escape_string($conn, $_POST['CurrentEmail']);
                    $NewEmail = mysqli_real_escape_string($conn, $_POST['NewEmail']); 

                    $changeEmail = $conn->query("UPDATE user_info SET EmailAddress = '$NewEmail' WHERE U_ID = '$UserID'");

                    if($changeEmail){
                        echo hideEmail($NewEmail);
                    }else{
                        echo hideEmail($CurrentEmail);
                    }
                }
                //SAVE PASSWORD
                if($_POST['ModalButton'] == "BtnSavePassword"){
                    $UserID = mysqli_real_escape_string($conn, $_POST['UserID']);
                    $CurrentPass = mysqli_real_escape_string($conn, $_POST['CurrentPass']);
                    $NewPass = mysqli_real_escape_string($conn, $_POST['NewPass']);
                    $HashPass = password_hash($NewPass, PASSWORD_DEFAULT);

                    $changePass = $conn->query("UPDATE user_info SET Passwd = '$HashPass' WHERE U_ID = '$UserID'");

                    if($changePass){
                        $_SESSION['RESTQ_USER-PASSWORD'] = $NewPass;
                        echo hidePassword($NewPass);
                    }else{
                        echo hidePassword($CurrentPass);
                    }
                }
            }
        }

        if(isset($_SERVER["REQUEST_METHOD"]) == "GET"){
            
            // BLOCKED USER
            if(isset($_GET['block_id'])){
                $UserID = mysqli_real_escape_string($conn, $_GET['block_id']);

                $block_query = "UPDATE user_info SET SigninStatus = 'Block' WHERE U_ID = '$UserID'";
                if(mysqli_query($conn,$block_query)){

                    $Description = $uname_action . " was block sign-in of " . $UserID;

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$UserID', '$user_id', '$uname_action', 'ResetPassword','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);

                    header("Location:../redirect.php?page=active_user&success_blocking");
                    exit;
                }

            }

            //UNBLOCK USER
            if(isset($_GET['unblock_id'])){
                $UserID = mysqli_real_escape_string($conn, $_GET['unblock_id']);
                
                $unblock_query = "UPDATE user_info SET SigninStatus = 'Unblock' WHERE U_ID = '$UserID'";
                if(mysqli_query($conn,$unblock_query)){

                    $Description = $uname_action . " was unblock sign-in of " . $UserID;

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$UserID', '$user_id', '$uname_action', 'ResetPassword','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);

                    header("Location:../redirect.php?page=active_user&success_unblocking");
                    exit;
                }
            }

            //RESET PASSWORD
            if(isset($_GET['resetpass_id'])){
                
                $UserID = mysqli_real_escape_string($conn, $_GET['resetpass_id']);

                $Password = DefaultWebPassword();

                $resetpass_query = "UPDATE user_info SET Passwd = '$Password' WHERE U_ID = '$UserID'";
                if(mysqli_query($conn,$resetpass_query)){

                    $Description = $uname_action . "(" . $user_id . ")" . " reset password of " . $UserID;

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$UserID', '$user_id', '$uname_action', 'ResetPassword','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);

                    header("Location:../redirect.php?page=active_user&password_reset");
                    exit;
                }else{
                    header("Location:../redirect.php?page=active_user&query_error");
                    exit;
                }
            }

            //DELETE USER
            if(isset($_GET['delete_id'])){
                $UserID = mysqli_real_escape_string($conn, $_GET['delete_id']);

                $delete_query = "UPDATE user_info SET AccountStatus = 'Deleted', DeletedDate = '$dateNow' WHERE U_ID = '$UserID'";
                if(mysqli_query($conn,$delete_query)){

                    $Description = "Account of " . $UserID . " was move to deleted by " . $uname_action . "(" . $user_id . ")";

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID, U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$UserID', '$user_id', '$uname_action', 'DeleteUser','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);

                    header("Location:../redirect.php?page=active_user&success_deleting");
                    exit;

                }else{
                    header("Location:../redirect.php?page=active_user&query_error");
                    exit;
                }
            }
        }

    }


?>