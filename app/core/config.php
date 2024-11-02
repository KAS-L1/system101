<?php

/**
 * CONSTANT GLOBAL CONFIG VARIALBE
 **/

// ROOTH PATH
define("ROOT", "https://" . $_SERVER["SERVER_NAME"]);

// DATE TIMEZONE
date_default_timezone_set("Asia/Manila");
define("DATE", date("Y-m-d"));
define("TIME", date("H:i:s"));
define("DATE_TIME", date("Y-m-d H:i:s"));




require("settings.php");
require("token.php");
