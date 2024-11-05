<?php
require("../../app/init.php");

// Retrieve search and filter criteria
$searchTerm = isset($_POST['search']) ? $DB->ESCAPE($_POST['search']) : '';
$filterStatus = isset($_POST['status']) ? $DB->ESCAPE($_POST['status']) : '';
$filterPriority = isset($_POST['priority']) ? $DB->ESCAPE($_POST['priority']) : '';

// Build the SQL query with conditions based on provided filters
$query = "SELECT * FROM document_tracking WHERE 1=1";
$params = [];

// Add search term filter (search in name, ID, or tags)
if ($searchTerm) {
    $query .= " AND (document_name LIKE ? OR tags LIKE ?)";
    $params[] = "%" . $searchTerm . "%";
    $params[] = "%" . $searchTerm . "%";
}

// Add status filter
if ($filterStatus) {
    $query .= " AND status = ?";
    $params[] = $filterStatus;
}

// Add priority filter
if ($filterPriority) {
    $query .= " AND priority = ?";
    $params[] = $filterPriority;
}

$query .= " ORDER BY document_id DESC";

// Execute the query
$documents = $DB->SELECT($query, "*", "", $params);

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($documents);
exit;
