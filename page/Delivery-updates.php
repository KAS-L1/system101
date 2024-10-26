
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/delivery-updates/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/delivery-updates/", $_GET["page"]));
    }
} else {
    include('page/delivery-updates/Main.php');
}

?>

