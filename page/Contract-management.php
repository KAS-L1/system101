
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/contract-management/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/contract-management/", $_GET["page"]));    
        }
        
    }else{
        include('page/contract-management/Main.php');
    }
    
?>

