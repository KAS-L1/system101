
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/budget-approval/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/budget-approval/", $_GET["page"]));    
        }
        
    }else{
        include('page/budget-approval/Main.php');
    }
    
?>

