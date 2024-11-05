<?php
require("../../app/init.php");

// Initialize the database object
$DB = new Database();

// Retrieve search and filter criteria
$searchTerm = isset($_POST['search']) ? $DB->ESCAPE($_POST['search']) : '';
$filterStatus = isset($_POST['status']) ? $DB->ESCAPE($_POST['status']) : '';
$filterPriority = isset($_POST['priority']) ? $DB->ESCAPE($_POST['priority']) : '';

// Build SQL conditions based on provided filters
$options = "WHERE 1=1";
$params = [];

// Add search term filter (search in name or tags)
if ($searchTerm) {
    $options .= " AND (document_name LIKE ? OR tags LIKE ?)";
    $params[] = "%" . $searchTerm . "%";
    $params[] = "%" . $searchTerm . "%";
}

// Add status filter if provided
if ($filterStatus) {
    $options .= " AND status = ?";
    $params[] = $filterStatus;
}

// Add priority filter if provided
if ($filterPriority) {
    $options .= " AND priority = ?";
    $params[] = $filterPriority;
}

// Order by document_id in descending order
$options .= " ORDER BY document_id DESC";

// Execute the SELECT query using the Database class's method
$documents = $DB->SELECT("document_tracking", "*", $options, $params);

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($documents);
exit;
