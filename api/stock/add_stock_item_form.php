<!-- add_stock_item_form.php -->
<div class="modal fade" id="addStockItemModal" tabindex="-1" aria-labelledby="addStockItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockItemModalLabel">Add New Stock Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAddStockItem">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="Perishable">Perishable</option>
                            <option value="Non-perishable">Non-perishable</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="reorder_level" class="form-label">Reorder Level</label>
                        <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
                    </div>
                    <div class="mb-3">
                        <label for="current_stock_level" class="form-label">Initial Stock Level</label>
                        <input type="number" class="form-control" id="current_stock_level" name="current_stock_level" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Expiration Date (for Perishables)</label>
                        <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Stock Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="responseModal"></div>

<script>
    // Submit Add Stock Item Form
    $('#formAddStockItem').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('api/stock/add_stock_item.php', formData, function(response) {
            $('#responseModal').html(response);
            $('#addStockItemModal').modal('hide');
        });
    });
</script>