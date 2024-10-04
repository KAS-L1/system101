
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/purchase-requistion/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/purchase-requistion/", $_GET["page"]));    
        }
        
    }else{
        include('page/purchase-requistion/Main.php');
    }
    
?>

