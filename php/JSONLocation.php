<?php
    session_start();
    require "config.php";

    // USER ID
    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
    }

    if(isset($_POST['Brgy']) && isset($_POST['Disease'])){
        $brgy = $_POST['Brgy'];
        $disease = $_POST['Disease'];

        if($YOUR_USER_ROLE == "Global Administrator"){
            $sql_string = "SELECT P_ID, Latitude, Longhitude, Image, Fname, Mname, Sname, Address, ContactNumber, Barangay, InfectiousDisease, PatientCondition FROM patient_info WHERE InfectiousDisease = '$disease' AND PatientCondition = 'Active'";
        }else{
            $sql_string = "SELECT P_ID, Latitude, Longhitude, Image, Fname, Mname, Sname, Address, ContactNumber, Barangay, InfectiousDisease, PatientCondition FROM patient_info WHERE InfectiousDisease = '$disease' AND Barangay = '$brgy' AND PatientCondition = 'Active'";
        }
        
        $result = mysqli_query($conn, $sql_string);
        $location_array = array();
        
        while($row = mysqli_fetch_array($result)){
            $location_array[] = $row;
        }
        echo json_encode($location_array);    
    }
?>