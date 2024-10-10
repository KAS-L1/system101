<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/vendor-request-for-qoute/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/vendor-request-for-qoute/", $_GET["page"]));    
        }
        
    }else{
        include('page/vendor-request-for-qoute/Main.php');
    }
    
?>