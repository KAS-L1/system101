<?php
session_start();

require("core/config.php");

require("core/database.php");

require("core/functions.php");

require("core/components.php");

require("core/utils.php");

require_once('core/token.php');

// DB Instance
$DB = new Database();

// die("
//   <div style='text-align: center;'>
//     <h1 style='font-size: 50px;'>Kupal Naka Maintenance</h1>
//     <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTBuxUOcfaNIa_PZ2zgpCjwtS6ziiwb0tAZJg&s' style='width: 400px; height: auto;'>
//   </div>
// ");
