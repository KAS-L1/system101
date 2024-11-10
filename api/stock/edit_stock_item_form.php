<!-- edit_stock_item_form.php -->
<?php
include_once('../../app/init.php');
$stock_id = $_POST['stock_id'];
$stockItem = $DB->SELECT_ONE_WHERE("stock_items", "*", ["stock_id" => $stock_id]);
?>

<div class="modal fade" id="editStockItemModal" tabindex="-1" aria-labelledby="editStockItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockItemModalLabel">Edit Stock Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditStockItem">
                    <input type="hidden" name="stock_id" value="<?= htmlspecialchars($stockItem['stock_id']) ?>">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name" value="<?= htmlspecialchars($stockItem['item_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="Perishable" <?= $stockItem['category'] == 'Perishable' ? 'selected' : '' ?>>Perishable</option>
                            <option value="Non-perishable" <?= $stockItem['category'] == 'Non-perishable' ? 'selected' : '' ?>>Non-perishable</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="supplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" value="<?= htmlspecialchars($stockItem['supplier']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit_price" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="unit_price" name="unit_price" value="<?= number_format($stockItem['unit_price'], 2) ?>" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="reorder_level" class="form-label">Reorder Level</label>
                        <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="<?= htmlspecialchars($stockItem['reorder_level']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="current_stock_level" class="form-label">Current Stock Level</label>
                        <input type="number" class="form-control" id="current_stock_level" name="current_stock_level" value="<?= htmlspecialchars($stockItem['current_stock_level']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Expiration Date (for Perishables)</label>
                        <input type="date" class="form-control" id="expiration_date" name="expiration_date" value="<?= htmlspecialchars($stockItem['expiration_date']) ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Stock Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="responseModal"></div>

<script>
    // Submit Edit Stock Item Form
    $('#formEditStockItem').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('api/stock/edit_stock_item.php', formData, function(response) {
            $('#responseModal').html(response);
            $('#editStockItemModal').modal('hide');
        });
    });
</script>