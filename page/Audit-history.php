
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/audit-history/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/audit-history/", $_GET["page"]));
    }
} else {
    include('page/audit-history/Main.php');
}

?>

