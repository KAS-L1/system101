<?php

/**
 * USEFUL UTILITIES FUNCTIONS
 **/

/**
 * Prints data in a readable format for debugging purposes.
 * 
 * @param mixed $data The data to be printed.
 * @return void
 */
function pre($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/**
 * Prints data in a readable format for debugging purposes and stops script execution.
 * 
 * @param mixed $data The data to be printed.
 * @return void
 */
function pre_die($data)
{
    echo "<pre>";
    die(print_r($data, true)); // The 'true' argument ensures data is returned as a string
}

/**
 * Escapes special characters in a string to prevent XSS.
 * 
 * @param string $string The string to escape.
 * @return string The escaped string.
 */
function CHARS($string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Converts a string to lowercase.
 * 
 * @param string $string The string to convert.
 * @return string The lowercase string.
 */
function LOWER_CASE($string)
{
    return strtolower($string);
}

/**
 * Converts a string to uppercase.
 * 
 * @param string $string The string to convert.
 * @return string The uppercase string.
 */
function UPPER_CASE($string)
{
    return strtoupper($string);
}

/**
 * Sanitizes a string by removing harmful characters.
 * 
 * @param string $data The string to sanitize.
 * @return string The sanitized string.
 */
function SANITIZE_STRING($data)
{
    return filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

/**
 * Validates and sanitizes an email address.
 * 
 * @param string $data The email address to validate.
 * @return string|false The sanitized email if valid, otherwise false.
 */
function SANITIZE_EMAIL($data)
{
    return filter_var($data, FILTER_VALIDATE_EMAIL);
}

/**
 * Sanitizes a URL by removing harmful characters.
 * 
 * @param string $data The URL to sanitize.
 * @return string The sanitized URL.
 */
function SANITIZE_URL($data)
{
    return filter_var($data, FILTER_SANITIZE_URL);
}

/**
 * Explodes a comma-separated string into an array.
 * 
 * @param string $data The string to explode.
 * @return array The resulting array.
 */
function EXPLOAD($data)
{
    return explode(",", $data);
}

/**
 * Creates a URL-friendly slug from a string.
 * 
 * @param string $string The string to convert.
 * @return string The resulting slug.
 */
function SLUG_URL($string)
{
    return strtolower(preg_replace("/[^A-Za-z0-9-]+/", "-", $string));
}

/**
 * Creates a slug from a string without spaces.
 * 
 * @param string $string The string to convert.
 * @return string The resulting slug without spaces.
 */
function SLUG_NOSPACE($string)
{
    return preg_replace("/[^A-Za-z0-9]+/", "", $string);
}

/**
 * Formats a number with commas as thousands separators.
 * 
 * @param int|float $int The number to format.
 * @return string The formatted number.
 */
function NUMBER($int)
{
    return number_format($int);
}

/**
 * Formats a number with two decimal places.
 * 
 * @param int|float $int The number to format.
 * @return string The formatted number.
 */
function NUMBER_2($int)
{
    return number_format($int, 2);
}

/**
 * Formats a number with a PHP currency symbol.
 * 
 * @param int|float $int The number to format.
 * @return string The formatted number with currency symbol.
 */
function NUMBER_PHP($int)
{
    return '₱' . number_format($int);
}

/**
 * Formats a number with two decimal places and a PHP currency symbol.
 * 
 * @param int|float $int The number to format.
 * @return string The formatted number with currency symbol and two decimals.
 */
function NUMBER_PHP_2($int)
{
    return '₱' . number_format($int, 2);
}

/**
 * Formats a date according to a specified format.
 * 
 * @param string $date The date string.
 * @param string $format The date format.
 * @return string The formatted date.
 */
function FORMAT_DATE($date, $format)
{
    return date_format(date_create($date), $format);
}

/**
 * Formats a date in a short format.
 * 
 * @param string $date The date string.
 * @return string The formatted date in "M d, Y" format.
 */
function DATE_SHORT($date)
{
    return date_format(date_create($date), "M d, Y");
}

/**
 * Formats a date in a short format with time.
 * 
 * @param string $date The date string.
 * @return string The formatted date in "M d, Y h:i A" format.
 */
function DATE_SHORT_TIME($date)
{
    return date_format(date_create($date), "M d, Y h:i A");
}

/**
 * Formats a date in a medium format (MDY).
 * 
 * @param string $date The date string.
 * @return string The formatted date in "M d, Y" format.
 */
function DATE_MDY($date)
{
    return date_format(date_create($date), "M d, Y");
}

/**
 * Formats a date in a medium format with time (MDY).
 * 
 * @param string $date The date string.
 * @return string The formatted date in "M d, Y h:i A" format.
 */
function DATE_MDY_TIME($date)
{
    return date_format(date_create($date), "M d, Y h:i A");
}

/**
 * Formats a date in a full format with time (FDY).
 * 
 * @param string $date The date string.
 * @return string The formatted date in "F d, Y h:i A" format.
 */
function DATE_FDY_TIME($date)
{
    return date_format(date_create($date), "F d, Y h:i A");
}

/**
 * Formats a date with a default value if the date is null.
 * 
 * @param string|null $date The date string.
 * @return string The formatted date or "-" if null.
 */
function DATE_UPDATED($date)
{
    return $date == null ? "-" : date_format(date_create($date), "M d, Y h:i A");
}

/**
 * Formats a date with a default value if the date is null.
 * 
 * @param string|null $date The date string.
 * @return string The formatted date with time or "-" if null.
 */
function DATE_TIME_UPDATED($date)
{
    return $date == null ? "-" : date_format(date_create($date), "M d, Y h:i A");
}

/**
 * Retrieves data from a JSON URL and optionally extracts a specific column.
 * 
 * @param string $url The URL of the JSON data.
 * @param string|null $column Optional column to extract from each data entry.
 * @return array The retrieved data or extracted column data.
 */
function get_address_area($url, $column = null)
{
    $data_url = file_get_contents($url);
    $data_raw = json_decode($data_url, true);

    if ($column != null) {
        $data_array = [];
        foreach ($data_raw as $data) {
            $data_array[] = $data[$column];
        }
        return array_unique($data_array);
    } else {
        return $data_raw;
    }
}
