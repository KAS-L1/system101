<?php
include_once('api/middleware/role_access.php');
// Retrieve all pending Requisitions from the `purchaserequisition` table
$pendingRequisitions = $DB->SELECT("purchaserequisition", "*", "WHERE status='Pending' ORDER BY requisition_id DESC");

?>

<!-- Budget Approval Section -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Card: Create Budget Approval -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Create Budget Approval</h6>
                    <p class="card-text text-muted small">Approve or reject requisitions based on budget availability.
                    </p>
                    <button id="btnCreateBudgetApproval" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#createBudgetApprovalModal">Create Approval</button>
                </div>
            </div>
        </div>

        <!-- Card: View Pending Requisitions -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View Pending Requisitions</h6>
                    <p class="card-text text-muted small">Monitor and manage pending requisitions for budget approval.
                    </p>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#viewPendingModal">View Requisitions</button>
                </div>
            </div>
        </div>

        <!-- Card: Generate Approval Report -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Generate Approval Report</h6>
                    <p class="card-text text-muted small">Generate reports based on requisition approvals and status.
                    </p>
                    <!-- Button to Navigate to Budget Approval Report Page -->
                    <div class="d-flex justify-content-center">
                        <a href="/api/budget-approval/generate_report.php" class="btn btn-success">
                            Generate Approval Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Requisitions Table Section Below the Cards -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light text-success">
            <h5 class="card-title">Pending Requisitions</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable1" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Requisition ID</th>
                            <th>Department</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Estimated Cost</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($pendingRequisitions as $requisition) {
                            $estimated_cost = isset($requisition['estimated_cost']) ? $requisition['estimated_cost'] : 0;
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= CHARS($requisition['requisition_id']); ?></td>
                                <td><?= CHARS($requisition['department']); ?></td>
                                <td><?= CHARS($requisition['item_description']); ?></td>
                                <td><?= CHARS($requisition['quantity']); ?></td>
                                <td><?= NUMBER_PHP_2($estimated_cost); ?></td>
                                <td>
                                    <span class="badge bg-secondary"><?= CHARS($requisition['status']); ?></span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal: View Pending Requisitions -->
<div class="modal fade" id="viewPendingModal" tabindex="-1" aria-labelledby="viewPendingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPendingModalLabel">Pending Requisitions for Budget Approval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <!-- Pending Requisitions Table without Action Column -->
                        <div class="table-responsive">
                            <table id="dataTable2" class="table table-hover table-sm">
                                <thead class="table-success">
                                    <tr>
                                        <th>#</th>
                                        <th>Requisition ID</th>
                                        <th>Department</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Estimated Cost</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($pendingRequisitions as $requisition) {
                                        $estimated_cost = isset($requisition['estimated_cost']) ? $requisition['estimated_cost'] : 0;
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= CHARS($requisition['requisition_id']); ?></td>
                                            <td><?= CHARS($requisition['department']); ?></td>
                                            <td><?= CHARS($requisition['item_description']); ?></td>
                                            <td><?= CHARS($requisition['quantity']); ?></td>
                                            <td><?= NUMBER_PHP_2($estimated_cost); ?></td>
                                            <td>
                                                <span
                                                    class="badge bg-secondary"><?= CHARS($requisition['status']); ?></span>
                                            </td>
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

<!-- Modal Container for Dynamic Modals -->
<div id="responseModal"></div>
<div id="response"></div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    $('#btnCreateBudgetApproval').click(function() {
        $.post('api/budget-approval/create_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#createBudgetApprovalModal').modal('show');
        });
    });
</script>