<?php require("../../app/init.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Approvals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light text-success">
                <h5 class="card-title mb-0">Budget Approvals</h5>
                <button class="btn btn-primary float-end" id="btnCreateBudgetApproval" data-bs-toggle="modal" data-bs-target="#createBudgetApprovalModal">
                    <i class="bi bi-plus"></i> Add
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-success">
                            <tr>
                                <th>#</th>
                                <th>Requisition ID</th>
                                <th>Approved Amount</th>
                                <th>Approved By</th>
                                <th>Approval Date</th>
                                <th>Approval Status</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="approvalData"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Budget Approval Modal -->
    <div class="modal fade" id="createBudgetApprovalModal" tabindex="-1" aria-labelledby="createBudgetApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBudgetApprovalModalLabel">Create Budget Approval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Budget Approval Form -->
                    <form id="formCreateBudgetApproval">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="requisition_id">Requisition ID:</label>
                                    <select class="form-control" id="requisition_id" name="requisition_id" required>
                                        <!-- Dynamically populate requisition options -->
                                        <?php
                                        $requisitions = $DB->SELECT("purchaserequisition", "requisition_id, department, item_description", "WHERE status='Approve'");
                                        foreach ($requisitions as $requisition) {
                                            echo '<option value="' . $requisition['requisition_id'] . '">' . $requisition['requisition_id'] . ' - ' . $requisition['department'] . ' - ' . $requisition['item_description'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="approved_amount">Approved Amount:</label>
                                    <input type="number" class="form-control" id="approved_amount" name="approved_amount" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="approved_by">Approved By:</label>
                                    <input type="text" class="form-control" id="approved_by" name="approved_by" value="Finance Department" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="approval_date">Approval Date:</label>
                                    <input type="date" class="form-control" id="approval_date" name="approval_date" value="<?= date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="approval_status">Approval Status:</label>
                                    <select class="form-control" id="approval_status" name="approval_status" required>
                                        <option value="Approved">Approved</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="remarks">Remarks:</label>
                                    <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Fetching Data and Handling Form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchApprovals();

            function fetchApprovals() {
                fetch('http://127.0.0.15/APi/sync/budget_approval_update.php?token=d46e0160527566836cca768c839cadf7')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success' && Array.isArray(data.data)) {
                            const approvalData = document.getElementById('approvalData');
                            approvalData.innerHTML = '';

                            data.data.forEach((approval, index) => {
                                const row = `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${approval.requisition_id}</td>
                                        <td>${approval.approved_amount}</td>
                                        <td>${approval.approved_by}</td>
                                        <td>${approval.approval_date}</td>
                                        <td>${approval.approval_status}</td>
                                        <td>${approval.remarks}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="editApproval(${approval.requisition_id})">Edit</button>
                                        </td>
                                    </tr>
                                `;
                                approvalData.innerHTML += row;
                            });
                        } else {
                            document.getElementById('approvalData').innerHTML = '<tr><td colspan="8" class="text-center">No data found.</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        document.getElementById('approvalData').innerHTML = '<tr><td colspan="8" class="text-center">Failed to fetch data.</td></tr>';
                    });
            }

            document.getElementById('formCreateBudgetApproval').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('http://127.0.0.15/APi/sync/budget_approval_update.php?token=d46e0160527566836cca768c839cadf7', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        if (data.status === 'success') {
                            fetchApprovals(); // Refresh the table data after successful update
                            const modal = bootstrap.Modal.getInstance(document.getElementById('createBudgetApprovalModal'));
                            modal.hide();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the approval.');
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>