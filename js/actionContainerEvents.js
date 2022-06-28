$(document).ready(function () {

	// TRIGGER ADD USER
    $("#addUser").on('click',function () {
        showActionContainer();
        $("#addUser").prop("disabled", true);
		$("#resetUser").prop("disabled", true);
		$("#deleteUser").prop("disabled", true);
		$("input[name='userSelect[]']").prop("disabled", true);
		$("input[name='userSelect[]']").prop("checked", false);
		AddUser();
    });

	// TRIGGER RESET USER PASS 
	$("#resetUser").on('click', function () {
		var checkBoxes = $("input[name='userSelect[]']:checked").length;
		if(checkBoxes < 1){
			swal({
				title:"Error on reset password",
				text: "No selected user!",
				icon: "error",
				closeOnClickOutside: false,
			});
		}else{
			showActionContainer();
			ResetUserPassword();
		}
	});
	// TRIGGER DELETE USER
	$("#deleteUser").on('click', function () {
		var checkBoxes = $("input[name='userSelect[]']:checked").length;
		if(checkBoxes < 1){
			swal({
				title:"Error on deleting",
				text: "No selected user!",
				icon: "error",
				closeOnClickOutside: false,
			});
		}else{
			showActionContainer();
			DeleteUser();
		}
	});

	// TRIGGER USER INFO
	$("input[name='userSelect[]']").on('change', function () {
		//MULTIPLE CHECKBOX SELECT
		var checkBoxes = $("input[name='userSelect[]']:checked").length;

		if(checkBoxes < 1){
			closeActionContainer();
		}else if(checkBoxes == 1){
			showActionContainer();
			ViewUserInfo();
		}else if(checkBoxes > 1){

			closeActionContainer();
			// var selected = new Array();

			// $("input[name='userSelect[]']:checked").each(function () {
			// 	selected.push(this.value);
			// });
			
		}
	});

	// TRIGGER RESTORE USER
	$("#restoreUser").on('click', function () {
		var checkBoxes = $("input[name='restoreUser[]']:checked").length;
		if(checkBoxes < 1){
			swal({
				title:"Error on restoring",
				text: "No selected user!",
				icon: "error",
				closeOnClickOutside: false,
			});
		}else if(checkBoxes > 1){
			swal({
				title:"Error on restoring",
				text: "Cannot restore multiple user!",
				icon: "error",
				closeOnClickOutside: false,
			});
		}else{
			showActionContainer();
			RestoreUser();
		}
	});

	// TRIGGER ADD PATIENT
    $("#addPatient").on('click',function () {
        showActionContainer();
        $("#addPatient").prop("disabled", true);
		$("#resetPatient").prop("disabled", true);
		$("input[name='patientSelect[]']").prop("disabled", true);
		$("input[name='patientSelect[]']").prop("checked", false);
		AddPatient();
    });

	// TRIGGER PATIENT INFO
	$("input[name='patientSelect[]']").on('change', function () {
		//MULTIPLE CHECKBOX SELECT
		var checkBoxes = $("input[name='patientSelect[]']:checked").length;

		if(checkBoxes < 1){
			closeActionContainer();
		}else if(checkBoxes == 1){
			showActionContainer();
			ViewPatientInfo();
		}else if(checkBoxes > 1){

			closeActionContainer();
			// var selected = new Array();

			// $("input[name='userSelect[]']:checked").each(function () {
			// 	selected.push(this.value);
			// });
			
		}
	});

	//TRIGGER RESET PATIENT PASS
	$("#resetPatient").on('click', function () {
		var checkBoxes = $("input[name='patientSelect[]']:checked").length;
		if(checkBoxes < 1){
			swal({
				title:"Error on reset password",
				text: "No selected patient!",
				icon: "error",
				closeOnClickOutside: false,
			});
		}else{
			showActionContainer();
			ResetPatientPassword();
		}
	});

	$("#closeButton").on('click', function () {
		closeActionContainer();

		// USER
		$("#addUser").prop("disabled", false);
		$("input[name='userSelect[]']").prop("checked", false);
		$("#resetUser").prop("disabled", false);
		$("#deleteUser").prop("disabled", false);
		$("input[name='userSelect[]']").prop("disabled", false);

		// PATIENT
		$("#addPatient").prop("disabled", false);
		$("input[name='patientSelect[]']").prop("checked", false);
		$("#resetPatient").prop("disabled", false);
		$("input[name='patientSelect[]']").prop("disabled", false);
	});

    function showActionContainer(){
		var actionContainer = document.querySelector("#actionContainer");
		actionContainer.style.visibility = "visible";
	}
	
	function closeActionContainer(){
		var actionContainer = document.querySelector("#actionContainer");
		actionContainer.style.visibility = "hidden";
	}
	//FOR USERS
		// SHOW ADD USER FUNCTION
		function AddUser(){
			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : { LoadData : 'AddUser', Brgy : $("#BrgyValue").text()},
				cache : false,
				success : function(data){
					$("#actionMainContainer").html(data);
				},
			})
		}
		// SHOW VIEW USER INFO FUNCTION
		function ViewUserInfo(){
			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : {LoadData : 'ViewInfoUser', UserID : $("input[name='userSelect[]']:checked").val()},
				cache : false,
				success : function (data) {
					$("#actionMainContainer").html(data);
				}
			})
		}
		// SHOW RESET PASS FUNCTION
		function ResetUserPassword(){
			var arrayToReset = new Array();

			$("input[name='userSelect[]']:checked").each(function () {
				arrayToReset.push(this.value);
			});


			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : {LoadData : 'ResetUserPass', arrayToReset : arrayToReset},
				cache : false,
				success : function (data) {
					$("#actionMainContainer").html(data);
				}
			})
		}
		// SHOW DELETE USER FUNCTION
		function DeleteUser(){
			var arrayToDelete = new Array();

			$("input[name='userSelect[]']:checked").each(function () {
				arrayToDelete.push(this.value);
			});


			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : {LoadData : 'DeleteUser', arrayToDelete : arrayToDelete},
				cache : false,
				success : function (data) {
					$("#actionMainContainer").html(data);
				}
			})
		}
		// SHOW RESTORE USER FUNCTION
		function RestoreUser(){

			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : {LoadData : 'RestoreUser', UserID : $("input[name='restoreUser[]']:checked").val(), Username : $("#Username").text()},
				cache : false,
				success : function (data) {
					$("#actionMainContainer").html(data);
				}
			})
		}
	//END FOR USERS

	//FOR PATIENTS
		// SHOW ADD PATIENT FUNCTION
		function AddPatient(){
			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : { LoadData : 'AddPatient', Brgy : $("#BrgyValue").text()},
				cache : false,
				success : function(data){
					$("#actionMainContainer").html(data);
				},
			})
		}
		// SHOW VIEW PATIENT INFO FUNCTION
		function ViewPatientInfo(){
			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : {LoadData : 'ViewInfoPatient', PatientID : $("input[name='patientSelect[]']:checked").val()},
				cache : false,
				success : function (data) {
					$("#actionMainContainer").html(data);
				}
			})
		}
		// SHOW RESET PASS FUNCTION
		function ResetPatientPassword(){
			var arrayToReset = new Array();

			$("input[name='patientSelect[]']:checked").each(function () {
				arrayToReset.push(this.value);
			});


			$.ajax({
				url : 'php/LoadData.php',
				method : 'post',
				data : {LoadData : 'ResetPatientPass', arrayToReset : arrayToReset},
				cache : false,
				success : function (data) {
					$("#actionMainContainer").html(data);
				}
			})
		}
	//END FOR PATIENTS

});