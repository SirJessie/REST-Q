<?php

    if(isset($_POST['btnCSV'])){
        $txt_search = $_POST['htxtSearch'];

        if(!empty($txt_search)){
            echo "not empty";
        }else{
            echo "empty";
        }
    }else if(isset($_POST['btnExcel'])){
        $txt_search = $_POST['htxtSearch'];

        if(!empty($txt_search)){
            echo "not empty";
        }else{
            echo "empty";
        }
    }

?>