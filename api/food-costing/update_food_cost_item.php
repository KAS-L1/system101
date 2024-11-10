<?php
require("../../app/init.php");

$id = $_POST['id'];
$menu_item = $_POST['menu_item'];
$ingredients = json_encode(explode(",", $_POST['ingredients']));
$cost_per_ingredient = json_encode(array_map('floatval', explode(",", $_POST['cost_per_ingredient'])));
$selling_price = floatval($_POST['selling_price']);

// Recalculate total ingredient cost
$total_ingredient_cost = array_sum(json_decode($cost_per_ingredient, true));

$data = array(
    "menu_item" => $menu_item,
    "ingredients" => $ingredients,
    "cost_per_ingredient" => $cost_per_ingredient,
    "total_ingredient_cost" => $total_ingredient_cost,
    "selling_price" => $selling_price
    // Exclude "profit_margin" and "food_cost_percentage" as they are generated
);

$where = array("id" => $id);
$update = $DB->UPDATE("food_costing", $data, $where);
if ($update == "success") {
    swalAlert('success', 'Food costing item updated successfully.');
    refreshUrlTimeout(2000);
} else {
    swalAlert('error', 'Failed to update food costing item.');
}
