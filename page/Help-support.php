
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/help-support/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/help-support/", $_GET["page"]));
    }
} else {
    include('page/help-support/Main.php');
}

?>

