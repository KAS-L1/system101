
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/kitchen-order/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/kitchen-order/", $_GET["page"]));
    }
} else {
    include('page/kitchen-order/Main.php');
}

?>

