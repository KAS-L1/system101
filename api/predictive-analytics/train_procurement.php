<?php

require __DIR__ . '../../vendor/autoload.php';

use Rubix\ML\Regressors\Ridge;
use Rubix\ML\Datasets\Labeled;

$samples = [[1], [2], [3], [4], [5], [6], [7], [8], [9], [10], [11], [12]]; // Month
$labels = [120, 150, 170, 200, 230, 210, 250, 280, 260, 300, 320, 310]; // Demand

$dataset = new Labeled($samples, $labels);

// Initialize and train the model
$model = new Ridge();
$model->train($dataset);

// Serialize the model using PHP's serialize function
$modelData = serialize($model);

// Save the serialized model to a file
file_put_contents(__DIR__ . '/procurement_model.rbx', $modelData);

echo "Procurement demand forecasting model trained and saved.";
