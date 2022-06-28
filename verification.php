<?php
    session_start();
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

    <link rel="stylesheet" href="css/verification.css">

    <link rel="stylesheet" href="css/responsive.css">

    <!-- SWEET ALERT CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
    <!-- BOOTSTRAP JS CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>
    <div class="container-fluid p-0 m-0 row" id="bg-container">
        <div class="col-md-6 d-flex justify-content-center align-items-center l-solid-background">
            <img src="resources/images/System/RestQ_AppIcon_TransBG.png" alt="">
        </div>
        <div class="col-md-6 d-flex justify-content-center align-items-center r-solid-background">
            <div class="card m-auto p-5">
                <h2 class="fw-bolder text-center mb-4">VERIFICATION</h2>
                <div class="text-center" id="verifyErr">
                    <!-- VERIFICATION ERROR -->
                </div>
                <?php
                    require("php/config.php");
                    require("php/hideText.php");

                    date_default_timezone_set('Asia/Manila');

                    if(isset($_GET['token_id']) && isset($_SESSION['verifyType'])){
                        $token_id = $_GET['token_id'];
                        $getIDs = mysqli_query($conn, "SELECT * FROM user_info");

                        while($row = mysqli_fetch_array($getIDs)){
                            $encrypted_pass = sha1($row['U_ID']);

                            if($token_id == $encrypted_pass){
                                $number = $row['ContactNumber'];
                            }
                        }

                        $verify_type = $_SESSION['verifyType'];
                    }else{
                        header("Location: index.php");
                        exit;
                    }
                    

                ?>
                <span id="verifyType" hidden><?= $verify_type ?></span>
                <span>
                    Please type the verification code sent to <?= hideContact($number) ?>
                </span>
                <p>Verification code will expired in <span class="text-danger" id="countDown"></span>s!</p>
                <form id="target">
                    <span id="token_id" hidden><?= $_GET['token_id']; ?></span>
                    <div class="d-flex">
                        <input type="text" id="input1" class="form-control text-center" placeholder="*" autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="1" autofocus>
                        <input type="text" id="input2" class="form-control text-center mx-2" placeholder="*" autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="1" >
                        <input type="text" id="input3" class="form-control text-center" placeholder="*" autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="1" >
                        <input type="text" id="input4" class="form-control text-center mx-2" placeholder="*" autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="1" >
                        <input type="text" id="input5" class="form-control text-center" placeholder="*" autocomplete="off" onkeypress="return onlyNumberKey(event)" maxlength="1" >
                    </div>
                    
                    <div class="form-group my-3">
                        <button type="button" class="btn btn-base_color w-100" id="btnVerify">Verify</button>
                    </div>
                    <div class="text-center">
                        <span>Didn't receive code?<a href="php/countDown.php?token_id=<?= $token_id ?>"> Request again</a></span>
                    </div>
                    <div class="text-center mt-4">
                        <a href="index.php">Go back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>   
<script>
    function onlyNumberKey(evt) {
          // Only ASCII character in that range allowed
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
    }
</script>
<script src="js/verificationCode.js"></script> 
<script src="js/initializeTooltip.js"></script>
<script src="js/form-validation.js"></script>
<script src="js/focusNextInput.js"></script>

</html>
