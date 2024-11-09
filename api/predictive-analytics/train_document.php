<?php

require __DIR__ . '../../vendor/autoload.php';

use Rubix\ML\Regressors\RegressionTree;
use Rubix\ML\Datasets\Labeled;

// For Document Processing Time Prediction
$samples = [[1, 20, 101], [2, 35, 102], [1, 25, 103], [3, 15, 104], [2, 40, 101], [1, 30, 102], [3, 10, 103], [2, 50, 104], [1, 28, 101], [3, 12, 102]];
$labels = [3, 5, 4, 2, 6, 4, 1.5, 7, 3.5, 2];


$dataset = new Labeled($samples, $labels);

// Initialize and train the model
$model = new RegressionTree();
$model->train($dataset);

// Serialize the model using PHP's serialize function
$modelData = serialize($model);

// Save the serialized model to a file
file_put_contents(__DIR__ . '/document_model.rbx', $modelData);

echo "Document processing time model trained and saved.";
