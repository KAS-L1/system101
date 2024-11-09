<?php

require __DIR__ . '../../vendor/autoload.php';

use Rubix\ML\Classifiers\GaussianNB;
use Rubix\ML\Datasets\Labeled;

// Sample data (indicators and labels)// For Audit Management Non-Compliance Prediction
$samples = [[2, 6, 50], [5, 3, 120], [3, 4, 80], [6, 2, 150], [1, 6, 60], [4, 3, 100], [2, 5, 90], [7, 2, 140], [3, 4, 110], [5, 3, 130]];
$labels = ['compliant', 'non-compliant', 'compliant', 'non-compliant', 'compliant', 'non-compliant', 'compliant', 'non-compliant', 'compliant', 'non-compliant'];

$dataset = new Labeled($samples, $labels);

// Initialize and train the model
$model = new GaussianNB();
$model->train($dataset);

// Serialize the model using PHP's serialize function
$modelData = serialize($model);

// Save the serialized model to a file
file_put_contents(__DIR__ . '/audit_model.rbx', $modelData);

echo "Audit non-compliance risk model trained and saved.";
