<?php

require __DIR__ . '../../vendor/autoload.php';

use Rubix\ML\Datasets\Unlabeled;

// Load the serialized model from the file
try {
    $modelData = file_get_contents(__DIR__ . '/audit_model.rbx');
    if ($modelData === false) {
        throw new Exception("Failed to read the model file.");
    }

    $model = unserialize($modelData);
    if (!$model) {
        throw new Exception("Failed to unserialize the model.");
    }
} catch (Exception $e) {
    // Handle error if model fails to load
    http_response_code(500);
    echo json_encode(["error" => "Failed to load model: " . $e->getMessage()]);
    exit;
}

// Sample data for prediction
$samples = [[2, 6]]; // Example indicators for a new audit

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

// Sample output for audit compliance prediction
header('Content-Type: application/json');
echo json_encode([
    "compliance" => [
        ["name" => "Compliant", "y" => 70],
        ["name" => "Non-Compliant", "y" => 30]
    ]
]);
