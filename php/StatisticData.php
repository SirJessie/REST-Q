<?php
    session_start();
    $dateNow = date('Y-m-d');
    include "config.php";

    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
    }

    if(isset($_POST['Data'])){
        
        $infect_disease = mysqli_real_escape_string($conn, $_POST['InfectiousDisease']);
       
        
        if($_POST['Data'] == 'TotalCaseToday'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_case_today = "SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease' AND RegistrationDate = '$dateNow'";
            }else{
                $count_case_today = "SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease' AND RegistrationDate = '$dateNow'";
            }
            $case_today_result = mysqli_query($conn, $count_case_today);
            $total_case_today = mysqli_num_rows($case_today_result);

            echo $total_case_today;
        }
        if($_POST['Data'] == 'TotalQuarantined'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_quarantine = "SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease' AND PatientCondition = 'Active'";
            }else{
                $count_quarantine = "SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease' AND PatientCondition = 'Active'";
            }
            $quarantine_result = mysqli_query($conn, $count_quarantine);
            $total_quarantine = mysqli_num_rows($quarantine_result);

            echo $total_quarantine;
        }
        if($_POST['Data'] == 'TotalCases'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);

            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_cases = "SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease'";
            }else{
                $count_cases = "SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease'";
            }
                
            $case_result = mysqli_query($conn, $count_cases);
            $total_cases = mysqli_num_rows($case_result);

            echo $total_cases;
        }
        if($_POST['Data'] == 'TotalRecoveries'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_recovery = "SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease' AND PatientCondition = 'Recover'";
            }else{
                $count_recovery = "SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease' AND PatientCondition = 'Recover'";
            }
            $recovery_result = mysqli_query($conn, $count_recovery);
            $total_recoveries = mysqli_num_rows($recovery_result);

            echo $total_recoveries;
        }
        if($_POST['Data'] == 'TotalDeceases'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_decease = "SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease' AND PatientCondition = 'Decease'";
            }else{
                $count_decease = "SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease' AND PatientCondition = 'Decease'";
            }
            $decease_result = mysqli_query($conn, $count_decease);
            $total_deceases = mysqli_num_rows($decease_result);

            echo $total_deceases;
        }
        if($_POST['Data'] == 'TotalActiveDevice'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_device = "SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease' AND DeviceStatus = 'Connected'";
            }else{
                $count_device = "SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease' AND DeviceStatus = 'Connected'";
            }
            $device_result = mysqli_query($conn, $count_device);
            $total_device = mysqli_num_rows($device_result);

            echo $total_device;
        }
        if($_POST['Data'] == 'TotalAlert'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            if($YOUR_USER_ROLE == "Global Administrator"){
                $count_alert = "SELECT * FROM alertlogs A INNER JOIN patient_info P ON A.P_ID = P.P_ID WHERE P.InfectiousDisease = '$infect_disease' AND A.DateNotify = '$dateNow'";
            }else{
                $count_alert = "SELECT * FROM alertlogs A INNER JOIN patient_info P ON A.P_ID = P.P_ID WHERE P.Barangay = '$brgy' AND P.InfectiousDisease = '$infect_disease' AND A.DateNotify = '$dateNow'";
            }
            $alert_result = mysqli_query($conn, $count_alert);
            $total_alert = mysqli_num_rows($alert_result);

            echo $total_alert;
        }
        if($_POST['Data'] == 'FetchChartValue'){
            $brgy = mysqli_real_escape_string($conn, $_POST['Brgy']);
            $chartYear = date('Y');
            if($YOUR_USER_ROLE == "Global Administrator"){
                $chartQuery ="SELECT * FROM patient_info WHERE InfectiousDisease = '$infect_disease' AND QuarantineDate like '%" . $chartYear . "%'";
            }else{
                $chartQuery ="SELECT * FROM patient_info WHERE Barangay = '$brgy' AND InfectiousDisease = '$infect_disease' AND QuarantineDate like '%" . $chartYear . "%'";
            }
            $chartResult = mysqli_query($conn,$chartQuery);
            $cases = [0,0,0,0,0,0,0,0,0,0,0,0];
            if(mysqli_num_rows($chartResult) > 0){
                while ($chartRow = mysqli_fetch_array($chartResult)){
                    $month = date('m', strtotime($chartRow['QuarantineDate']));
                    
                    $montly_cases = array($month - 1);
                    foreach ($montly_cases as $index) {
                        $cases[$index] += 1;
                    }
                }
                echo json_encode($cases);
            }else{
                echo json_encode($cases);
            }
        }

        if($_POST['Data'] == 'PopulateCases'){
            $sql ="SELECT * FROM patient_info";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) > 0){
                $data = array();
                while($row = mysqli_fetch_array($result)){
                    array_push($data, $row['InfectiousDisease']);
                }
                $new_data = array_unique($data);
                
                foreach ($new_data as $item){
                   echo '<option value=' . $item . '>' . $item .'</option>';
                }
            }
        }
    }
?>