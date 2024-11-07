
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/predictive-analytics/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/predictive-analytics/", $_GET["page"]));
    }
} else {
    include('page/predictive-analytics/Main.php');
}

?>

