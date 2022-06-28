<?php include_once "includes/header.php"; ?>
<?php
    require("php/hideText.php");

    if(isset($_SESSION['RESTQ_USER-ID']) && isset($_SESSION['RESTQ_USER-ROLE'])){
        $YOUR_USER_ID = $_SESSION['RESTQ_USER-ID'];
        $YOUR_USER_ROLE = $_SESSION['RESTQ_USER-ROLE'];
        $YOUR_NAME = $fetch_data['Fname'] . ' ' . $fetch_data['Mname'] . ' ' . $fetch_data['Sname'];
        $YOUR_ADDRESS = $fetch_data['Addr'];
        $YOUR_NUMBER = $fetch_data['ContactNumber'];
        $YOUR_EMAIL = $fetch_data['EmailAddress'];
        $YOUR_PASSWORD = $_SESSION['RESTQ_USER-PASSWORD'];
    }else{
        $YOUR_USER_ID = "";
        $YOUR_USER_ROLE = "";
        $YOUR_NAME = "";
        $YOUR_ADDRESS = "";
        $YOUR_NUMBER = "";
        $YOUR_EMAIL = "";
        $YOUR_PASSWORD = "";
    }
?>
    <div class="header-profile mb-5">
        <div class="header-panel">
            <div class="profile-picture">
                <img src="<?= 'resources/images/UserAvatars/' . $profile ?>" alt="avatar">
            </div>
            <div class="cover-logo">
                <img src="resources/images/System/flex_logo_white.png" alt="">
            </div>
        </div>
    </div>  
    <div class="personal-info">
        <table class="table table-info border">
            <tbody>
                <tr>
                    <td>
                        <span><span class="fw-bold">U_ID: </span><span id="YOUR_USER_ID"><?= $YOUR_USER_ID ?></span></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><span class="fw-bold">Role:</span> <?= $YOUR_USER_ROLE ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><span class="fw-bold">Name:</span> <?= $YOUR_NAME ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span><span class="fw-bold">Address:</span> <span class="td-address"><?= $YOUR_ADDRESS ?></span></span>
                    </td>
                </tr>
                <tr>
                    <td class="d-flex justify-content-between">
                        <div class="my-auto">
                            <span class="fw-bold">Contact #:</span>
                            <span id="YOUR_NUMBER"><?= hideContact($YOUR_NUMBER)?></span>
                        </div>
                        <button class="btn btn-dark_color" data-bs-toggle="modal" data-bs-target="#changeNumber">Change</button>
                    </td>
                </tr>
                <tr>
                    <td class="d-flex justify-content-between">
                        <div class="my-auto">
                            <span class="fw-bold">Email Address:</span>
                            <span id="YOUR_EMAIL"><?= hideEmail($YOUR_EMAIL)?></span>
                        </div>
                        <button class="btn btn-dark_color" data-bs-toggle="modal" data-bs-target="#changeEmail">Change</button>
                    </td>
                </tr>
                <tr>
                    <td class="d-flex justify-content-between">
                        <div class="my-auto">
                            <span class="fw-bold">Password:</span>
                            <span id="YOUR_PASSWORD"><?= hidePassword($YOUR_PASSWORD)?></span>
                        </div>
                        <button class="btn btn-dark_color" data-bs-toggle="modal" data-bs-target="#changePassword">Change</button>
                    </td>
                </tr>
            </tbody>
        </table>   
    </div>
    <div class="container-fluid p-5">
        <div class="session_container">
            <div class="pt-3 pb-0">
                <h4 class="p-3 pt-0 fw-bold">Recent login activity</h4>
                <div id="recent-login">
                    <?php
                        
                        require("php/config.php");

                        $pop_log_act = mysqli_query($conn, "SELECT * FROM session_logs WHERE U_ID = '$YOUR_USER_ID' ORDER BY ID DESC LIMIT 1");

                        if(mysqli_num_rows($pop_log_act) > 0):      
                            while($data = mysqli_fetch_array($pop_log_act)):
                    ?>
                        <div class="recent_login_item">
                            <div class="d-flex">
                                <?= ($data['Session_Unit'] == "DESKTOP/LAPTOP") ? '<i class="fa-solid fa-desktop icon"></i>' : '<i class="fa-solid fa-mobile-screen-button icon"></i>' ?>
                                
                                <span class="text">Your account was login on this unit</span>
                            </div>
                            <div class="date-time">
                                <span><?= date("F j, Y", strtotime($data['Session_Date'])) . " at " . date("h:i:s A", strtotime($data['Session_Time'])) ?></span>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                        else: 
                    ?>
                        <div class="recent_login_item">
                                <span class="text">NO LOGIN ACTIVITY...</span>
                        </div>
                    <?php 
                        endif;
                    ?>
                </div>
            </div>
            <hr class="m-0">
            <div class="d-flex justify-content-between p-3">
                <button type="button" id="btnShowMore" class="btn btn-outline-base_color">Show more</button>
                <span id="ShowValue" hidden>1</span>
                <button type="button" id="btnShowLess" class="btn btn-outline-base_color">Show less</button>
            </div>
        </div>
    </div>

<!-- CHANGE CONTACT NUMBER -->
<div class="modal fade" id="changeNumber" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeNumber" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="fw-bold">CHANGE YOUR CONTACT NUMBER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="changeNumErr">
                    <!-- CHANGE NUMBER ERROR -->
                </div>
                <div class="d-flex">Your current number is&nbsp;<b><span id="GET_NUMBER"><?= hideContact($YOUR_NUMBER)?></span></b></div>
                <span id="currentNumber" hidden><?= $YOUR_NUMBER ?></span>
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="newNumber" autocomplete="off" placeholder="09xxxxxxxxx" onkeypress="return onlyNumberKey(event)" maxlength="11" autofocus required>
                    <label for="newNumber" class="form-label">Enter new number</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-base_color" id="btnSaveNumber">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- CHANGE EMAIL ADDRESS -->
<div class="modal fade" id="changeEmail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeEmail" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="fw-bold">CHANGE YOUR EMAIL ADDRESS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="changeEmailErr">
                    <!-- CHANGE EMAIL ERROR -->
                </div>
                <div class="d-flex">Your current email address is&nbsp;<b><span id="GET_EMAIL"><?= hideEmail($YOUR_EMAIL)?></span></b></div>
                <span id="currentEmail" hidden><?= $YOUR_EMAIL ?></span>
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="newEmail" placeholder="name@example.com" autocomplete="off" autofocus>
                    <label for="newEmail" class="form-label">Enter email address</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-base_color" id="btnSaveEmail">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- CHANGE PASSWORD -->
<div class="modal fade" id="changePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePassword" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="fw-bold">CHANGE YOUR PASSWORD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="changePassErr">
                    <!-- CHANGE PASSWORD ERROR -->
                </div>
                <span id="currentPassword" hidden><?= $YOUR_PASSWORD ?></span>
                <div class="form-floating">
                    <input type="password" class="form-control" id="currentPass" placeholder="Password" autocomplete="off" autofocus>
                    <label for="currentPass" class="form-label">Enter current password</label>
                </div>
                <div class="form-floating mt-2">
                    <input type="password" class="form-control" id="newPass" placeholder="Password" autocomplete="off">
                    <label for="newPass" class="form-label">Enter new password</label>
                </div>
                <div class="form-floating mt-3">
                    <input type="password" class="form-control" id="retypeNewPass" placeholder="Password" autocomplete="off">
                    <label for="retypeNewPass" class="form-label">Retype new password</label>
                </div>
                <div class="d-flex p-2">
                    <input type="checkbox" class="m-1" id="toggleMultiplePass">
                    <label for="toggleMultiplePass" class="fw-light">Show password</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-base_color" id="btnSavePassword">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
        hideShowLess();

        $("#btnSaveNumber").on('click', function () {
            $("#btnSaveNumber").prop("disabled", true);
            changeContactNumber();
        });
        $("#btnSaveEmail").on('click', function () {
            $("#btnSaveEmail").prop("disabled", true);
            changeEmailAddress();
        });
        $("#btnSavePassword").on('click', function () {
            $("#btnSavePassword").prop("disabled", true);
            changePassword();
        });
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
        $("#btnShowMore").on('click', function () {
            let show_val = $("#ShowValue").text();
            show_val = parseInt(show_val) + 2;

            if(parseInt(show_val) >= 10){
                show_val = 10;
                $("#btnShowMore").prop("disabled", true);
            }else{
                $("#btnShowLess").prop("hidden", false);
            }
            
            $.ajax({
                url : 'php/LoginActivity.php',
                method : 'post',
                data : { ShowLimit : show_val },
                beforeSend: function () {
                    $("#btnShowMore").prop("disabled", true);
                    $("#btnShowMore").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                },
                success : function(data){
                    $("#recent-login").html(data);
                    $("#btnShowMore").prop("disabled", false);
                    $("#btnShowMore").html('Show more'); 
                }
            })

            $("#ShowValue").text(show_val);
            
        });
        $("#btnShowLess").on('click', function () {
            let show_val = $("#ShowValue").text();
            show_val = parseInt(show_val) - 2;

            if(parseInt(show_val) <= 1){
                show_val = 1;
                $("#btnShowLess").prop("hidden", true);
            }else{
                $("#btnShowMore").prop("disabled", false);
            }

            $.ajax({
                url : 'php/LoginActivity.php',
                method : 'post',
                data : { ShowLimit : show_val },
                beforeSend: function () {
                    $("#btnShowLess").prop("disabled", true);
                    $("#btnShowLess").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                },
                success : function(data){
                    $("#recent-login").html(data);
                    $("#btnShowLess").prop("disabled", false);
                    $("#btnShowLess").html('Show less');
                }
            })
            
            $("#ShowValue").text(show_val);
           
        });
        function hideShowLess(){
            let show_val = $("#ShowValue").text();

            if(parseInt(show_val) <= 1){
                $("#btnShowLess").prop("hidden", true);
            }else{
                $("#btnShowLess").prop("hidden", false);
            }
        }
        function changeContactNumber(){
            var userID = $("#YOUR_USER_ID").text(),
                currentNumber = $("#currentNumber").text(),
                newNumber = $("#newNumber").val();


            if(newNumber == ""){
                $("#changeNumErr").html('<div class="alert alert-danger">Enter your new number</div>');
                swal("Error on saving", "", "error");
            }else{
                if(newNumber.length < 11){
                    $("#changeNumErr").html('<div class="alert alert-warning">Number must be 11 digits number</div>');
                    swal("Error on saving", "", "warning");
                }else if(newNumber == currentNumber){
                    $("#changeNumErr").html('<div class="alert alert-warning">Enter different number</div>');
                    swal("Error on saving", "", "warning");
                }else if(newNumber.substring(0, 2) != "09"){
                    $("#changeNumErr").html('<div class="alert alert-warning">Invalid number</div>');
                    swal("Error on saving", "", "warning");
                }else{
                    $.ajax({
                        url : 'php/UserProcess.php',
                        method : 'post',
                        data : { ModalButton : 'BtnSaveNumber', UserID : userID, CurrentNumber : currentNumber, NewNumber : newNumber},
                        cache : false,
                        success : function(data){
                            swal("Successfully change", "", "success");
                            $("#YOUR_NUMBER").html(data);
                            $("#GET_NUMBER").html(data);
                            $("#newNumber").val("");
                            $(".btn-close").trigger("click");
                        }
                    })
                }
            }
            $("#btnSaveNumber").prop("disabled", false);
            
        }
        function changeEmailAddress(){
            var userID = $("#YOUR_USER_ID").text(),
                currentEmail = $("#currentEmail").text(),
                newEmail = $("#newEmail").val();


            if(newEmail == ""){
                $("#changeEmailErr").html('<div class="alert alert-danger">Enter your new email address</div>');
                swal("Error on saving", "", "error");
            }else{
                if(newEmail == currentEmail){
                    $("#changeEmailErr").html('<div class="alert alert-warning">Enter different email address</div>');
                    swal("Error on saving", "", "warning");
                }else if(IsEmail(newEmail) == false){
                    $("#changeEmailErr").html('<div class="alert alert-warning">Invalid email address</div>');
                    swal("Error on saving", "", "warning");
                }else{
                    $.ajax({
                        url : 'php/UserProcess.php',
                        method : 'post',
                        data : { ModalButton : 'BtnSaveEmail', UserID : userID, CurrentEmail : currentEmail, NewEmail : newEmail},
                        cache : false,
                        success : function(data){
                            swal("Successfully change", "", "success");
                            $("#YOUR_EMAIL").html(data);
                            $("#GET_EMAIL").html(data);
                            $("#newEmail").val("");
                            $(".btn-close").trigger("click");
                        }
                    })
                }
            }
            $("#btnSaveEmail").prop("disabled", false);
            
        }
        function changePassword(){
            var userID = $("#YOUR_USER_ID").text(),
                correctCurrPass = $("#currentPassword").text(),
                currentPass = $("#currentPass").val(),
                newPass = $("#newPass").val(),
                retypePass = $("#retypeNewPass").val();

            if(currentPass == "" || newPass == "" || retypePass == ""){
                $("#changePassErr").html('<div class="alert alert-danger">All fields are required</div>');
                swal("Error on saving", "", "error");
            }else{
                if(currentPass != correctCurrPass){
                    $("#changePassErr").html('<div class="alert alert-danger">Wrong current pass</div>');
                    swal("Error on saving", "", "error");
                }else{
                    if(newPass.length < 10 ){
                        $("#changePassErr").html('<div class="alert alert-warning">Password needs 10 minimum letters</div>');
                        swal("Error on saving", "", "warning");
                    }else{
                        if(newPass == currentPass){
                                $("#changePassErr").html('<div class="alert alert-warning">Enter different password</div>');
                                swal("Error on saving", "", "warning");
                        }else{
                            if(!/\d+/.test(newPass)){
                                $("#changePassErr").html('<div class="alert alert-warning">Password must contains uppercase letter and number</div>');
                                swal("Error on saving", "", "warning");
                            }else{
                                if(!/[a-z]/.test(newPass) && /[A-Z]/.test(newPass)){
                                    $("#changePassErr").html('<div class="alert alert-warning">Password must contains uppercase letter and number</div>');
                                    swal("Error on saving", "", "warning");
                                }else{
                                    if(retypePass == newPass){
                                        $.ajax({
                                            url : 'php/UserProcess.php',
                                            method : 'post',
                                            data : { ModalButton : 'BtnSavePassword', UserID : userID, CurrentPass : currentPass, NewPass : newPass},
                                            cache : false,
                                            success : function(data){
                                                swal("Successfully change", "", "success");
                                                $("#YOUR_PASSWORD").html(data);
                                                $("#currentPass").val("");
                                                $("#newPass").val("");
                                                $("#newEmail").val("");
                                                $("#retypeNewPass").val("");
                                                $(".btn-close").trigger("click");
                                            }
                                        })
                                    }else{
                                        $("#changePassErr").html('<div class="alert alert-warning">Password not match</div>');
                                        swal("Error on saving", "", "warning");
                                    }  
                                }   
                            }
                        }
                    }
                }
                
            }

            $("#btnSavePassword").prop("disabled", false);
        }

        function onlyNumberKey(evt) {
            
            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
                return false;
            }else{
                return true;
            }
        }
</script>

<?php include_once "includes/footer.php"?>