<?php session_start(); ?>
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
                            
                            if(!isset($_SESSION['ChangePassU_ID'])){
                                echo '<script>
                                        window.location.assign("index.php");
                                      </script>';
                            }
                            if(isset($_POST['btnSavePass'])){
                                $UserID = $_SESSION['ChangePassU_ID'];
                                $new_pass = $_POST['newPass'];
                                $ret_new_pass = $_POST['retypeNewPass'];
                                $hash_pass = password_hash($new_pass, PASSWORD_DEFAULT);

                                $checkForUser = mysqli_query($conn, "SELECT * FROM user_info WHERE U_ID = '$UserID'");
                                
                                if(mysqli_num_rows($checkForUser) > 0){
                                    while($data = mysqli_fetch_array($checkForUser)){
                                        $SigninStatus = $data['SigninStatus'];
                                        $VerificationStatus = $data['VerificationStatus'];
                                    }

                                    if(!empty($new_pass) && !empty($ret_new_pass)){
                                        if($ret_new_pass == $new_pass){
                                            if(strlen($new_pass) > 10){
                                                if($VerificationStatus == "Verified"){
                                                    if($SigninStatus == "Unblock"){
                                                        $checkForUser = mysqli_query($conn, "UPDATE user_info SET Passwd = '$hash_pass' WHERE U_ID = '$UserID'");
    
                                                        echo '<div class="alert alert-success">Save successfully!</div>';
    
                                                        echo '<script>
                                                            swal({
                                                                title: "PASSWORD CHANGE",
                                                                text: "Save changes",
                                                                icon: "success",
                                                                closeOnClickOutside: false,
                                                            }).then(function (result) {
                                                                if (true) {
                                                                    window.location.assign("index.php");
                                                                }
                                                            });
                                                        </script>';
                                                    }else{
                                                        echo '<div class="alert alert-danger">Account was blocked. You cannot change password. Contact admin for help!</div>';
                                                        
                                                        unset($_SESSION['ChangePassU_ID']);
                                                        
                                                        echo '<script>
                                                            swal({
                                                                title: "ERROR",
                                                                text: "Account was blocked!",
                                                                icon: "error",
                                                                closeOnClickOutside: false,
                                                            }).then(function (result) {
                                                                if (true) {
                                                                    window.location.assign("index.php");
                                                                }
                                                            });
                                                        </script>';
                                                    }
                                                }else{
                                                    echo '<div class="alert alert-warning" style="font-size : 12px">Your account was not verified. You cannot change your password!</div>';
                                                    
                                                    unset($_SESSION['ChangePassU_ID']);
            
                                                    echo '<script>
                                                            swal({
                                                                title: "ERROR",
                                                                text: "Account needs to be verified!",
                                                                icon: "error",
                                                                closeOnClickOutside: false,
                                                            }).then(function (result) {
                                                                if (true) {
                                                                    window.location.assign("index.php");
                                                                }
                                                            });
                                                        </script>';
                                                }
                                            }else{
                                                echo '<div class="alert alert-warning">Password must be 10 digits above!</div>';
                                            }
                                        }else{
                                            echo '<div class="alert alert-warning">Password not match!</div>';
                                        }
                                    }else{
                                        echo '<div class="alert alert-warning">All fields required!</div>';
                                    }
                                    
                                }else{
                                    echo '<div class="alert alert-danger">User not found!</div>';

                                    unset($_SESSION['ChangePassU_ID']);

                                    echo '<script>
                                            swal({
                                                title: "ERROR",
                                                text: "User ID not found!",
                                                icon: "error",
                                                closeOnClickOutside: false,
                                            }).then(function (result) {
                                                if (true) {
                                                    window.location.assign("index.php");
                                                }
                                            });
                                        </script>';
                                }
                            }

                        ?>
                        </div>
                        <div class="col-11 p-4 pt-0 mx-auto">
                            <form action="changePassword.php" method="post" class="g-4 needs-validation" novalidate>
                                <div class="form-floating p-0">
                                    <input type="password" class="form-control" name="newPass" id="newPass" placeholder="New Password" autocomplete="off" required>
                                    <label for="newPass" class="form-label ps-2">Enter new password</label>
                                </div>
                                <div class="form-floating mt-2 p-0">
                                    <input type="password" class="form-control" name="retypeNewPass" id="retypeNewPass" placeholder="Retype Password" autocomplete="off" required>
                                    <label for="retypeNewPass" class="form-label ps-2">Retype new password</label>
                                </div>
                                <div class="mt-2 mb-3 d-flex">
                                    <input type="checkbox" class="m-1" id="toggleMultiplePass">
                                    <label for="toggleMultiplePass" class="fw-light">Show password</label>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100" type="submit" name="btnSavePass">SAVE CHANGES</button>
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
<script>
    $(document).ready(function () {
        $("#toggleMultiplePass").on('change', function(){
            var currPass = $("#currentPass"),
                    newPass = $("#newPass"),
                    retypePass = $("#retypeNewPass");

            if($("#toggleMultiplePass").is(':checked')){
                    currPass.attr("type","text");
                    newPass.attr("type","text");
                    retypePass.attr("type","text");
            }else{
                currPass.attr("type","password");
                newPass.attr("type","password");
                retypePass.attr("type","password");
            }
        });
    });
</script>
</body>
</html>