<?php
if(isset($_POST['CallFunction'])){
    include "GenerateFunctions.php";
    if($_POST['CallFunction'] == "GenerateUserID"){
        echo GenerateUserID();
    }else if($_POST['CallFunction'] == "GeneratePatientID"){
        echo GeneratePatientID();
    }else if($_POST['CallFunction'] == "DefaultWebPassword"){
        echo DefaultWebPassword();
    }else if($_POST['CallFunction'] == "DefaultAppPassword"){
        echo DefaultAppPassword();
    }
}
?>