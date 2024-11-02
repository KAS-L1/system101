<?php

/**
 * MAIN APP FUNCTIONS
 **/

// Function to get the URL index
// This function takes an optional index parameter (default is 0) and returns the corresponding part of the URL
function GET($index = 0)
{
    // Get the URL from the $_GET superglobal array, defaulting to "index" if not set
    $url = $_GET["url"] ?? "index";

    // Sanitize the URL to prevent potential security vulnerabilities
    $url = filter_var($url, FILTER_SANITIZE_URL);

    // Split the URL into an array using the "/" character as the delimiter
    $arr = explode("/", $url);

    // Return the part of the URL at the specified index
    return $arr[$index];
}

// Function to view page content
// This function takes a path and a page name as parameters and returns the path to the corresponding PHP file
// function VIEW($path, $page){
//     // Capitalize the first letter of the page name and append ".php" to it
//     $page = ucfirst($page).".php";

//     // Check if the file exists at the specified path
//     if(file_exists($path."".$page)){
//         // If the file exists, return the full path to the file
//         return($path."".$page);
//     }else{
//         // If the file does not exist, return "404" (indicating a 404 Not Found error)
//         return "404";
//     }
// }

function VIEW($path, $page)
{
    // Ensure the path ends with a slash
    if (substr($path, -1) !== '/') {
        $path .= '/';
    }

    // Capitalize the first letter of the page name and append ".php" to it
    $page = ucfirst($page) . ".php";

    // Check if the file exists at the specified path
    if (file_exists($path . $page)) {
        // If the file exists, return the full path to the file
        return $path . $page;
    } else {
        // If the file does not exist, return "404"
        return "404";
    }
}
