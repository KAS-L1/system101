<?php require("../../app/init.php"); ?>

<?php
// Retrieve the requisition data based on the ID provided via POST request
$requisition_id = $_POST['requisition_id'];
$where = array("requisition_id" => $requisition_id);
$requisition = $DB->SELECT_ONE_WHERE("purchaserequisition", "*", $where);
?>

<!-- Edit Requisition Modal -->
<div class="modal fade" id="editRequisitionModal" tabindex="-1" aria-labelledby="editRequisitionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRequisitionModalLabel">Edit Purchase Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Requisition Form -->
                <form id="formEditRequisition">
                    <!-- Hidden field for Requisition ID -->
                    <input type="hidden" name="requisition_id" value="<?= $requisition['requisition_id'] ?>">

                    <!-- Row 1: Department, Item Description, Quantity, Unit of Measure -->
                    <div class="row">
                        <!-- Department Field -->
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" id="department" name="department" class="form-control"
                                value="<?= $requisition['department'] ?>" required>
                        </div>

                        <!-- Item Description Field -->
                        <div class="col-md-6 mb-3">
                            <label for="item_description" class="form-label">Item Description</label>
                            <input type="text" id="item_description" name="item_description" class="form-control"
                                value="<?= $requisition['item_description'] ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Quantity Field -->
                        <div class="col-md-4 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" id="quantity" name="quantity" class="form-control"
                                value="<?= $requisition['quantity'] ?>" required>
                        </div>

                        <!-- Quantity Field -->
                        <div class="col-md-4 mb-3">
                            <label for="estimated_cost" class="form-label">Estimated Cost</label>
                            <input type="number" id="estimated_cost" name="estimated_cost" class="form-control"
                                value="<?= $requisition['estimated_cost'] ?>" required>
                        </div>

                        <!-- Unit of Measure Field -->
                        <div class="col-md-4 mb-3">
                            <label for="unit_of_measure" class="form-label">Unit of Measure</label>
                            <input type="text" id="unit_of_measure" name="unit_of_measure" class="form-control"
                                value="<?= $requisition['unit_of_measure'] ?>" required>
                        </div>

                        <!-- Priority Level Field -->
                        <div class="col-md-4 mb-3">
                            <label for="priority_level" class="form-label">Priority Level</label>
                            <select id="priority_level" name="priority_level" class="form-select" required>
                                <option value="Low" <?= $requisition['priority_level'] == 'Low' ? 'selected' : '' ?>>Low
                                </option>
                                <option value="Medium"
                                    <?= $requisition['priority_level'] == 'Medium' ? 'selected' : '' ?>>Medium</option>
                                <option value="High" <?= $requisition['priority_level'] == 'High' ? 'selected' : '' ?>>
                                    High</option>
                            </select>
                        </div>
                    </div>

                    <!-- Row 2: Requested Date, Required Date, Status, Remarks -->
                    <div class="row">
                        <!-- Requested Date Field -->
                        <div class="col-md-4 mb-3">
                            <label for="requested_date" class="form-label">Requested Date</label>
                            <input type="date" id="requested_date" name="requested_date" class="form-control"
                                value="<?= $requisition['requested_date'] ?>" required>
                        </div>

                        <!-- Required Date Field -->
                        <div class="col-md-4 mb-3">
                            <label for="required_date" class="form-label">Required Date</label>
                            <input type="date" id="required_date" name="required_date" class="form-control"
                                value="<?= $requisition['required_date'] ?>" required>
                        </div>

                        <!-- Status Field -->
                        <div class="col-md-4 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="Pending" <?= $requisition['status'] == 'Pending' ? 'selected' : '' ?>>
                                    Pending</option>
                                <option value="Approve" <?= $requisition['status'] == 'Approve' ? 'selected' : '' ?>>
                                    Approve</option>
                                <option value="Decline" <?= $requisition['status'] == 'Decline' ? 'selected' : '' ?>>
                                    Decline</option>
                            </select>
                        </div>
                    </div>

                    <!-- Remarks Field (Full Width) -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea id="remarks" name="remarks" class="form-control" rows="3"
                                placeholder="Optional remarks"><?= $requisition['remarks'] ?></textarea>
                        </div>
                    </div>

                    <!-- Modal Footer with Buttons -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update Requisition</button>
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
    $('#formEditRequisition').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize(); // Serialize form data

        // AJAX request to update requisition data
        $.post("api/requisition/update.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
        });
    });
</script>