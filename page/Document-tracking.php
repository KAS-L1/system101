
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/document-tracking/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/document-tracking/", $_GET["page"]));
    }
} else {
    include('page/document-tracking/Main.php');
}

?>

