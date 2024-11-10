
<?php

if (isset($_GET["page"])) {

    if (VIEW("page/food-costing/", $_GET["page"]) == "404") {
        include("page/404.php");
    } else {
        include(VIEW("page/food-costing/", $_GET["page"]));
    }
} else {
    include('page/food-costing/Main.php');
}

?>

