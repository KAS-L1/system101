
<?php

    if(isset($_GET["page"])){
        
        if(VIEW("page/suppliers/", $_GET["page"]) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/suppliers/", $_GET["page"]));    
        }
        
    }else{
        include('page/suppliers/Main.php');
    }
    
?>

