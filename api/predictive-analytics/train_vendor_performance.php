<?php

require __DIR__ . '../../vendor/autoload.php';

use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Kernels\Distance\Euclidean;
use Rubix\ML\Serializers\Native;

$samples = [
    [85, 90, 80],
    [60, 70, 75],
    [95, 85, 88],
    [70, 65, 80],
    [88, 95, 90],
    [55, 60, 65],
    [78, 80, 70],
    [66, 72, 68],
    [90, 88, 85],
    [58, 60, 62],
];

$labels = ['high', 'low', 'high', 'low', 'high', 'low', 'high', 'low', 'high', 'low'];


// Prepare the dataset
$dataset = new Labeled($samples, $labels);

// Initialize the k-NN model
$estimator = new KNearestNeighbors(3, true, new Euclidean());

// Train the model
$estimator->train($dataset);

// Manually serialize the model using the Native serializer
$serializer = new Native();
$modelFilePath = __DIR__ . '/vendor_performance_model.rbx';

file_put_contents($modelFilePath, $serializer->serialize($estimator));

echo "Model trained and saved as vendor_performance_model.rbx";
