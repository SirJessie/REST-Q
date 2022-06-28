$(document).ready(function () {
    $("#target input").keyup(function(event) {
        if ($(this).val().length == 1) {
            $(this).nextAll('input').first().focus();
        } else if ($(this).val().length > 1) {
            var new_val = $(this).val().substring(1, 2);
            $(this).val(new_val);
            $(this).nextAll('input').first().focus();
        } else if (event.keyCode == 8) {
            if ($(this).prev('input')) {
                $(this).prev('input').focus();
            }
        }
    });
})