<?php
require("../../app/init.php");

/**
 * DATABASE CONNECTION AND SERVICES INSTANCE
 **/

// Count requisitions per month
$query_months = "MONTH(requested_date) AS month, COUNT(*) AS total";
$months_data = $DB->SELECT('purchaserequisition', $query_months, 'WHERE requested_date IS NOT NULL GROUP BY MONTH(requested_date)');

// Prepare the months and totals arrays
$months = [];
$totals = [];

foreach ($months_data as $row) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); // Convert month number to month name
    $totals[] = $row['total'];
}

// Count requisitions per department
$query_departments = "department, COUNT(*) AS total";
$departments_data = $DB->SELECT('purchaserequisition', $query_departments, 'WHERE department IS NOT NULL GROUP BY department');

// Prepare departments and totals arrays
$departments = [];
$department_totals = [];

foreach ($departments_data as $row) {
    $departments[] = $row['department'];
    $department_totals[] = $row['total'];
}

// Count requisitions by priority
$query_priority = "priority_level, COUNT(*) AS total";
$priority_data = $DB->SELECT('purchaserequisition', $query_priority, 'WHERE priority_level IS NOT NULL GROUP BY priority_level');

// Prepare priorities and totals arrays
$priorities = [];
$priority_totals = [];

foreach ($priority_data as $row) {
    $priorities[] = $row['priority_level'];
    $priority_totals[] = $row['total'];
}

// Set the Content-Type header for JSON response
header('Content-Type: application/json');

// Create the response array with the data
$response = [
    'sales' => $totals, // Data for Bar Chart (Requisitions by Month)
    'visitors' => $department_totals, // Data for Line Chart (Requisitions by Department)
    'products' => $priority_totals, // Data for Pie Chart (Requisitions by Priority)
    'months' => $months, // Month names for Bar Chart
    'departments' => $departments, // Departments for Line Chart
    'priorities' => $priorities // Priorities for Pie Chart
];

// Output the JSON response
echo json_encode($response);
