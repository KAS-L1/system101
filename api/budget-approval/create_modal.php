<?php require("../../app/init.php"); ?>

<!-- Create Budget Approval Modal -->
<div class="modal fade" id="createBudgetApprovalModal" tabindex="-1" aria-labelledby="createBudgetApprovalModalLabel"
    aria-hidden="true">
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
                        <!-- First Row: Requisition ID, Approved Amount -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="requisition_id">Requisition ID:</label>
                                <select class="form-control" id="requisition_id" name="requisition_id" required>
                                    <!-- Dynamically populate requisition options -->
                                    <?php
                                    $requisitions = $DB->SELECT("purchaserequisition", "requisition_id, department, item_description", "WHERE status='Pending'");
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
                                <input type="number" class="form-control" id="approved_amount" name="approved_amount"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Second Row: Approved By, Approval Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="approved_by">Approved By:</label>
                                <input type="text" class="form-control" id="approved_by" name="approved_by"
                                    value="Finance Department" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="approval_date">Approval Date:</label>
                                <input type="date" class="form-control" id="approval_date" name="approval_date"
                                    value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Third Row: Status, Remarks -->
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="formCreateBudgetApproval">Create Approval</button>
            </div>
        </div>
    </div>
</div>

<!-- Response Modal -->
<div id="responseModal"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
    $('#formCreateBudgetApproval').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize();

        // Send the data to the API endpoint for creating a budget approval
        $.post("api/budget-approval/create.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
        });
    });
</script>