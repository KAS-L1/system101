<?php
include_once('../../app/init.php');

$id = $_POST['id'] ?? null;
if (!$id) {
    echo "ID is missing.";
    exit;
}

// Retrieve the food cost item details from the database
$item = $DB->SELECT_ONE_WHERE("food_costing", "*", ["id" => $id]);
if (!$item) {
    echo "Item not found.";
    exit;
}

// Decode JSON-encoded `ingredients` and `cost_per_ingredient` fields
$ingredientsArray = json_decode($item['ingredients'], true);
$costPerIngredientArray = json_decode($item['cost_per_ingredient'], true);

// Check if decoding was successful, otherwise use an empty array
$ingredientsArray = is_array($ingredientsArray) ? $ingredientsArray : [];
$costPerIngredientArray = is_array($costPerIngredientArray) ? $costPerIngredientArray : [];

// Convert arrays to comma-separated strings for display
$ingredients = implode(", ", $ingredientsArray);
$costPerIngredient = implode(", ", array_map(fn($cost) => number_format($cost, 2), $costPerIngredientArray));

echo "
<div class='modal fade' id='viewFoodCostItemModal' tabindex='-1' aria-labelledby='viewFoodCostItemModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg modal-dialog-centered'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='viewFoodCostItemModalLabel'>Food Cost Item Details</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <p><strong>Menu Item:</strong> " . htmlspecialchars($item['menu_item']) . "</p>
                <p><strong>Ingredients:</strong> " . htmlspecialchars($ingredients) . "</p>
                <p><strong>Cost per Ingredient:</strong> " . htmlspecialchars($costPerIngredient) . "</p>
                <p><strong>Total Ingredient Cost:</strong> " . NUMBER_PHP_2($item['total_ingredient_cost'], 2) . "</p>
                <p><strong>Selling Price:</strong> " . NUMBER_PHP_2($item['selling_price'], 2) . "</p>
                <p><strong>Profit Margin:</strong> " . NUMBER_PHP_2($item['profit_margin'], 2) . "</p>
                <p><strong>Food Cost %:</strong> " . number_format($item['food_cost_percentage'], 2) . "%</p>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>";
