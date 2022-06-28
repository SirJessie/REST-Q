$(document).ready(function () {
    'use strict'

    var forms = document.querySelectorAll('.needs-validation')

    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault()
                e.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
        })


    $("#togglePass").on('click',function(){
        var inputPass = $("#passWD");
        if(inputPass.attr("type")==="password"){
            $("#icon").removeClass('fas fa-eye');
            $("#icon").addClass('fas fa-eye-slash');
            inputPass.attr("type","text");
            
        }else{
            $("#icon").removeClass('fas fa-eye-slash');
            $("#icon").addClass('fas fa-eye');
            inputPass.attr("type","password");
        }
    });
    
});