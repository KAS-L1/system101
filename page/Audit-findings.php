
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/audit-findings/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/audit-findings/", $_GET["page"]));
    }
} else {
    include('page/audit-findings/Main.php');
}

?>

