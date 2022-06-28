<?php
    session_start();
    use Twilio\Rest\Client;
    
    require("config.php");
    require("hideText.php");
    require("SMSFunction.php");

    date_default_timezone_set('Asia/Manila');


    //PROCESS OTP
    if(isset($_POST['Process'])){
        if($_POST['Process'] == "VerifyOTP"){
            $OTPInput = $_POST['OTPCode'];
            $token_id = $_POST['token_id'];
            $verify_type = $_POST['VerifyType'];
            
            $getIDs = mysqli_query($conn, "SELECT * FROM user_info");

            while($row = mysqli_fetch_array($getIDs)){
                $user_id = $row['U_ID'];
                $encrypted_id = sha1($row['U_ID']);
                $correct_code = $row['OTPCode'];

                if($token_id == $encrypted_id){
                    if($OTPInput == $correct_code){
                        if($verify_type == "DefaultPassword"){
                            $_SESSION['ChangePassU_ID'] = $user_id;

                            echo "DefaultPassword";   
                        }else if($verify_type == "ForgotPassword"){
                            $_SESSION['ChangePassU_ID'] = $user_id;
                            
                            echo "ForgotPassword";
                        }else if($verify_type == "VerifyAccount"){                    
                            $conn->query("UPDATE user_info SET VerificationStatus = 'Verified' WHERE U_ID = '$user_id'");

                            echo "Verified";
                        }
                    }else{
                        echo "Wrong";
                    }
                    
                    
                }
            }

            
        }else if($_POST['Process'] == "SetTimer"){
            $token_id = $_POST['token_id'];
            $getIDs = mysqli_query($conn, "SELECT * FROM user_info");

            while($row = mysqli_fetch_array($getIDs)){
                $encrypted_pass = sha1($row['U_ID']);


                if($token_id == $encrypted_pass){

                    $expiration_date = new DateTime($row['OTPExpiration']);
                    $current_date = new DateTime();

                    $diffInSeconds = $current_date->getTimestamp() - $expiration_date->getTimestamp();
                    $remainingTime = 61 - $diffInSeconds;

                    if($remainingTime > 0){
                        $seconds = $remainingTime;
                    }else{
                        $seconds = 0;
                    }
                }
            }

            echo $seconds;
        }
    }

    //UPDATE COUNT TIMER
    if(isset($_GET['token_id'])){
        $token_id = $_GET['token_id'];

        $getIDs = mysqli_query($conn, "SELECT * FROM user_info");

        while($row = mysqli_fetch_array($getIDs)){
            $encrypted_id = sha1($row['U_ID']);
            $contact_number = $row['ContactNumber'];
            $fname = $row['Fname'];
            $lname = $row['Sname'];
            $vkey = substr(number_format(time() * rand(), 0, '', '', ), 0, 5);
            $expiredTime = date("Y-m-d G:i:s");

            if($token_id == $encrypted_id){
                $user_id = $row['U_ID'];

                mysqli_query($conn, "UPDATE user_info SET OTPCode = '$vkey', OTPExpiration = '$expiredTime' WHERE U_ID = '$user_id'");

                require '../vendor/autoload.php';

                try {
                    //Change number format
                    $contact_number = changeContactFormat($contact_number);
                    $message = "Do not share your One-Time Password with anyone. Your OTP is $vkey";
                    
                    SendSMS($contact_number, $message);
                } catch (Exception $e) {
                    echo "<div class='alert alert-danger'>Message could not be sent.</div>";
                }

                header("Location: ../verification.php?token_id=$encrypted_id");
                exit;
            }
        }
    }
?>