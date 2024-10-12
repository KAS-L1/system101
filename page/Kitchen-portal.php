
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/kitchen-portal/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/kitchen-portal/", $_GET["page"]));    
        }
        
    }else{
        include('page/kitchen-portal/Main.php');
    }
    
?>

