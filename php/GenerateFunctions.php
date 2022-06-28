<?php
function GenerateUserID(){
    if(!empty($_POST['Brgy'])){
        include "config.php";

        //GENERATE EMPLOYEE ID
        $select_max_id = "SELECT MAX(ID) as 'max_id' from user_info";
        $res_max_id	= mysqli_query($conn, $select_max_id);
        $data = mysqli_fetch_array($res_max_id);
        $max_id = $data['max_id'];
        $max_id++;

        if($max_id > 0 && $max_id < 10){
            $number = "00" . $max_id;
        }else if($max_id > 9 && $max_id < 100){
            $number = "0" . $max_id;
        }else{
            $number = $max_id;
        }

        $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
        
        $dateNow = substr(date("Y"), -2);

        $User_ID = "B" . $brgy . "-E" . $dateNow . $number;

        return $User_ID;
    }else{
        return NULL;
    }
}
function GeneratePatientID(){
    if(!empty($_POST['Brgy'])){
        include "config.php";

        //GENERATE EMPLOYEE ID
        $select_max_id = "SELECT MAX(ID) as 'max_id' from patient_info";
        $res_max_id	= mysqli_query($conn, $select_max_id);
        $data = mysqli_fetch_array($res_max_id);
        $max_id = $data['max_id'];
        $max_id++;

        if($max_id > 0 && $max_id < 10){
            $number = "0000" . $max_id;
        }else if($max_id > 9 && $max_id < 100){
            $number = "000" . $max_id;
        }else if($max_id > 99 && $max_id < 1000){
            $number = "00" . $max_id;
        }else if($max_id > 999 && $max_id < 10000){
            $number = "0" . $max_id;
        }else{
            $number = $max_id;
        }

        $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
        
        $dateNow = substr(date("Y"), -2);

        $User_ID = "B" . $brgy . "-P" . $dateNow . $number;

        return $User_ID;
    }else{
        return NULL;
    }
}

function DefaultWebPassword(){
    $pass = "RestQpass2021";
    $password = password_hash($pass, PASSWORD_DEFAULT);

    return $password;
}
function DefaultAppPassword(){
    $pass = "RestQapp2021";
    $password = password_hash($pass, PASSWORD_DEFAULT);

    return $password;
}
?>