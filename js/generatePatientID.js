$(document).ready(function(){
    populateCases()

    $("#FromBrgy").on('change', function () {
        $.ajax({
            url : 'php/CallFunction.php',
            method : 'post',
            data : { CallFunction : 'GeneratePatientID', Brgy : $("#FromBrgy").val()},
            success : function(data){
                $("#P_ID").val(data);
            },
        })
    });

    $("#newCase").on("change", function () {
        if($("#newCase").is(":checked")){
            $("#caseSelection").html("<input type='text' class='form-control' name='virusCase' required>");
        }else{
            $("#caseSelection").html("<select name='virusCase' class='form-select' id='selectCase' required>");
            populateCases();
        }
    });

    function populateCases(){
		$("#selectCase").html("");
		$.ajax({
			url : 'php/StatisticData.php',
			method : 'post',
			data : { Data : 'PopulateCases'},
			cache : false,
			success : function(data){
				$("#selectCase").html(data);
			}
		})
	}
})