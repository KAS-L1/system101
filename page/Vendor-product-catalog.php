
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/vendor-product-catalog/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/vendor-product-catalog/", $_GET["page"]));    
        }
        
    }else{
        include('page/vendor-product-catalog/Main.php');
    }
    
?>

