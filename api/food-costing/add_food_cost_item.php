<?php
require("../../app/init.php");

$menu_item = $_POST['menu_item'];
$ingredients = json_encode(explode(",", $_POST['ingredients']));
$cost_per_ingredient = json_encode(array_map('floatval', explode(",", $_POST['cost_per_ingredient'])));
$selling_price = floatval($_POST['selling_price']);

// Calculate total ingredient cost
$total_ingredient_cost = array_sum(json_decode($cost_per_ingredient, true));

$data = array(
    "menu_item" => $menu_item,
    "ingredients" => $ingredients,
    "cost_per_ingredient" => $cost_per_ingredient,
    "total_ingredient_cost" => $total_ingredient_cost,
    "selling_price" => $selling_price
    // Exclude "profit_margin" and "food_cost_percentage" as they are generated
);

$insert = $DB->INSERT("food_costing", $data);
if ($insert == "success") {
    swalAlert('success', 'New food costing item added successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to add food costing item.');
}
