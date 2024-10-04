
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/request-for-qoute/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/request-for-qoute/", $_GET["page"]));    
        }
        
    }else{
        include('page/request-for-qoute/Main.php');
    }
    
?>

