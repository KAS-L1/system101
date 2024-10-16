<?php
include_once('api/middleware/role_access.php');

?>

<!-- Purchase Requisition Section -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Card: Add Purchase Requisition -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Add Purchase Requisition</h6>
                    <p class="card-text text-muted small">Create a new purchase requisition, specifying item details and
                        priority level.</p>
                    <button id="btnAddPurchaseRequisition" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#addPurchaseRequisitionModal">Add Requisition</button>
                </div>
            </div>
        </div>

        <!-- Card: View Active Requisitions -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-eye fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View Active Requisitions</h6>
                    <p class="card-text text-muted small">Monitor and manage active purchase requisitions.</p>
                    <!-- Button to Open Modal -->
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#viewRequisitionsModal">View Requisitions</button>
                </div>
            </div>
        </div>

        <!-- Card: Generate Requisition Report -->
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-bar fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Generate Requisition Report</h6>
                    <p class="card-text text-muted small">Generate reports based on requisition priorities, status, and
                        required dates.</p>
                    <button class="btn btn-sm btn-success" onclick="window.open('api/requisition/generate_report.php')">Generate Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View Active Requisitions -->
<div class="modal fade" id="viewRequisitionsModal" tabindex="-1" aria-labelledby="viewRequisitionsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRequisitionsModalLabel">Active Purchase Requisitions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-4">
                    <div class="card shadow-sm mb-4">
                        <!-- Active Requisitions Table -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable2" class="table table-hover table-sm">
                                    <thead class="table-success">
                                        <tr>
                                            <th>#</th>
                                            <th>Requisition ID</th>
                                            <th>Department</th>
                                            <th>Item Description</th>
                                            <th>Quantity</th>
                                            <th>Unit of Measure</th>
                                            <th>Priority Level</th>
                                            <th>Requested Date</th>
                                            <th>Required Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $requisitions = $DB->SELECT('purchaserequisition', '*');
                                        foreach ($requisitions as $requisition) {
                                        ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= CHARS($requisition['requisition_id']); ?></td>
                                                <td><?= CHARS($requisition['department']); ?></td>
                                                <td><?= CHARS($requisition['item_description']); ?></td>
                                                <td><?= CHARS($requisition['quantity']); ?></td>
                                                <td><?= CHARS($requisition['unit_of_measure']); ?></td>
                                                <td><?= CHARS($requisition['priority_level']); ?></td>
                                                <td><?= CHARS($requisition['requested_date']); ?></td>
                                                <td><?= CHARS($requisition['required_date']); ?></td>
                                                <td>
                                                    <?php if ($requisition['status'] == 'Approve') { ?>
                                                        <span class="badge bg-success">Approve</span>
                                                    <?php } elseif ($requisition['status'] == 'Decline') { ?>
                                                        <span class="badge bg-danger">Decline</span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-secondary">Pending</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
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

<!-- Purchase Requisition Table -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light text-success">
            <h5 class="mb-0">Purchase Requisitions Management</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable1" class="table table-bordered table-hover table-sm shadow-sm table-nowrap
">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Requisition ID</th>
                            <th>Department</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Unit of Measure</th>
                            <th>Priority Level</th>
                            <th>Requested Date</th>
                            <th>Required Date</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $requisitions = $DB->SELECT("purchaserequisition", "*", "ORDER BY requisition_id DESC");
                        foreach ($requisitions as $requisition) {
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $requisition['requisition_id']; ?></td>
                                <td><?= $requisition['department']; ?></td>
                                <td><?= $requisition['item_description']; ?></td>
                                <td><?= $requisition['quantity']; ?></td>
                                <td><?= $requisition['unit_of_measure']; ?></td>
                                <td><?= $requisition['priority_level']; ?></td>
                                <td><?= $requisition['requested_date']; ?></td>
                                <td><?= $requisition['required_date']; ?></td>
                                <td>
                                    <?php if ($requisition['status'] == "Approve") { ?>
                                        <span class="badge bg-success">Approve</span>
                                    <?php } elseif ($requisition['status'] == "Decline") { ?>
                                        <span class="badge bg-danger">Decline</span>
                                    <?php } else { ?>
                                        <span class="badge bg-secondary">Pending</span>
                                    <?php } ?>
                                </td>
                                <td><?= $requisition['remarks']; ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-light shadow-sm editRequisition"
                                            data-requisition_id="<?= $requisition['requisition_id']; ?>">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Approve Button -->
                                        <?php if ($requisition['status'] != "Approve") { ?>
                                            <button class="btn btn-sm btn-success shadow-sm approveRequisition"
                                                data-requisition_id="<?= $requisition['requisition_id']; ?>">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-success shadow-sm" disabled><i
                                                    class="bi bi-check-circle"></i></button>
                                        <?php } ?>
                                        <!-- Reject Button -->
                                        <?php if ($requisition['status'] != "Decline") { ?>
                                            <button class="btn btn-sm btn-danger shadow-sm declineRequisition"
                                                data-requisition_id="<?= $requisition['requisition_id']; ?>">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button class="btn btn-sm btn-danger shadow-sm" disabled><i
                                                    class="bi bi-x-circle"></i></button>
                                        <?php } ?>
                                        <!-- Remove Button -->
                                        <button class="btn btn-sm btn-warning shadow-sm removeRequisition"
                                            data-requisition_id="<?= $requisition['requisition_id']; ?>">
                                            <i class="bi bi-trash"></i>
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
<div id="response"></div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    $('#btnAddPurchaseRequisition').click(function() {
        $.post('api/requisition/create_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#addPurchaseRequisitionModal').modal('show');
        });
    });

    // Edit Requisition Button Click Event
    $('.editRequisition').click(function() {
        const requisition_id = $(this).data('requisition_id');
        $.post('api/requisition/edit_modal.php', {
            requisition_id: requisition_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#editRequisitionModal').modal('show');
        });
    });

    // Approve Requisition Button Click Event
    $('.approveRequisition').click(function() {
        const requisition_id = $(this).data('requisition_id');
        $.post('api/requisition/approve.php', {
            requisition_id: requisition_id
        }, function(res) {
            $('#response').html(res);
        });
    });

    // Reject Requisition Button Click Event
    $('.declineRequisition').click(function() {
        const requisition_id = $(this).data('requisition_id');
        $.post('api/requisition/decline.php', {
            requisition_id: requisition_id
        }, function(res) {
            $('#response').html(res);
        });
    });

    // Remove Requisition Button Click Event
    $('.removeRequisition').click(function() {
        const requisition_id = $(this).data('requisition_id');

        Swal.fire({
            title: "Are you sure you want to delete this?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with deletion
                $.post('api/requisition/remove.php', {
                    requisition_id: requisition_id
                }, function(res) {
                    $('#response').html(res);
                    // Call your custom swalAlert after successful deletion
                    swalAlert('success', 'Deleted!');
                }).fail(function() {
                    // Optional: Handle failure case
                    swalAlert('error', 'Failed to delete. Please try again.');
                });
            }
        });
    });
</script>