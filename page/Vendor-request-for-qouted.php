<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/vendor-request-for-qouted/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/vendor-request-for-qouted/", $_GET["page"]));    
        }
        
    }else{
        include('page/vendor-request-for-qouted/Main.php');
    }
    
?>