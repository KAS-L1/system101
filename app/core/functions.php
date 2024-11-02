<?php

/**
 * MAIN APP FUNCTIONS
 **/

/**
 * Retrieves a specific part of the URL based on the provided index.
 *
 * This function fetches the "url" parameter from the $_GET superglobal array,
 * splits it by "/" to create an array, and returns the part of the URL at the specified index.
 * 
 * @param int $index The index of the URL segment to retrieve. Default is 0.
 * @return string The part of the URL at the specified index.
 */
function GET($index = 0)
{
    // Get the URL from the $_GET superglobal array, defaulting to "index" if not set
    $url = $_GET["url"] ?? "index";

    // Sanitize the URL to prevent potential security vulnerabilities
    $url = filter_var($url, FILTER_SANITIZE_URL);

    // Split the URL into an array using the "/" character as the delimiter
    $arr = explode("/", $url);

    // Return the part of the URL at the specified index, or an empty string if the index is out of bounds
    return $arr[$index] ?? "";
}

/**
 * Constructs the file path to a specific page.
 *
 * This function takes a path and a page name, checks if the page exists in the given path,
 * and returns the full path if it exists or "404" if it doesn't.
 *
 * @param string $path The directory path where the page files are located.
 * @param string $page The name of the page (without the ".php" extension).
 * @return string The full path to the file if it exists; otherwise, "404".
 */
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
