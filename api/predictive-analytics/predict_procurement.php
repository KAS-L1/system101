<?php

require __DIR__ . '../../vendor/autoload.php';


use Rubix\ML\Datasets\Unlabeled;

// Load the serialized model from the file
try {
    $modelData = file_get_contents(__DIR__ . '/procurement_model.rbx');
    $model = unserialize($modelData); // Use PHP's unserialize to restore the model
} catch (Exception $e) {
    // Handle error if model fails to load
    http_response_code(500);
    echo json_encode(["error" => "Failed to load model: " . $e->getMessage()]);
    exit;
}

// Predict demand for the next period
$samples = [[6]]; // New time period (e.g., the next month or week)
$dataset = new Unlabeled($samples);
$predictions = $model->predict($dataset);

// Sample output for procurement prediction
header('Content-Type: application/json');
echo json_encode([
    "periods" => ["Month 1", "Month 2", "Month 3"], // Example time periods
    "predictions" => [100, 150, 200] // Example demand predictions
]);
