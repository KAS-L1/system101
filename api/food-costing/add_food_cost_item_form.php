<div class="modal fade" id="addFoodCostItemModal" tabindex="-1" aria-labelledby="addFoodCostItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFoodCostItemModalLabel">Add New Food Cost Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddFoodCostItem">
                    <div class="mb-3">
                        <label for="menu_item" class="form-label">Menu Item</label>
                        <input type="text" id="menu_item" name="menu_item" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="ingredients" class="form-label">Ingredients</label>
                        <textarea id="ingredients" name="ingredients" class="form-control" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cost_per_ingredient" class="form-label">Cost per Ingredient</label>
                        <input type="text" id="cost_per_ingredient" name="cost_per_ingredient" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="selling_price" class="form-label">Selling Price</label>
                        <input type="number" step="0.01" id="selling_price" name="selling_price" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#formAddFoodCostItem').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('api/food-costing/add_food_cost_item.php', formData, function(response) {
            $('#responseModal').html(response);
            $('#addFoodCostItemModal').modal('hide');
        });
    });
</script>