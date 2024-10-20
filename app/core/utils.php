<?php

/**
 * USEFUL UTILITIES FUNCTIONS
 **/

// Function to print data in a readable format
function pre($data)
{
    // Start a preformatted text block
    echo "<pre>";
    // Print the data using print_r
    print_r($data);
    // End the preformatted text block
    echo "</pre>";
}

// Function to print data in a readable format and exit the script
function pre_die($data)
{
    // Start a preformatted text block
    echo "<pre>";
    // Print the data using print_r and exit the script
    die(print_r($data));
    // End the preformatted text block (this will not be executed due to the die statement)
    echo "</pre>";
}

// Function to escape special characters in a string
function CHARS($string)
{
    // Ensure the input is a string; if not, default to an empty string
    return htmlspecialchars($string ?? '');
}


// Function to convert a string to lowercase
function LOWER_CASE($string)
{
    // Use strtolower to convert the string to lowercase
    return strtolower($string);
}

// Function to convert a string to uppercase
function UPPER_CASE($string)
{
    // Use strtoupper to convert the string to uppercase
    return strtoupper($string);
}

// Function to sanitize a string
function SANITIZE_STRING($data)
{
    // Use filter_var with FILTER_SANITIZE_STRING to sanitize the string
    return filter_var($data, FILTER_SANITIZE_STRING);
}

// Function to validate an email address
function SANITIZE_EMAIL($data)
{
    // Use filter_var with FILTER_VALIDATE_EMAIL to validate the email address
    return filter_var($data, FILTER_VALIDATE_EMAIL);
}

// Function to sanitize a URL
function SANITIZE_URL($data)
{
    // Use filter_var with FILTER_SANITIZE_URL to sanitize the URL
    return filter_var($data, FILTER_SANITIZE_URL);
}

// Function to explode a string into an array
function EXPLOAD($data)
{
    // Use explode to split the string into an array
    return explode(",", $data);
}

// Function to create a slug from a string
function SLUG_URL($string)
{
    // Use preg_replace to replace non-alphanumeric characters with a hyphen
    $slug = preg_replace("/[^A-Za-z0-9-]+/", "-", $string);
    return $slug;
}

// Function to create a slug from a string without spaces
function SLUG_NOSPACE($string)
{
    // Use preg_replace to replace non-alphanumeric characters with an empty string
    $slug = preg_replace("/[^A-Za-z0-9]+/", "", $string);
    return $slug;
}

// Function to format a number
function NUMBER($int)
{
    // Use number_format to format the number
    return number_format($int);
}

// Function to format a number with two decimal places
function NUMBER_2($int)
{
    // Use number_format with two decimal places to format the number
    return number_format($int, 2);
}

// Function to format a number with a PHP currency symbol
function NUMBER_PHP($int)
{
    // Use number_format to format the number and append the PHP currency symbol
    return '₱' . number_format($int);
}

// Function to format a number with two decimal places and a PHP currency symbol
function NUMBER_PHP_2($int)
{
    // Use number_format with two decimal places to format the number and append the PHP currency symbol
    return '₱' . number_format($int, 2);
}

// Function to format a date
function FORMAT_DATE($date, $format)
{
    // Use date_format to format the date
    return date_format(date_create($date), $format);
}

// Function to format a date in a short format
function DATE_SHORT($date)
{
    // Use date_format to format the date in a short format
    return date_format(date_create($date), "M d, Y");
}

// Function to format a date in a short format with time
function DATE_SHORT_TIME($date)
{
    // Use date_format to format the date in a short format with time
    return date_format(date_create($date), "M d, Y h:i A");
}

// Function to format a date in a medium format
function DATE_MDY($date)
{
    // Use date_format to format the date in a medium format
    return date_format(date_create($date), "M d, Y");
}

// Function to format a date in a medium format with time
function DATE_MDY_TIME($date)
{
    // Use date_format to format the date in a medium format with time
    return date_format(date_create($date), "M d, Y h:i A");
}

// Function to format a date in a full format with time
function DATE_FDY_TIME($date)
{
    // Use date_format to format the date in a full format with time
    return date_format(date_create($date), "F d, Y h:i A");
}

// Function to format a date with a default value if the date is null
function DATE_UPDATED($date)
{
    // Check if the date is null
    return $date == null ? "-" : date_format(date_create($date), "M d, Y h:i A");
}

// Function to format a date with a default value if the date is null
function DATE_TIME_UPDATED($date)
{
    // Check if the date is null
    return $date == null ? "-" : date_format(date_create($date), "M d, Y h:i A");
}

// Function to get address area data from a URL
function get_address_area($url, $column = null)
{
    // Get the contents of the URL
    $data_url = file_get_contents($url);
    // Decode the JSON data
    $data_raw = json_decode($data_url, true);
    // Check if a column is specified
    if ($column != null) {
        // Loop through the data and extract the specified column
        foreach ($data_raw as $data) {
            $data_array[] = $data[$column];
        }
        // Return the unique values in the extracted column
        return array_unique($data_array);
    } else {
        // Return the raw data
        return $data_raw;
    }
}

// Generate a CSRF token and store it in the session
function generate_csrf_token()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Start session if not already started
    }

    // Generate a token if it doesn't exist
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Validate the CSRF token from the form with the one stored in the session
function validate_csrf_token($token)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the token is set and matches the stored token
    return isset($token) && hash_equals($_SESSION['csrf_token'], $token);
}
