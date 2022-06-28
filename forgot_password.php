<?php

    session_start();
    
    use Twilio\Rest\Client;

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
                            require("php/config.php");
                            require("php/hideText.php");
                            require("php/SMSFunction.php");

                            if(isset($_POST['btnResetPass'])){
                                $UserID = $_POST['userID'];
                                $vkey = substr(number_format(time() * rand(), 0, '', '', ), 0, 5);
                                $time_expiration = date("Y-m-d G:i:s");

                                $checkForUser = mysqli_query($conn, "SELECT * FROM user_info WHERE U_ID = '$UserID'");

                                if(mysqli_num_rows($checkForUser) > 0){
                                    while($data = mysqli_fetch_array($checkForUser)){
                                        $contact_number = $data['ContactNumber'];
                                    }

                                    mysqli_query($conn, "UPDATE user_info SET OTPCode = '$vkey', OTPExpiration = '$time_expiration' WHERE U_ID = '$UserID'");

                                    
                                    
                                    try {
                                        //Change number format
                                        $contact_number = changeContactFormat($contact_number);
                                        $message = "Do not share your One-Time Password with anyone. Your OTP is $vkey";

                                        SendSMS($contact_number, $message);
                                        
                                        $_SESSION['verifyType'] = "ForgotPassword";
                                        $token_id = sha1($UserID); 
                                        
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
                                    echo '<div class="alert alert-danger">User not found!</div>';
                                }
                            }
                        ?>
                        </div>
                        <div class="col-11 p-4 pt-0 mx-auto">
                            <form action="forgot_password.php" method="post" class="row g-4 needs-validation" novalidate>
                                <!-- Input ID -->
                                <div class="col-12">
                                    <label for="userID" class="form-label fw-bold">USER ID</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="userID" autocomplete="off" placeholder="ENTER YOUR USER ID" pattern="[BE0-9-]+" id="userID" autofocus required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit" name="btnResetPass">RESET PASSWORD</button>
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