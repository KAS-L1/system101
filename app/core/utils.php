<?php

/**
 * USEFUL UTILITIES FUNCTIONS
**/

function pre($data){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function pre_die($data){
    echo "<pre>";
    die(print_r($data));
    echo "</pre>";
}

function CHARS($string){
    return htmlspecialchars($string);
}

function LOWER_CASE($string){
    return strtolower($string);
}

function UPPER_CASE($string){
    return strtoupper($string);
}

function SANITIZE_STRING($data){
	return filter_var($data, FILTER_SANITIZE_STRING);
}

function SANITIZE_EMAIL($data){
	return filter_var($data, FILTER_VALIDATE_EMAIL);
}

function SANITIZE_URL($data){
	return filter_var($data, FILTER_SANITIZE_URL);
}

function EXPLOAD($data){
	return explode(",", $data);
}

function SLUG_URL($string){
   $slug = preg_replace("/[^A-Za-z0-9-]+/", "-", $string);
   return $slug;
}

function SLUG_NOSPACE($string){
   $slug = preg_replace("/[^A-Za-z0-9]+/", "", $string);
   return $slug;
}

function NUMBER($int){
    return number_format($int);
}

function NUMBER_2($int){
    return number_format($int, 2);
}

function NUMBER_PHP($int){
    return '₱'.number_format($int);
}

function NUMBER_PHP_2($int){
    return '₱'.number_format($int, 2);
}

function FORMAT_DATE($date, $format){
    return date_format(date_create($date), $format);
}

function DATE_SHORT($date){
    return date_format(date_create($date),"M d, Y");
}

function DATE_SHORT_TIME($date){
    return date_format(date_create($date),"M d, Y h:i A");
}

function DATE_MDY($date){
    return date_format(date_create($date),"M d, Y");
}

function DATE_MDY_TIME($date){
    return date_format(date_create($date),"M d, Y h:i A");
}

function DATE_FDY_TIME($date){
    return date_format(date_create($date),"F d, Y h:i A");
}

function DATE_UPDATED($date){
    return $date == null ? "-" : date_format(date_create($date),"M d, Y h:i A");
}

function DATE_TIME_UPDATED($date){
    return $date == null ? "-" : date_format(date_create($date),"M d, Y h:i A");
}

// OTHER
function get_address_area($url, $column = null){
    $data_url = file_get_contents($url);
    $data_raw = json_decode($data_url, true);
    if($column != null){
        foreach($data_raw as $data) {
            $data_array[] = $data[$column];
        }
        return array_unique($data_array);
    }else{
        return $data_raw;
    }
    
}
