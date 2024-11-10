<?php
include_once('../../app/init.php');
$stock_id = $_POST['stock_id'];
$stockItem = $DB->SELECT_ONE("stock_items", "*", ["stock_id" => $stock_id]);

// Check if the stock item was fetched successfully
if (!$stockItem) {
    echo "<div class='alert alert-danger'>Stock item not found.</div>";
    exit;
}
?>

<div class="modal fade" id="restockItemModal" tabindex="-1" aria-labelledby="restockItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restockItemModalLabel">Restock Item: <?= htmlspecialchars($stockItem['item_name']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRestockItem">
                    <input type="hidden" name="stock_id" value="<?= htmlspecialchars($stock_id); ?>">
                    <div class="mb-3">
                        <label for="current_stock_level" class="form-label">Current Stock Level</label>
                        <input type="text" class="form-control" id="current_stock_level" value="<?= htmlspecialchars($stockItem['current_stock_level']); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="restock_quantity" class="form-label">Restock Quantity</label>
                        <input type="number" class="form-control" id="restock_quantity" name="restock_quantity" min="1" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Restock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="responseModal"></div>

<script>
    // Submit Restock Item Form
    $('#formRestockItem').submit(function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.post('api/stock/restock_item.php', formData, function(response) {
            $('#responseModal').html(response);
            $('#restockItemModal').modal('hide');
        });
    });
</script>