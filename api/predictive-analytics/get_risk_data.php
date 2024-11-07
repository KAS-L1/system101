<?php
require("../../app/init.php");

$query_risk_prediction = "severity, COUNT(risk) AS count";
$risk_data = $DB->SELECT('compliance_risks', $query_risk_prediction, 'GROUP BY severity');

$data = [];
foreach ($risk_data as $row) {
    $data[] = [
        'severity' => $row['severity'],
        'count' => $row['count']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
