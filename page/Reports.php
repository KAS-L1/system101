
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/reports/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/reports/", $_GET["page"]));    
        }
        
    }else{
        include('page/reports/Main.php');
    }
    
?>

