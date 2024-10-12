<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/vendor-portal/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/vendor-portal/", $_GET["page"]));    
        }
        
    }else{
        include('page/vendor-portal/Main.php');
    }
    