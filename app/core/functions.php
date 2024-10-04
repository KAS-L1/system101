<?php

/**
 * MAIN APP FUNCTIONS
**/

// GET PAGE URL INDEX
function GET($index = 0){
	$url = $_GET["url"] ?? "index";
	$url = filter_var($url, FILTER_SANITIZE_URL);
	$arr = explode("/", $url);
	return $arr[$index];
}

// VIEW PAGE CONTENT
function VIEW($path, $page){
	$page = ucfirst($page).".php";
	if(file_exists($path."".$page)){
		return($path."".$page);
	}else{
		return "404";
	}
}




