<?php
include_once('api/middleware/role_access.php');
?>

<!-- Pending Requisitions Table Section Below the Cards -->
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center bg-light text-success">
            <h5 class="card-title mb-0">Budget Approval</h5>
            <!-- Button to Navigate to Budget Approval Report Page and Add Budget Approval -->
            <div>
                <a href="/api/budget-approval/generate_report.php" class="btn btn-success">
                    <i class="bi bi-download"></i>
                </a>
                <button class="btn btn-primary" id="btnCreateBudgetApproval">
                    <i class="bi bi-plus"></i> Add
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover table-sm shadow-sm">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Requisition ID</th>
                            <th>Department</th>
                            <th>Item Description</th>
                            <th>Quantity</th>
                            <th>Estimated Cost</th>
                            <th>Approved Amount</th>
                            <th>Approval Status</th>
                            <th>Approved By</th>
                            <th>Approval Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        // Define the fields to select
                        $fields = "
                            pr.requisition_id, pr.department, pr.item_description, pr.quantity, 
                            pr.estimated_cost, ba.approved_amount, ba.approval_status, 
                            ba.approved_by, ba.approval_date, ba.remarks AS approval_remarks
                        ";

                        // Define the join condition with INNER JOIN and filter for approved or rejected status
                        $options = "
                            INNER JOIN budget_approval ba ON pr.requisition_id = ba.requisition_id 
                            WHERE ba.approval_status IN ('Approved', 'Rejected')
                            ORDER BY pr.requested_date ASC
                        ";

                        // Execute the SELECT method
                        $approvedRequisitions = $DB->SELECT('purchaserequisition pr', $fields, $options);

                        if ($approvedRequisitions) {
                            foreach ($approvedRequisitions as $requisition) {
                                $requisition_id = htmlspecialchars($requisition['requisition_id'] ?? '');
                                $department = htmlspecialchars($requisition['department'] ?? '');
                                $item_description = htmlspecialchars($requisition['item_description'] ?? '');
                                $quantity = htmlspecialchars($requisition['quantity'] ?? '');
                                $estimated_cost = number_format($requisition['estimated_cost'] ?? 0, 2);
                                $approved_amount = number_format($requisition['approved_amount'] ?? 0, 2);
                                $approval_status = htmlspecialchars($requisition['approval_status'] ?? 'Pending');
                                $approved_by = htmlspecialchars($requisition['approved_by'] ?? 'N/A');
                                $approval_date = htmlspecialchars($requisition['approval_date'] ?? 'N/A');
                                $approval_remarks = htmlspecialchars($requisition['approval_remarks'] ?? 'No remarks');

                                // Determine the badge class based on the approval status
                                $badgeClass = $approval_status === 'Approved' ? 'bg-success' : 'bg-danger';
                        ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $requisition_id; ?></td>
                                    <td><?= $department; ?></td>
                                    <td><?= $item_description; ?></td>
                                    <td><?= $quantity; ?></td>
                                    <td><?= $estimated_cost; ?></td>
                                    <td><?= $approved_amount; ?></td>
                                    <td><span class="badge <?= $badgeClass; ?>"><?= $approval_status; ?></span></td>
                                    <td><?= $approved_by; ?></td>
                                    <td><?= $approval_date; ?></td>
                                    <td><?= $approval_remarks; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='11' class='text-center'>No approved or rejected requisitions found.</td></tr>";
                        }
                        ?>
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
    $('#btnCreateBudgetApproval').click(function() {
        $.post('api/budget-approval/create_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#createBudgetApprovalModal').modal('show');
        });
    });
</script>