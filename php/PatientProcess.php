<?php
    session_start();
    if(isset($_SESSION['RESTQ_USER-ID'])){
        include_once "config.php";
        include_once "GenerateFunctions.php";

        date_default_timezone_set('Asia/Manila');
        $dateNow = date("Y-m-d");
        $timeNow = date("G:i:s");

        $user_id = mysqli_real_escape_string($conn, $_SESSION['RESTQ_USER-ID']);

        $check_user_query = "SELECT * FROM user_info WHERE U_ID = '$user_id'";

        $check_user_result = mysqli_query($conn, $check_user_query);

        $fetch_data = mysqli_fetch_array($check_user_result);

        //FETCH DATA
        $uname_action = substr($fetch_data['Fname'], 0, 1) . " " . $fetch_data['Sname'];
        $user_role = $fetch_data['Roles'];
        $from_brgy = $fetch_data['FromBrgy'];

        if(isset($_SERVER['REQUEST_METHOD']) == "POST"){

            //ADD NEW PATIENT
            if(isset($_POST['btnAdd'])){
                if(!empty($_POST['P_ID']) && !empty($_POST['FromBrgy']) && !empty($_POST['Fname']) && !empty($_POST['Lname']) && !empty($_POST['Gender']) && !empty($_POST['Bdate']) && !empty($_POST['Occpt']) && !empty($_POST['Nation']) && !empty($_POST['Cntct']) && !empty($_POST['Email']) && !empty($_POST['Addr']) && !empty($_POST['virusCase']) && !empty($_POST['LastTrav']) && !empty($_POST['Btype']) && !empty($_POST['ComorB']) && !empty($_POST['PersonNotiName']) && !empty($_POST['PersonNotiRelation']) && !empty($_POST['PersonNotiCntct']) && !empty($_POST['PersonNotiAddr'])){
                    
                    // SANITIZING THE DATA
                        //PERSONAL INFO
                        $P_ID = mysqli_real_escape_string($conn, $_POST['P_ID']);
                        $Password = DefaultAppPassword();
                        $Brgy = mysqli_real_escape_string($conn, $_POST['FromBrgy']);
                        $Fname = mysqli_real_escape_string($conn, $_POST['Fname']);
                        $Mname = mysqli_real_escape_string($conn, $_POST['Mname']);
                        $Lname = mysqli_real_escape_string($conn, $_POST['Lname']);
                        $Gender = mysqli_real_escape_string($conn, $_POST['Gender']);
                        if($Gender == "Male"){
                            $DefaultImage = "default_avatar_male.png";
                        }else if($Gender == "Female"){
                            $DefaultImage = "default_avatar_female.jpg";
                        }
                        $Bdate = mysqli_real_escape_string($conn, $_POST['Bdate']);
                        $Occpt = mysqli_real_escape_string($conn, $_POST['Occpt']);
                        $Nation = mysqli_real_escape_string($conn, $_POST['Nation']);
                        $ContactNum = mysqli_real_escape_string($conn, $_POST['Cntct']);
                        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
                        $Addr = mysqli_real_escape_string($conn, $_POST['Addr']);

                        //MEDICAL INFO
                        $Case = mysqli_real_escape_string($conn, $_POST['virusCase']);
                        $LastTrav = mysqli_real_escape_string($conn, $_POST['LastTrav']);
                        $Btype = mysqli_real_escape_string($conn, $_POST['Btype']);
                        $Comorbidities = mysqli_real_escape_string($conn, $_POST['ComorB']);

                        //CONTACT PERSON INCASE OF EMERGENCY
                        $PersonNotiName = mysqli_real_escape_string($conn, $_POST['PersonNotiName']);
                        $PersonNotiRelation = mysqli_real_escape_string($conn, $_POST['PersonNotiRelation']);
                        $PersonNotiCntct = mysqli_real_escape_string($conn, $_POST['PersonNotiCntct']);
                        $PersonNotiAddress = mysqli_real_escape_string($conn, $_POST['PersonNotiAddr']);

                    //INSERT NEW PATIENT
                    $insert_query = "INSERT INTO patient_info (P_ID, Passwd, Image, Sname, Fname, Mname, Barangay, RegistrationDate, InfectiousDisease, BirthDate, Gender, Nationality, Address, ContactNumber, EmailAddress, Occupation, Comorbidities, BloodType, LastTravelHistory, ContactPersonName, Relationship, ContactPersonNumber, ContactPersonAddress) VALUES ('$P_ID', '$Password', '$DefaultImage', '$Lname', '$Fname', '$Mname', '$Brgy', '$dateNow', '$Case', '$Bdate', '$Gender', '$Nation', '$Addr', '$ContactNum', '$Email', '$Occpt', '$Comorbidities', '$Btype', '$LastTrav', '$PersonNotiName', '$PersonNotiRelation', '$PersonNotiCntct', '$PersonNotiAddress')";

                    if(mysqli_query($conn,$insert_query)){

                        $Description = $uname_action . "(" . $user_id . ")" . " added a new patient. New Patient ID = " . $P_ID;

                        // INSERT LOGS
                        $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'AddNewPatient','$Description', '$dateNow', '$timeNow')";
                        mysqli_query($conn, $insert_logs_query);

                        header("Location:../redirect.php?page=home_quarantine_patients&success_adding");
                        exit;
                    }else{
                        header("Location:../redirect.php?page=home_quarantine_patients&error_adding");
                        exit;
                    }

                }
            }
            //EDIT PATIENT
            if(isset($_POST['btnSave'])){
                if(!empty($_POST['P_ID']) && !empty($_POST['Fname']) && !empty($_POST['Lname'])&& !empty($_POST['Gender']) && !empty($_POST['Bdate']) && !empty($_POST['Occpt']) && !empty($_POST['Nation']) && !empty($_POST['Cntct'])  && !empty($_POST['Email']) && !empty($_POST['Addr']) && !empty($_POST['LastTrav']) && !empty($_POST['Btype']) && !empty($_POST['ComorB']) && !empty($_POST['PersonNotiName']) && !empty($_POST['PersonNotiRelation']) && !empty($_POST['PersonNotiCntct']) && !empty($_POST['PersonNotiAddr'])){
                    

                        //PERSONAL INFO
                        $P_ID = mysqli_real_escape_string($conn, $_POST['P_ID']);
                        $Fname = mysqli_real_escape_string($conn, $_POST['Fname']);
                        $Mname = mysqli_real_escape_string($conn, $_POST['Mname']);
                        $Lname = mysqli_real_escape_string($conn, $_POST['Lname']);
                        $Gender = mysqli_real_escape_string($conn, $_POST['Gender']);
                        $Bdate = mysqli_real_escape_string($conn, $_POST['Bdate']);
                        $Occpt = mysqli_real_escape_string($conn, $_POST['Occpt']);
                        $Nation = mysqli_real_escape_string($conn, $_POST['Nation']);
                        $ContactNum = mysqli_real_escape_string($conn, $_POST['Cntct']);
                        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
                        $Addr = mysqli_real_escape_string($conn, $_POST['Addr']);

                        //MEDICAL INFO
                        $LastTrav = mysqli_real_escape_string($conn, $_POST['LastTrav']);
                        $Btype = mysqli_real_escape_string($conn, $_POST['Btype']);
                        $Comorbidities = mysqli_real_escape_string($conn, $_POST['ComorB']);

                        //CONTACT PERSON INCASE OF EMERGENCY
                        $PersonNotiName = mysqli_real_escape_string($conn, $_POST['PersonNotiName']);
                        $PersonNotiRelation = mysqli_real_escape_string($conn, $_POST['PersonNotiRelation']);
                        $PersonNotiCntct = mysqli_real_escape_string($conn, $_POST['PersonNotiCntct']);
                        $PersonNotiAddress = mysqli_real_escape_string($conn, $_POST['PersonNotiAddr']);
                        $Description = $uname_action . " made changes in data of " . $U_ID;

    
                        //UPDATE PATIENT INFO
                        $update_query = "UPDATE patient_info SET Sname = '$Lname', Fname = '$Fname', Mname = '$Mname', Gender = '$Gender', BirthDate = '$Bdate', Occupation = '$Occpt', Nationality = '$Nation', ContactNumber = '$ContactNum', EmailAddress = '$Email', LastTravelHistory = '$LastTrav', BloodType = '$Btype', Comorbidities = '$Comorbidities', ContactPersonName = '$PersonNotiName', ContactPersonNumber = '$PersonNotiCntct', ContactPersonAddress = '$PersonNotiAddress', Relationship = '$PersonNotiRelation' WHERE P_ID = '$P_ID'";
                    

                        if(mysqli_query($conn,$update_query)){
                            $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'EditPatient','$Description', '$dateNow', '$timeNow')";
                            mysqli_query($conn, $insert_logs_query);

                            header("Location:../redirect.php?page=home_quarantine_patients&success_adding");
                            exit;
                        }else{
                            header("Location:../redirect.php?page=home_quarantine_patients&error_adding");
                            exit;
                        }

                }
            }
            // RESET PASSWORD
            if(isset($_POST['btnResetPass'])){
                $IDsToReset = $_POST['IDsToReset'];
                $Password = DefaultAppPassword();

                foreach($IDsToReset as $PatientID){
                    $resetpass_query = "UPDATE patient_info SET Passwd = '$Password' WHERE P_ID = '$PatientID'";
                    mysqli_query($conn,$resetpass_query);

                    $Description = $uname_action . "(" . $user_id . ")" . " reset password of " . $PatientID;

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'EditUser','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);
                }

                header("Location:../redirect.php?page=home_quarantine_patients&password_reset");
                exit;
            }
        }

        if(isset($_SERVER['REQUEST_METHOD']) == "GET"){
            //RESET PASSWORD
            if(isset($_GET['resetpass_id'])){
                
                $PatientID = mysqli_real_escape_string($conn, $_GET['resetpass_id']);

                $Password = DefaultAppPassword();

                $resetpass_query = "UPDATE patient_info SET Passwd = '$Password' WHERE P_ID = '$PatientID'";
                if(mysqli_query($conn,$resetpass_query)){

                    $Description = $uname_action . "(" . $user_id . ")" . " reset password of " . $PatientID;

                    // INSERT LOGS
                    $insert_logs_query = "INSERT INTO user_logs (U_ID_Action, Uname_Action, Action, Comments, DateOfAction, TimeOfAction) VALUES ('$user_id', '$uname_action', 'EditUser','$Description', '$dateNow', '$timeNow')";
                    mysqli_query($conn, $insert_logs_query);
                    
                    header("Location:../redirect.php?page=home_quarantine_patients&password_reset");
                    exit;
                }else{
                    header("Location:../redirect.php?page=home_quarantine_patients&query_error");
                    exit;
                }
            }
        }
    }
?>