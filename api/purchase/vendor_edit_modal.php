<?php
require("../../app/init.php");

// Retrieve Purchase Order ID from POST request
$po_id = $_POST['po_id'];
$where = array("po_id" => $po_id);

// Fetch the Purchase Order details from the database
$purchaseOrder = $DB->SELECT_ONE_WHERE("purchaseorder", "*", $where);
?>

<!-- Edit Purchase Order Modal -->
<div class="modal fade" id="editPOModal" tabindex="-1" aria-labelledby="editPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPOModalLabel">Edit Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Purchase Order Form -->
                <form id="formEditPO">
                    <!-- Hidden field for PO ID -->
                    <input type="hidden" name="po_id" value="<?= $purchaseOrder['po_id'] ?>">

                    <!-- Row 1: Vendor Name, Items -->
                    <div class="row">
                        <!-- Vendor Name Field -->
                        <div class="col-md-6 mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <input type="text" id="vendor_name" name="vendor_name" class="form-control"
                                value="<?= $purchaseOrder['vendor_name'] ?>" required>
                        </div>

                        <!-- Items Field -->
                        <div class="col-md-6 mb-3">
                            <label for="items" class="form-label">Items</label>
                            <textarea id="items" name="items" class="form-control" rows="3" required><?= $purchaseOrder['items'] ?></textarea>
                        </div>
                    </div>

                    <!-- Row 2: Quantity, Delivery Method, Tracking Link, Delivery Date, Status -->
                    <div class="row">
                        <!-- Quantity Field -->
                        <div class="col-md-6 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control"
                                value="<?= $purchaseOrder['quantity'] ?>" required>
                        </div>

                        <!-- Delivery Method Field -->
                        <div class="col-md-6 mb-3">
                            <label for="delivery_method" class="form-label">Delivery Method</label>
                            <input type="text" id="delivery_method" name="delivery_method" class="form-control"
                                value="<?= $purchaseOrder['delivery_method'] ?>" required>
                        </div>
                    </div>

                    <!-- Row 3: Tracking Link, Delivery Date, Status -->
                    <div class="row">
                        <!-- Tracking Link Field -->
                        <div class="col-md-6 mb-3">
                            <label for="tracking_link" class="form-label">Tracking Link</label>
                            <input type="url" id="tracking_link" name="tracking_link" class="form-control"
                                value="<?= htmlspecialchars($purchaseOrder['tracking_link'] ?? ''); ?>" required>
                            <?php if (!empty($purchaseOrder['tracking_link'])): ?>
                                <div class="mt-2">
                                    <a href="<?= htmlspecialchars($purchaseOrder['tracking_link']); ?>" target="_blank" class="btn btn-link">View Tracking</a>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mt-2">No link available</p>
                            <?php endif; ?>
                        </div>



                        <!-- Delivery Date Field -->
                        <div class="col-md-6 mb-3">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" id="delivery_date" name="delivery_date" class="form-control"
                                value="<?= $purchaseOrder['delivery_date'] ?>" required>
                        </div>
                    </div>

                    <!-- Row 4: Status -->
                    <div class="row">
                        <!-- Status Field -->
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="Ordered" <?= $purchaseOrder['status'] == 'Ordered' ? 'selected' : '' ?>>Ordered</option>
                                <option value="Shipped" <?= $purchaseOrder['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                <option value="In_transit" <?= $purchaseOrder['status'] == 'In Transit' ? 'selected' : '' ?>>In Transit</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Purchase Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Response Container -->
<div id="responseModal"></div>

<!-- JavaScript for Handling Form Submission -->
<script>
    $('#formEditPO').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to update Purchase Order data
        $.post("api/purchase/vendor_update.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
        });
    });
</script>