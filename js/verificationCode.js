$(document).ready(function () {
    Timer();

    $("#btnVerify").on('click', function () {
        var count = $("#countDown").text();
        
        if($("#input1").val() == "" && $("#input2").val() == "" && $("#input3").val() == "" && $("#input4").val() == "" && $("#input5").val() == ""){
            $("#verifyErr").html('<div class="alert alert-danger">Enter value in fields!</div>');
        }else if($("#input1").val() == "" || $("#input2").val() == "" || $("#input3").val() == "" || $("#input4").val() == "" || $("#input5").val() == ""){
            $("#verifyErr").html('<div class="alert alert-danger">All fields are required!</div>');
        }else{
            if(count > 0){
                var completeVal = "";
                completeVal += $("#input1").val(),
                completeVal += $("#input2").val(),
                completeVal += $("#input3").val(),
                completeVal += $("#input4").val(),
                completeVal += $("#input5").val();
                
                $.ajax({
                    url : 'php/countDown.php',
                    method : 'post',
                    data : {Process : "VerifyOTP", OTPCode : completeVal, VerifyType : $("#verifyType").text() , token_id : $("#token_id").text()},
                    cache : false,
                    beforeSend: function () {
                        $("#btnVerify").prop("disabled", true);
                        $("#btnVerify").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                    },
                    success : function(response){
                        if(response == "Wrong"){
                            $("#verifyErr").html("<div class='alert alert-danger'>Wrong OTP Code!</div>");
                        }else{
                            $("#verifyErr").html("<div class='alert alert-success'>Verified successfull!</div>");
                            
                            var transition = 2;

                            var downloadTimer = setInterval(function(){
                                if(transition <= 0){
                                    clearInterval(downloadTimer);
                                    if(response == "VerifyAccount"){
                                        window.location.assign("index.php");
                                    }else if(response == "DefaultPassword" || response == "ForgotPassword"){
                                        window.location.assign("changePassword.php");
                                    }
                                    
                                }
                            transition -= 1;
                            }, 1000);
                        }

                        $("#btnVerify").prop("disabled", false);
                        $("#btnVerify").html("Verify");
                    }
                })
            }else{
                $("#verifyErr").html('<div class="alert alert-danger">Your OTP Code was expired!</div>');
            }
        }
        
        
    });

    //Expiration timer
    function Timer(){
        var downloadTimer = setInterval(function(){
            $.ajax({
                url : 'php/countDown.php',
                method : 'post',
                data : {Process: 'SetTimer', token_id : $("#token_id").text()},
                cache : false,
                success : function(response){
                    if(response <= 0){
                        clearInterval(downloadTimer);
                    }
                    $("#countDown").html(response);  
                }
            })  
        }, 1000); 
    }
})