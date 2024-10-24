    <?php
    require("../../app/init.php");

    // Retrieve Invoice ID from POST request
    $invoice_id = $_POST['invoice_id'];
    $where = array("invoice_id" => $invoice_id);

    // Fetch the Invoice details from the database
    $invoice = $DB->SELECT_ONE_WHERE("invoice_payments", "*", $where);
    $order = $DB->SELECT_ONE_WHERE('purchaseorder', '*', array('po_id' => $invoice['po_id']));
    ?>

    <!-- Edit Invoice Modal -->
    <div class="modal fade" id="editInvoiceModal" tabindex="-1" aria-labelledby="editInvoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInvoiceModalLabel">Edit Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Edit Invoice Form -->
                    <form id="formEditInvoice">
                        <!-- Hidden field for Invoice ID -->
                        <input type="hidden" name="invoice_id" value="<?= $invoice['invoice_id'] ?>">

                        <!-- Row 1: Vendor Name, PO ID, Amount -->
                        <div class="row">
                            <!-- Vendor Name Field -->
                            <div class="col-md-6 mb-3">
                                <label for="vendor_name" class="form-label">Vendor Name</label>
                                <input type="text" id="vendor_name" name="vendor_name" class="form-control"
                                    value="<?= CHARS($order['vendor_name']) ?>" readonly>
                            </div>

                            <!-- PO ID Field -->
                            <div class="col-md-6 mb-3">
                                <label for="po_id" class="form-label">PO ID</label>
                                <input type="text" id="po_id" name="po_id" class="form-control"
                                    value="<?= CHARS($invoice['po_id']) ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Amount Field -->
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.01" id="amount" name="amount" class="form-control"
                                    value="<?= CHARS($invoice['amount']) ?>" required>
                            </div>

                            <!-- Payment Terms Field -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_terms" class="form-label">Payment Terms</label>
                                <input type="text" id="payment_terms" name="payment_terms" class="form-control"
                                    value="<?= CHARS($invoice['payment_terms']) ?>" required>
                            </div>
                        </div>

                        <!-- Row 2: Payment Status, Due Date, Remarks -->
                        <div class="row">
                            <!-- Payment Status Field -->
                            <div class="col-md-4 mb-3">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select id="payment_status" name="payment_status" class="form-select" required>
                                    <option value="Paid" <?= $invoice['payment_status'] == 'Paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="Pending" <?= $invoice['payment_status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                </select>
                            </div>

                            <!-- Due Date Field -->
                            <div class="col-md-4 mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" id="due_date" name="due_date" class="form-control"
                                    value="<?= CHARS($invoice['due_date']) ?>" required>
                            </div>

                            <!-- Remarks Field -->
                            <div class="col-md-4 mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea id="remarks" name="remarks" class="form-control" rows="3"
                                    placeholder="Optional remarks"><?= CHARS($invoice['remarks']) ?></textarea>
                            </div>
                        </div>

                        <!-- Modal Footer with Buttons -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update Invoice</button>
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
        $('#formEditInvoice').submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            var formData = $(this).serialize(); // Serialize form data

            // AJAX request to update invoice data
            $.post("api/invoice-payment-management/update.php", formData, function(response) {
                $('#responseModal').html(response); // Display response in the modal
            });
        });
    </script>