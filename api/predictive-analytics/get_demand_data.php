<?php
require("../../app/init.php");

$query_demand_forecast = "MONTH(prediction_date) AS month, ROUND(AVG(predicted_demand), 2) AS avg_demand";
$demand_forecast_data = $DB->SELECT('demand_predictions', $query_demand_forecast, 'GROUP BY MONTH(prediction_date) ORDER BY prediction_date ASC');

$data = [];
foreach ($demand_forecast_data as $row) {
    $data[] = [
        'month' => date('F', mktime(0, 0, 0, $row['month'], 10)),
        'avg_demand' => $row['avg_demand']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
