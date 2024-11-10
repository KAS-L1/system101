
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/stock-management/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/stock-management/", $_GET["page"]));
    }
} else {
    include('page/stock-management/Main.php');
}

?>

