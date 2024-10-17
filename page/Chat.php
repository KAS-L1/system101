
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/chat/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/chat/", $_GET["page"]));
    }
} else {
    include('page/chat/Main.php');
}

?>

