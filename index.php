<?php 

    session_start();

    require("php/config.php");
    require("php/hideText.php");
    require("php/SMSFunction.php");
    
    if(isset($_SESSION['RESTQ_USER-ID'])){
        
        header("Location: redirect.php");
        exit;

    }

    date_default_timezone_set('Asia/Manila');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- TITLE -->
    <title>Home Quarantine Monitoring</title>
    <link rel="shortcut icon" type="image" href="resources/images/System/RestQ_AppIcon_TransBG.png">
    
    <!-- FONTAWESOME CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- BOOTSTRAP CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">


    <!-- CSS LINK -->
    <link rel="stylesheet" href="css/theme.css">

    <link rel="stylesheet" href="css/responsive.css">

    <!-- SWEET ALERT CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
    
    <div class="container-fluid row p-0 m-0" id="bg-container">
        <div class="col-md-9 p-0">
            <div class="w-100 bgl-template position-relative">
                <div class="container rounded-3 position-absolute translate-middle bg-login">
                    <div class="row">
                        <figure class="col-md-12 brand-logo">
                            <img src="resources/images/System/flex_logo_white.png" alt="LOGO"/>
                        </figure>
                        <div class="col-md-12 px-4 text-center">
                            <?php
                                function isMobile() {
                                    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
                                }

                                if(isMobile()){
                                    $session_unit =  "MOBILE PHONE";
                                }
                                else {
                                    $session_unit =  "DESKTOP/LAPTOP";
                                }

                                if(isset($_SERVER['REQUEST_METHOD']) == "POST" && isset($_POST['btnLogin'])){
                                    if(!empty($_POST['userID']) && !empty($_POST['passWD'])){
                                        $user_id = mysqli_real_escape_string($conn, $_POST['userID']);
                                        $pass = mysqli_real_escape_string($conn, $_POST['passWD']);
                            
                                        $sql_query = "SELECT * FROM user_info WHERE U_ID = '$user_id'";
                                        $sql_result = mysqli_query($conn, $sql_query);
                            
                                        if(mysqli_num_rows($sql_result) > 0){
                                            while($row = mysqli_fetch_array($sql_result)){
                                                $correct_pass = $row['Passwd'];
                                                $acc_id = $row['U_ID']; 
                                                $SigninStatus = $row['SigninStatus'];
                                                $User_Role = $row['Roles'];
                                                $verification_status = $row['VerificationStatus'];
                                                $umail = $row['EmailAddress'];
                                                $fname = $row['Fname'];
                                                $lname = $row['Sname'];
                                                $contact_number = $row['ContactNumber'];
                                            }
                                            
                                            if($SigninStatus == "Unblock"){
                                                if(password_verify($pass, $correct_pass)){
                                                    $dateNow = date("Y-m-d");
                                                    $timeNow = date("G:i:s");
                                                    $vkey = substr(number_format(time() * rand(), 0, '', '', ), 0, 5);
                                                    $token_id = sha1($acc_id);
                                                    $time_expiration = date("Y-m-d G:i:s");

                                                    if($pass == 'RestQpass2021'){

                                                            mysqli_query($conn, "UPDATE user_info SET OTPCode = '$vkey', OTPExpiration = '$time_expiration' WHERE U_ID = '$acc_id'");   

                                                            try {
                                                                //Change number format
                                                                $contact_number = changeContactFormat($contact_number);
                                                                $message = "Do not share your One-Time Password with anyone. Your OTP is $vkey";

                                                                SendSMS($contact_number, $message);

                                                                $_SESSION['verifyType'] = "DefaultPassword"; 

                                                                echo '<div class="alert alert-warning" style="font-size : 12px">You are using the default password. Check for the verification code sent to your number!</div>';
                                                                
                                                                echo '<script>
                                                                        swal({
                                                                            title: "Verification",
                                                                            text: "Go to verification",
                                                                            icon: "success",
                                                                            closeOnClickOutside: false,
                                                                        }).then(function (result) {
                                                                            if (true) {
                                                                                window.location.assign("verification.php?token_id=' . $token_id . '");
                                                                            }
                                                                        });
                                                                      </script>';
                                                            } catch (Exception $e) {
                                                                echo "<div class='alert alert-danger'>Message could not be sent.</div>";
                                                            }
                                                    }else{
                                                        if($verification_status == "Verified"){
                                                            echo '<div class="alert alert-success">Successfully login!</div>';

                                                            $_SESSION['RESTQ_USER-ID'] = $acc_id;
                                                            $_SESSION['RESTQ_USER-ROLE'] = $User_Role;
                                                            $_SESSION['RESTQ_USER-PASSWORD'] = $pass; 


                                                            //SESSION LOGS
                                                            mysqli_query($conn, "INSERT INTO session_logs (U_ID, Session_Unit, Session_Date, Session_Time) VALUES ('$acc_id', '$session_unit', '$dateNow', '$timeNow')");
                                                            mysqli_query($conn, "UPDATE user_info SET AvailabilityStatus = 'Online' WHERE U_ID = '$acc_id'");
                                                            header("Location: redirect.php");
                                                            exit;
                                                        }else{

                                                            mysqli_query($conn, "UPDATE user_info SET OTPCode = '$vkey', OTPExpiration = '$time_expiration' WHERE U_ID = '$acc_id'");   
                                                            

                                                            try {
                                                                //Change number format
                                                                $contact_number = changeContactFormat($contact_number);
                                                                $message = "Do not share your One-Time Password with anyone. Your OTP is $vkey";

                                                                SendSMS($contact_number, $message);

                                                                $_SESSION['verifyType'] = "VerifyAccount"; 
                                                                
                                                                echo '<div class="alert alert-warning" style="font-size : 12px">Verify your account first. Verification code was sent to your number!</div>';

                                                                echo '<script>
                                                                        swal({
                                                                            title: "Verification",
                                                                            text: "Go to verification",
                                                                            icon: "success",
                                                                            closeOnClickOutside: false,
                                                                        }).then(function (result) {
                                                                            if (true) {
                                                                                window.location.assign("verification.php?token_id=' . $token_id . '");
                                                                            }
                                                                        });
                                                                      </script>';
                                                            } catch (Exception $e) {
                                                                echo "<div class='alert alert-danger'>Message could not be sent.</div>";
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo '<div class="alert alert-danger">Incorrect password!</div>';
                                                }
                                            }else{
                                                echo '<div class="alert alert-danger">Account was blocked. You cannot login. Contact admin for help!</div>';
                                            }
                                        }else{
                                            echo '<div class="alert alert-danger">User not found!</div>';
                                        }
                                    }else{
                                        echo '<div class="alert alert-warning">All fields are required!</div>';
                                    }
                                }
                                
                                    
                            ?>
                        </div>
                        <div class="col-11 p-4 pt-0 mx-auto">
                            <form action="index.php" method="post" class="row g-4 needs-validation" novalidate>
                                <!-- Input ID -->
                                <div class="col-12">
                                    <label for="userID" class="form-label fw-bold">USER ID</label>
                                    <div class="input-group login-input">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input type="text" class="form-control" name="userID" autocomplete="off" placeholder="USER ID" pattern="[ABDEX0-9-]+" id="userID" autofocus required>
                                    </div>
                                </div>
                                <!-- Input Password -->
                                <div class="col-12">
                                    <label for="passWD" class="form-label fw-bold">PASSWORD</label>
                                        <div class="input-group login-input">
                                            <span class="input-group-text">
                                                <i class="fas fa-key"></i>
                                            </span>
                                            <input type="password" class="form-control" name="passWD" autocomplete="off" placeholder="PASSWORD" id="passWD" required>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text bg-light">
                                                    <a href="#" class="text-dark" id="togglePass">
                                                        <i class="fas fa-eye" id="icon"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-12 text-center p-0">
                                    <a href="forgot_password.php" class="fw-bold nav-link">Forgot password?</a>
                                </div>
                                
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit" name="btnLogin">SIGN IN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 bgr-template">
        </div>
    </div>

<!-- BOOTSTRAP JS CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<!-- JS DESIGN LINK-->
<script type="text/javascript" src="js/form-validation.js"></script>

</body>
</html>