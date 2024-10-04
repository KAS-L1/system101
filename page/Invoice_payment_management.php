
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/invoice-payment-management/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/invoice-payment-management/", $_GET["page"]));    
        }
        
    }else{
        include('page/invoice-payment-management/Main.php');
    }
    
?>

