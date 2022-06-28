$(document).ready(function () {
    showPersonnel();

    //SEND SMS TO PATIENT CONTACT PERSON
    $("#btnSendSms").on('click', function () {
        var message_body = $("#txtMessage").val(),
            patient_id = $("#ContactPersonID").text();

        if(message_body == ""){
            swal("", "Compose your message body", "error");
        }else{
            $.ajax({
                url : 'php/Notifications.php',
                method : 'post',
                data : { Data : "SendSMS", MessageBody : message_body, P_ID : patient_id},
                beforeSend: function () {
                    $("#btnSendSms").prop("disabled", true);
                    $("#btnSendSms").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                },
                success : function(data){
                    swal({
                        title: data,
                        text: "Message sent",
                        icon: "success",
                        closeOnClickOutside: false,
                    }).then(function (result) {
                        if (true) {
                            $("#btnSendSms").prop("disabled", false);
                            $("#btnSendSms").html('<i class="fa-solid fa-paper-plane"></i>&nbsp; Send');
                            $("#txtMessage").val("");
                            $(".btn-close").trigger("click");
                        }
                    });
                    
                }
            })
        }
    });

    $("#searchPersonnel").on('keyup', function(){
        var searchVal = $("#searchPersonnel").val();

        if(searchVal == ""){
            $("#assistance_list").html('<div class="d-flex justify-content-center p-5 border border-primary">' +  
                                            '<span >Search for personnel...</span>' +
                                        '</div>');
        }else{
            $.ajax({
                url : 'php/Notifications.php',
                method : 'post',
                data : { Data : "SearchPersonnel", SearchValue : searchVal , Brgy : $("#BrgyValue").text()},
                beforeSend: function () {
                    $("#assistance_list").html('<div class="d-flex justify-content-center p-5">' +
                                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>' +
                                        '</div>');
                },
                success : function(data){
                    $("#assistance_list").html(data);
                }
            })
        }
    });

    $("#searchPersonnel").on('focusout', function(){
         showPersonnel();
    });

    // TRIGGER PATIENT INFO
	$("#btnDeployPerson").on('click', function () {
		//MULTIPLE CHECKBOX SELECT
		var checkBoxes = $("input[name='personnelSelect[]']:checked").length;

		if(checkBoxes < 1){
			swal({
                    title: "",
                    text: "Please select personnel",
                    icon: "error",
                    closeOnClickOutside: false,
                });
		}else if(checkBoxes == 1){
            deployPersonnel();
		}else if(checkBoxes > 1){
            swal({
                    title: "",
                    text: "Cannot select 2 or more personnel",
                    icon: "error",
                    closeOnClickOutside: false,
                });
		}
	});

    function showPersonnel(){
        $.ajax({
            url : 'php/Notifications.php',
            method : 'post',
            data : { Data : "ShowPersonnel", Brgy : $("#BrgyValue").text()},
            success : function(data){
                $("#assistance_list").html(data);
            }
        })
    }

    function deployPersonnel(){
        var personnelID = $("input[name='personnelSelect[]']:checked").val();

        $.ajax({
            url : 'php/Notifications.php',
            method : 'post',
            data : { Data : "DeployPersonnel", Brgy : $("#BrgyValue").text(), U_ID : personnelID},
            beforeSend: function () {
                $("#btnDeployPerson").prop("disabled", true);
                $("#btnDeployPerson").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            },
            success : function(data){
                swal({
                    title: "",
                    text: "Success",
                    icon: "success",
                    closeOnClickOutside: false,
                }).then(function () {
                    if (true) {
                        $("#btnDeployPerson").prop("disabled", false);
                        $("#btnDeployPerson").html("Deploy personnel");
                        $(".btn-close").trigger("click");
                    }
                });
            }
        })
    }
});