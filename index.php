<?php require("app/init.php") ?>
<?php require("api/auth/auth.php") ?>

<?php $PAGE = GET(0) ?>


<?php include("page/_inc/Header.php") ?>


<?php
    
    if($PAGE != "index"){
        
        if(VIEW("page/", $PAGE) == "404"){
            include("page/404.php");
        }else{
            include(VIEW("page/", $PAGE));    
        }
        
    }else{
        include('page/Dashboard.php');
    }

?>



<?php include("page/_inc/Footer.php") ?>