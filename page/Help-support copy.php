
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/vendor-help-support/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/vendor-help-support/", $_GET["page"]));
    }
} else {
    include('page/vendor-help-support/Main.php');
}

?>

