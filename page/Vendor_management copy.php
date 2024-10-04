
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/vendor-management/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/vendor-management/", $_GET["page"]));    
        }
        
    }else{
        include('page/vendor-management/Main.php');
    }
    
?>

