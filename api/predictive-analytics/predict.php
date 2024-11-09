<?php

require __DIR__ . '../../vendor/autoload.php';

use Rubix\ML\Datasets\Unlabeled; // Import the Unlabeled dataset type

// Load the serialized model from the file
try {
    $modelData = file_get_contents(__DIR__ . '/model.rbx');
    $model = unserialize($modelData); // Use PHP's unserialize to restore the model
} catch (Exception $e) {
    // Handle error if model fails to load
    http_response_code(500);
    echo json_encode(["error" => "Failed to load model: " . $e->getMessage()]);
    exit;
}

// Sample data for prediction
$samples = [
    [6.5, 3.0, 5.2, 2.0],
    [5.1, 3.5, 1.4, 0.2],
    [6.3, 3.3, 6.0, 2.5]
];


// Wrap the samples in an Unlabeled dataset
$dataset = new Unlabeled($samples);

// Perform prediction
try {
    $predictions = $model->predict($dataset); // Pass the dataset, not the raw array
} catch (Exception $e) {
    // Handle error if prediction fails
    http_response_code(500);
    echo json_encode(["error" => "Prediction failed: " . $e->getMessage()]);
    exit;
}

// Output the prediction as JSON
header('Content-Type: application/json');
echo json_encode($predictions);
