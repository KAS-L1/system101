<?php
require("../../app/init.php");

if (isset($_POST['invoice_id'])) {
    $invoice_id = $_POST['invoice_id'];
    $invoice = $DB->SELECT_ONE_WHERE('invoice_payments', '*', array('invoice_id' => $invoice_id));
    $order = $DB->SELECT_ONE_WHERE('purchaseorder', '*', array('po_id' => $invoice['po_id']));
?>

<!-- View Invoice Modal -->
<div class="modal fade" id="viewInvoiceModal" tabindex="-1" aria-labelledby="viewInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewInvoiceModalLabel">View Invoice - <?= CHARS($invoice['invoice_id']); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Vendor Name:</strong> <?= CHARS($order['vendor_name']); ?></p>
                <p><strong>Amount:</strong> <?= NUMBER_PHP_2($invoice['amount']); ?></p>
                <p><strong>Payment Terms:</strong> <?= CHARS($invoice['payment_terms']); ?></p>
                <p><strong>Due Date:</strong> <?= CHARS($invoice['due_date']); ?></p>
                <p><strong>Payment Status:</strong> <?= CHARS($invoice['payment_status']); ?></p>
                <p><strong>Remarks:</strong> <?= CHARS($invoice['remarks']); ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
}
?>
