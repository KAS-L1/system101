<?php
require("../../app/init.php");

// Fetch Purchase Orders for dropdown with "Delivered" status
$purchaseOrders = $DB->SELECT("purchaseorder", "*", "WHERE status = 'Delivered' ORDER BY po_id DESC");

// Debugging output to check if $purchaseOrders is populated correctly
if (empty($purchaseOrders)) {
    echo "<p class='text-danger'>No delivered purchase orders found.</p>";
}
?>

<!-- Create Invoice Modal -->
<div class="modal fade" id="addInvoiceModal" tabindex="-1" aria-labelledby="addInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInvoiceModalLabel">Create Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create Invoice Form -->
                <form id="formCreateInvoice">
                    <!-- Row 1: PO ID, Vendor Name, Amount -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="po_id" class="form-label">Purchase Order</label>
                            <select id="po_id" name="po_id" class="form-select" required>
                                <option value="">Select Purchase Order</option>
                                <?php if (!empty($purchaseOrders)): ?>
                                    <?php foreach ($purchaseOrders as $po): ?>
                                        <option value="<?= htmlspecialchars($po['po_id']); ?>">
                                            <?= htmlspecialchars($po['po_id']) . " - " . htmlspecialchars($po['vendor_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Display message if no orders are available -->
                                    <option value="" disabled>No delivered purchase orders available</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" id="amount" name="amount" step="0.01" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="payment_terms" class="form-label">Payment Terms</label>
                            <input type="text" id="payment_terms" name="payment_terms" class="form-control" placeholder="e.g., Net 30" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" id="due_date" name="due_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Optional remarks"></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select id="payment_status" name="payment_status" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Create Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="responseModal"></div>

<!-- JavaScript for Form Submission -->
<script>
    $('#formCreateInvoice').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to create Invoice
        $.post("api/invoice-payment-management/create.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in modal or on the page
            $('#addInvoiceModal').modal('hide'); // Hide modal after submission
        }).fail(function() {
            $('#responseModal').html('<div class="alert alert-danger">An error occurred while creating the invoice. Please try again.</div>');
        });
    });
</script>