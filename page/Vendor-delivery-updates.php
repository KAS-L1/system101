
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/vendor-delivery-updates/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/vendor-delivery-updates/", $_GET["page"]));
    }
} else {
    include('page/vendor-delivery-updates/Main.php');
}

?>

