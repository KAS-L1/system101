<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/profile-setting/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/profile=setting", $_GET["page"]));    
        }
        
    }else{
        include('page/profile-setting/Main.php');
    }
    
?>