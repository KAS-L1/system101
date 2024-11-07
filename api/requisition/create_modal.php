<?php require("../../app/init.php"); ?>

<div class="modal fade" id="addPurchaseRequisitionModal" tabindex="-1" aria-labelledby="addPurchaseRequisitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPurchaseRequisitionModalLabel">Add Purchase Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Purchase Requisition Form -->
                <form id="formAddRequisition">
                    <div class="row">
                        <!-- First Row: Department, Item Description, Quantity, Unit of Measure, Estimated Cost -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department">Department:</label>
                                <input type="text" class="form-control" id="department" name="department" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_description">Item Description:</label>
                                <input type="text" class="form-control" id="item_description" name="item_description" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit_of_measure">Unit of Measure:</label>
                                <input type="text" class="form-control" id="unit_of_measure" name="unit_of_measure" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="estimated_cost">Estimated Cost:</label>
                                <input type="number" class="form-control" id="estimated_cost" name="estimated_cost" required step="0.01">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <!-- Second Row: Priority Level, Requested Date, Required Date, Status, and Remarks -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="priority_level">Priority Level:</label>
                                <select class="form-control" id="priority_level" name="priority_level" required>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="requested_date">Requested Date:</label>
                                <input type="date" class="form-control" id="requested_date" name="requested_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="required_date">Required Date:</label>
                                <input type="date" class="form-control" id="required_date" name="required_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="remarks">Remarks:</label>
                                <textarea class="form-control" id="remarks" name="remarks"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" form="formAddRequisition">Add Requisition</button>
            </div>
        </div>
    </div>
</div>

<div id="responseModal"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
    $('#formAddRequisition').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize();
        $.post("api/requisition/create.php", formData, function(response) {
            $('#responseModal').html(response); // Display response in the modal
        });
    });
</script>