
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/vendor-purchase-orders/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/vendor-purchase-orders/", $_GET["page"]));    
        }
        
    }else{
        include('page/vendor-purchase-orders/Main.php');
    }
    
?>

