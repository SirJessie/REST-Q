$(document).ready(function() {
    //Table
    $('#data-table').DataTable();

    //Button settings display
    $("#dropdownSettings").on('click',function(){
        $("#dropdown-setting").toggle("d-block");
    });

    $("#btnNotifs").on('click', function(){
        $.ajax({
            url : 'php/Notifications.php',
			method : 'post',
			data : { Data : 'PopulateNotifs', Brgy : $("#BrgyValue").text()},
			cache : false,
			success : function(data){
				$("#dropdownNotifs").html(data);
			}
        })
    }); 
    $("#btnSideNotifs").on('click', function(){
        $.ajax({
            url : 'php/Notifications.php',
			method : 'post',
			data : { Data : 'PopulateNotifs', Brgy : $("#BrgyValue").text()},
			cache : false,
			success : function(data){
				$("#dropdownSideNotifs").html(data);
			}
        })
    });

    
    $(window).scroll(function(){
        if($(window).scrollTop() >= 30){
            $("#actionContainer").addClass("topActionContainer");
            $("#actionMainContainer").addClass("maxHeight");
        }else{
            $("#actionContainer").removeClass("topActionContainer");
            $("#actionMainContainer").removeClass("maxHeight");
            
        }
    });
});