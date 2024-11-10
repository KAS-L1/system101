<?php
require_once '../../app/init.php';

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

// Ensure that the arrays are decoded correctly
$ingredientsArray = is_array($ingredientsArray) ? $ingredientsArray : [];
$costPerIngredientArray = is_array($costPerIngredientArray) ? $costPerIngredientArray : [];

// Convert arrays to comma-separated strings for form fields
$ingredients = implode(", ", $ingredientsArray);
$costPerIngredient = implode(", ", array_map('floatval', $costPerIngredientArray)); // Formatting as float values

?>

<div class="modal fade" id="editFoodCostItemModal" tabindex="-1" aria-labelledby="editFoodCostItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFoodCostItemModalLabel">Edit Food Cost Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditFoodCostItem">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">

                    <div class="mb-3">
                        <label for="menu_item" class="form-label">Menu Item</label>
                        <input type="text" id="menu_item" name="menu_item" class="form-control" value="<?= htmlspecialchars($item['menu_item']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ingredients" class="form-label">Ingredients</label>
                        <textarea id="ingredients" name="ingredients" class="form-control" rows="2"><?= htmlspecialchars($ingredients) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cost_per_ingredient" class="form-label">Cost per Ingredient</label>
                        <input type="text" id="cost_per_ingredient" name="cost_per_ingredient" class="form-control" value="<?= htmlspecialchars($costPerIngredient) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Selling Price</label>
                        <input type="number" step="0.01" id="selling_price" name="selling_price" class="form-control" value="<?= htmlspecialchars($item['selling_price']) ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formEditFoodCostItem').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post("api/food-costing/update_food_cost_item.php", formData, function(response) {
            $('#responseModal').html(response);
            $('#editFoodCostItemModal').modal('hide');
        });
    });
</script>