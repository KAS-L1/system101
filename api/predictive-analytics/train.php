    <?php

    require __DIR__ . '../../vendor/autoload.php';

    use Rubix\ML\Classifiers\KNearestNeighbors;
    use Rubix\ML\Datasets\Labeled;

    // Sample training dataset (replace with your actual data)
    $samples = [
        [5.1, 3.5, 1.4, 0.2],
        [4.9, 3.0, 1.4, 0.2],
        [6.2, 3.4, 5.4, 2.3],
        [5.9, 3.0, 5.1, 1.8],
    ];
    $labels = ['setosa', 'setosa', 'virginica', 'virginica'];

    $dataset = new Labeled($samples, $labels);

    // Initialize the model
    $estimator = new KNearestNeighbors(3);

    // Train the model
    $estimator->train($dataset);

    // Serialize the model using PHP's serialize
    $modelData = serialize($estimator);

    // Save the serialized model to a file
    file_put_contents(__DIR__ . '/model.rbx', $modelData);

    echo "Model trained and saved as model.rbx";
