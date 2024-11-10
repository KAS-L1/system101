
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/menu-management/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/menu-management/", $_GET["page"]));
    }
} else {
    include('page/menu-management/Main.php');
}

?>

