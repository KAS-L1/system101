
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/purchase-orders/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/purchase-orders/", $_GET["page"]));    
        }
        
    }else{
        include('page/purchase-orders/Main.php');
    }
    
?>

