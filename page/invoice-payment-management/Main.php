<?php
include_once('api/middleware/role_access.php');

// Fetch all invoices
$invoices = $DB->SELECT("invoice_payments", "*", "ORDER BY invoice_id DESC");

?>

<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Card: Add Invoice -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-invoice fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Create Invoice</h6>
                    <p class="card-text text-muted small">Create a new invoice for the completed purchase order.</p>
                    <button id="btnAddInvoice" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addInvoiceModal">Create Invoice</button>
                </div>
            </div>
        </div>

        <!-- Card: View Active Invoices -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View Active Invoices</h6>
                    <p class="card-text text-muted small">View and manage all active invoices.</p>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewInvoicesModal">View Invoices</button>
                </div>
            </div>
        </div>

        <!-- Card: Generate Invoice Report -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Generate Invoice Report</h6>
                    <p class="card-text text-muted small">Generate reports based on invoice statuses and payments.</p>
                    <button class="btn btn-sm btn-success" onclick="window.open('api/invoice-payment-management/generate_report.php', '_blank')">Generate Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Table Section -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light text-success">
                <h5 class="mb-0 text-start">Invoice Payment Management</h5>
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
                                $vendor = $DB->SELECT_ONE_WHERE('vendors', '*', array('vendor_id' => $invoice['vendor_id']));
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= CHARS($invoice['invoice_id']); ?></td>
                                    <td><?= CHARS($invoice['po_id']); ?></td>
                                    <td><?= CHARS($vendor['vendor_name']); ?></td>
                                    <td><?= NUMBER_PHP_2($invoice['amount']); ?></td>
                                    <td><?= CHARS($invoice['payment_terms']); ?></td>
                                    <td><span class="badge bg-<?= $invoice['payment_status'] == 'Paid' ? 'success' : 'secondary' ?>"><?= CHARS($invoice['payment_status']); ?></span></td>
                                    <td><?= CHARS($invoice['due_date']); ?></td>
                                    <td><?= CHARS($invoice['remarks']); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Edit Invoice Button -->
                                            <button class="btn btn-sm btn-light editInvoice" data-invoice_id="<?= $invoice['invoice_id']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Sync Invoice Button -->
                                            <button class="btn btn-sm btn-primary syncInvoice" data-invoice_id="<?= $invoice['invoice_id']; ?>">
                                                <i class="bi bi-upload"></i> Sync
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

    <!-- Modal: View Active Invoices -->
    <div class="modal fade" id="viewInvoicesModal" tabindex="-1" aria-labelledby="viewInvoicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewInvoicesModalLabel">Active Invoices</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Active Invoices Table -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable2" class="table table-hover table-sm shadow-sm">
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($invoices as $invoice) {
                                            $vendor = $DB->SELECT_ONE_WHERE('vendors', '*', array('vendor_id' => $invoice['vendor_id']));
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= CHARS($invoice['invoice_id']); ?></td>
                                                <td><?= CHARS($invoice['po_id']); ?></td>
                                                <td><?= CHARS($vendor['vendor_name']); ?></td>
                                                <td><?= NUMBER_PHP_2($invoice['amount']); ?></td>
                                                <td><?= CHARS($invoice['payment_terms']); ?></td>
                                                <td><span class="badge bg-<?= $invoice['payment_status'] == 'Paid' ? 'success' : 'secondary' ?>"><?= CHARS($invoice['payment_status']); ?></span></td>
                                                <td><?= CHARS($invoice['due_date']); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="responseModal"></div>

    <!-- JavaScript for handling modals and sync -->
    <script>
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

        // Sync Invoice Button Click Event
        $('.syncInvoice').click(function() {
            const invoice_id = $(this).data('invoice_id');
            $.post('api/invoice-payment-management/sync_invoice.php', {
                invoice_id: invoice_id
            }, function(res) {
                const response = JSON.parse(res);
                const alertClass = response.status === 'Synced' ? 'alert-success' : 'alert-danger';
                $('#response').html(`<div class="alert ${alertClass}">${response.message}</div>`);
            });
        });
    </script>
</div>