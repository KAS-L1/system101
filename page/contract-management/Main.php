<?php
// Fetch all contracts from the `contracts` table
$contracts = $DB->SELECT("contracts", "*", "ORDER BY contract_id DESC");
?>

<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Card: Add New Contract -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-contract fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Create New Contract</h6>
                    <p class="card-text text-muted small">Create a new contract with a vendor.</p>
                    <button id="btnAddContract" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addContractModal">Create Contract</button>
                </div>
            </div>
        </div>

        <!-- Card: View Active Contracts -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View Active Contracts</h6>
                    <p class="card-text text-muted small">View and manage active contracts.</p>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#viewContractsModal">View Contracts</button>
                </div>
            </div>
        </div>

        <!-- Card: Generate Contract Report -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Generate Contract Report</h6>
                    <p class="card-text text-muted small">Generate reports based on contract statuses and details.</p>
                    <button class="btn btn-sm btn-success" onclick="window.open('api/contract-management/generate_report.php', '_blank')">Generate Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contracts Table Section -->
    <div class="container mt-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light text-success">
                <h5 class="mb-0 text-start">Contract Management</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable2" class="table table-bordered table-hover table-sm mb-0 shadow-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Contract ID</th>
                                <th>Vendor Name</th>
                                <th>Contract Terms</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Renewal Date</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($contracts as $contract) {
                                $vendor = $DB->SELECT_ONE_WHERE('vendors', '*', array('vendor_id' => $contract['vendor_id']));
                            ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= CHARS($contract['contract_id']); ?></td>
                                    <td><?= CHARS($vendor['vendor_name']); ?></td>
                                    <td><?= CHARS($contract['contract_terms']); ?></td>
                                    <td><?= CHARS($contract['start_date']); ?></td>
                                    <td><?= CHARS($contract['end_date']); ?></td>
                                    <td>
                                        <?php if ($contract['status'] == 'Active') { ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php } elseif ($contract['status'] == 'Expired') { ?>
                                            <span class="badge bg-warning">Expired</span>
                                        <?php } elseif ($contract['status'] == 'Terminated') { ?>
                                            <span class="badge bg-danger">Terminated</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary"><?= CHARS($contract['status']); ?></span>
                                        <?php } ?>
                                    </td>
                                    <td><?= CHARS($contract['renewal_date']); ?></td>
                                    <td><?= CHARS($contract['remarks']); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <!-- Edit Contract Button -->
                                            <button class="btn btn-sm btn-light shadow-sm editContract" data-contract_id="<?= $contract['contract_id']; ?>">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Sync Contract Button -->
                                            <button class="btn btn-sm btn-primary shadow-sm syncContract" data-contract_id="<?= $contract['contract_id']; ?>">
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

    <!-- Modal: View Active Contracts -->
    <div class="modal fade" id="viewContractsModal" tabindex="-1" aria-labelledby="viewContractsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewContractsModalLabel">Active Contracts</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="dataTable1" class="table table-hover table-sm shadow-sm">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Contract ID</th>
                                    <th>Vendor Name</th>
                                    <th>Contract Terms</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Renewal Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($contracts as $contract) {
                                    $vendor = $DB->SELECT_ONE_WHERE('vendors', '*', array('vendor_id' => $contract['vendor_id']));
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= CHARS($contract['contract_id']); ?></td>
                                        <td><?= CHARS($vendor['vendor_name']); ?></td>
                                        <td><?= CHARS($contract['contract_terms']); ?></td>
                                        <td><?= CHARS($contract['start_date']); ?></td>
                                        <td><?= CHARS($contract['end_date']); ?></td>
                                        <td>
                                            <?php if ($contract['status'] == 'Active') { ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php } elseif ($contract['status'] == 'Expired') { ?>
                                                <span class="badge bg-warning">Expired</span>
                                            <?php } elseif ($contract['status'] == 'Terminated') { ?>
                                                <span class="badge bg-danger">Terminated</span>
                                            <?php } else { ?>
                                                <span class="badge bg-secondary"><?= CHARS($contract['status']); ?></span>
                                            <?php } ?>
                                        </td>
                                        <td><?= CHARS($contract['renewal_date']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Container for Dynamic Modals -->
    <div id="responseModal"></div>
    <div id="response"></div>
</div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    // Add Contract Button Click Event
    $('#btnAddContract').click(function() {
        $.post('api/contract-management/create_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#addContractModal').modal('show');
        });
    });

    // Edit Contract Button Click Event
    $('.editContract').click(function() {
        const contract_id = $(this).data('contract_id');
        $.post('api/contract-management/edit_modal.php', {
            contract_id: contract_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#editContractModal').modal('show');
        });
    });

    // Sync Contract Button Click Event
    $('.syncContract').click(function() {
        const contract_id = $(this).data('contract_id');
        $.post('api/contract-management/sync_contract.php', {
            contract_id: contract_id
        }, function(res) {
            const response = JSON.parse(res);
            const alertClass = response.status === 'Synced' ? 'alert-success' : 'alert-danger';
            $('#response').html(`<div class="alert ${alertClass}">${response.message}</div>`);
        });
    });
</script>