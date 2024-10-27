<?php
include_once('api/middleware/role_access_vendor.php');
// Fetch all invoices
if (AUTH_USER['role'] == "ADMIN") {
    $invoices = $DB->SELECT("invoice_payments", "*", "ORDER BY invoice_id DESC");
} elseif (AUTH_USER['role'] == "VENDOR") {
    $where = array("vendor_id" => AUTH_USER_ID);
    $invoices = $DB->SELECT_WHERE("invoice_payments", "*", $where, "ORDER BY invoice_id DESC");
}
?>

<div class="container mt-5">
    <!-- Invoice Table Section -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light text-success d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-start">Invoice Payment Management</h5>
                <div>
                    <!-- Button to Generate All Invoices Report -->
                    <button class="btn btn-sm btn-success" onclick="window.open('/api/invoice-payment-management/generateall_report.php', '_blank')">
                        <i class="bi bi-download"></i>
                    </button>

                    <button class="btn btn-sm btn-primary" id="btnAddInvoice">
                        <i class="bi bi-plus-circle"></i> Add Invoice
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableInvoices" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Invoice ID</th>
                                <th>PO ID</th>
                                <th>Vendor Name</th>
                                <th>Amount</th>
                                <th>Payment Terms</th>
                                <th>Payment Status</th>
                                <th>Due Date</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($invoices as $invoice) {

                                $order = $DB->SELECT_ONE_WHERE('purchaseorder', '*', array('po_id' => $invoice['po_id']));
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= CHARS($invoice['invoice_id']); ?></td>
                                    <td><?= CHARS($invoice['po_id']); ?></td>
                                    <td><?= CHARS($order['vendor_name']); ?></td>
                                    <td><?= NUMBER_PHP_2($invoice['amount']); ?></td>
                                    <td><?= CHARS($invoice['payment_terms']); ?></td>
                                    <td><span class="badge bg-<?= $invoice['payment_status'] == 'Paid' ? 'success' : 'secondary' ?>"><?= CHARS($invoice['payment_status']); ?></span></td>
                                    <td><?= CHARS($invoice['due_date']); ?></td>
                                    <td><?= CHARS($invoice['remarks']); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-light shadow-sm editInvoice" data-invoice_id="<?= $invoice['invoice_id']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light shadow-sm viewInvoice" data-invoice_id="<?= $invoice['invoice_id']; ?>">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-light shadow-sm generateReportInvoice text-success" data-invoice_id="<?= $invoice['invoice_id']; ?>">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Container for Dynamic Modals -->
    <div id="responseModal"></div>

    <!-- JavaScript for handling modals and AJAX requests -->
    <script>
        // View Invoice Button Click Event
        $('.viewInvoice').click(function() {
            const invoice_id = $(this).data('invoice_id');
            $.post('api/invoice-payment-management/view_invoice_modal.php', {
                invoice_id: invoice_id
            }, function(res) {
                $('#responseModal').html(res);
                $('#viewInvoiceModal').modal('show');
            });
        });

        // Generate Report Button Click Event
        $('.generateReportInvoice').click(function() {
            const invoice_id = $(this).data('invoice_id');
            Swal.fire({
                title: "Generate Report?",
                text: "This will generate a PDF report for the selected invoice.",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "Generate Report",
                confirmButtonColor: '#198754',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Correct URL to generate the PDF
                    window.open('api/invoice-payment-management/generate_report_invoice.php?invoice_id=' + invoice_id, '_blank');
                }
            });
        });

        // Add Invoice Button Click Event
        $('#btnAddInvoice').click(function() {
            $.post('api/invoice-payment-management/create_modal.php', function(res) {
                $('#responseModal').html(res);
                $('#addInvoiceModal').modal('show');
            });
        });

        // Edit Invoice Button Click Event
        $('.editInvoice').click(function() {
            const invoice_id = $(this).data('invoice_id');
            $.post('api/invoice-payment-management/edit_modal.php', {
                invoice_id: invoice_id
            }, function(res) {
                $('#responseModal').html(res);
                $('#editInvoiceModal').modal('show');
            });
        });
    </script>
</div>