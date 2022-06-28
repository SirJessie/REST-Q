$(document).ready(function () {
    $("#FromBrgy").on('change', function () {
        $.ajax({
            url : 'php/CallFunction.php',
            method : 'post',
            data : { CallFunction : 'GenerateUserID', Brgy : $("#FromBrgy").val()},
            success : function(data){
                $("#U_ID").val(data);
            },
        })
    });
});
