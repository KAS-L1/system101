<?php
session_start();

setcookie("_usertoken", "", time()-1, "/");
session_destroy();

die(header("Location: ../../login?res=logout"));

