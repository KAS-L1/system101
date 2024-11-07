<?php
require("../../app/init.php");

$query_doc_time = "document_type, ROUND(AVG(predicted_processing_time), 2) AS avg_time";
$doc_time_data = $DB->SELECT('document_processing_times', $query_doc_time, 'GROUP BY document_type');

$data = [];
foreach ($doc_time_data as $row) {
    $data[] = [
        'document_type' => $row['document_type'],
        'avg_time' => $row['avg_time']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
