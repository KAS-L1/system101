
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/vendor-delivery-updates/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/vendor-delivery-updates/", $_GET["page"]));
    }
} else {
    include('pagevendor-/vendor-delivery-updates/Main.php');
}

?>

