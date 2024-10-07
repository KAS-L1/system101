<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/user-management/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/user-management/", $_GET["page"]));    
        }
        
    }else{
        include('page/user-management/Main.php');
    }
    