<?php
    session_start();
    require "config.php";
    $user_id = $_SESSION['RESTQ_USER-ID'];
    
    mysqli_query($conn, "UPDATE user_info SET AvailabilityStatus = 'Offline' WHERE U_ID = '$user_id'");

    unset($_SESSION['RESTQ_USER-ID']);
    unset($_SESSION['RESTQ_USER-ROLE']);
    header("Location: ../index.php");
    exit;
?>