<?php require("../../app/init.php");

$where = array("role" => "VENDOR");
$vendors = $DB->SELECT_WHERE("users", "*", $where);

?>


<!-- Modal: Create Purchase Order -->
<div class="modal fade" id="addPurchaseOrderModal" tabindex="-1" aria-labelledby="addPurchaseOrderModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPurchaseOrderModalLabel">Create New Purchase Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create Purchase Order Form -->
                <form id="formAddPurchaseOrder">
                    <!-- Row 1: Vendor Name, Items -->
                    <div class="row">
                        <!-- Vendor Name Field -->
                        <div class="col-md-6 mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <select class="form-control" name="vendor_id" id="vendor_id">
                                <?php foreach ($vendors as $vendor): ?>
                                    <option value="<?= $vendor['user_id']; ?>">
                                        <?= $vendor['vendor_name']; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- Items Field -->
                        <div class="col-md-6 mb-3">
                            <label for="items" class="form-label">Items</label>
                            <textarea id="items" name="items" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>

                    <!-- Row 2: Quantity, Unit Price, Order Date, Delivery Date -->
                    <div class="row">
                        <!-- Quantity Field -->
                        <div class="col-md-3 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" required>
                        </div>

                        <!-- Unit Price Field -->
                        <div class="col-md-3 mb-3">
                            <label for="unit_price" class="form-label">Unit Price</label>
                            <input type="number" step="0.01" id="unit_price" name="unit_price" class="form-control"
                                required>
                        </div>

                        <!-- Order Date Field -->
                        <div class="col-md-3 mb-3">
                            <label for="order_date" class="form-label">Order Date</label>
                            <input type="date" id="order_date" name="order_date" class="form-control" required>
                        </div>

                        <!-- Delivery Date Field -->
                        <div class="col-md-3 mb-3">
                            <label for="delivery_date" class="form-label">Delivery Date</label>
                            <input type="date" id="delivery_date" name="delivery_date" class="form-control" required>
                        </div>
                    </div>

                    <!-- Row 3: Remarks Field -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control" rows="3"
                                placeholder="Optional remarks or additional instructions"></textarea>
                        </div>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Create Purchase Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="responseModal"></div>

<!-- JavaScript for Handling Create Purchase Order Form Submission -->
<script>
    $('#formAddPurchaseOrder').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to create purchase order
        $.post("api/purchase/create.php", formData, function(response) {
            $('#responseModal').html(response);
        });
    });
</script>