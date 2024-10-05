<!-- Purchase Requisition -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Create Requisition</h6>
                    <p class="card-text text-muted small">Initiate a requisition for goods/services from various departments.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createRequisitionModal" onclick="$('#createRequisitionModal').modal('show')">Create Requisition</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">View Requisitions</h6>
                    <p class="card-text text-muted small">Access the list of active requisitions submitted by departments.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewRequisitionsModal" onclick="$('#viewRequisitionsModal').modal('show')">View Requisitions</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Approve Requisition</h6>
                    <p class="card-text text-muted small">Approve a requisition based on budget and procurement needs.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#approveRequisitionModal" onclick="$('#approveRequisitionModal').modal('show')">Approve Requisition</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Reject Requisition</h6>
                    <p class="card-text text-muted small">Reject a requisition and provide feedback to the requesting department.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rejectRequisitionModal" onclick="$('#rejectRequisitionModal').modal('show')">Reject Requisition</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Create Requisition -->
<div class="modal fade" id="createRequisitionModal" tabindex="-1" aria-labelledby="createRequisitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRequisitionModalLabel">Create Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create Requisition Form -->
                <form action="create-requisition.php" method="post">
                    <div class="mb-3">
                        <label for="requisitionID" class="form-label">Requisition ID:</label>
                        <input type="text" id="requisitionID" name="id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="department" class="form-label">Department:</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="">Select Department</option>
                            <option value="Department 1">Department 1</option>
                            <option value="Department 2">Department 2</option>
                            <option value="Department 3">Department 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="item" class="form-label">Item:</label>
                        <input type="text" id=" item" name="item" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="unitPrice" class="form-label">Unit Price:</label>
                        <input type="number" id="unitPrice" name="unitPrice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="totalCost" class="form-label">Total Cost:</label>
                        <input type="number" id="totalCost" name="totalCost" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Requisition</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: View Requisitions -->
<div class="modal fade" id="viewRequisitionsModal" tabindex="-1" aria-labelledby="viewRequisitionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewRequisitionsModalLabel">View Requisitions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- View Requisitions Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Requisition ID</th>
                            <th scope="col">Department</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>REQ-001</td>
                            <td>Department 1</td>
                            <td>Item 1</td>
                            <td>10</td>
                            <td>100.00</td>
                            <td>1000.00</td>
                        </tr>
                        <tr>
                            <td>REQ-002</td>
                            <td>Department 2</td>
                            <td>Item 2</td>
                            <td>20</td>
                            <td>200.00</td>
                            <td>4000.00</td>
                        </tr>
                        <tr>
                            <td>REQ-003</td>
                            <td>Department 3</td>
                            <td>Item 3</td>
                            <td>30</td>
                            <td>300.00</td>
                            <td>9000.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Approve Requisition -->
<div class="modal fade" id="approveRequisitionModal" tabindex="-1" aria-labelledby="approveRequisitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveRequisitionModalLabel">Approve Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Approve Requisition Form -->
                <form action="approve-requisition.php" method="post">
                    <div class="mb-3">
                        <label for="requisitionID" class="form-label">Requisition ID:</label>
                        <input type="text" id="requisitionID" name="id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="approvalStatus" class="form-label">Approval Status:</label>
                        <select id="approvalStatus" name="approvalStatus" class="form-select" required>
                            <option value="">Select Status</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="approvalRemarks" class="form-label">Approval Remarks:</label>
                        <textarea id="approvalRemarks" name="approvalRemarks" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Approve Requisition</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: Reject Requisition -->
<div class="modal fade" id="rejectRequisitionModal" tabindex="-1" aria-labelledby="rejectRequisitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectRequisitionModalLabel">Reject Requisition</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Reject Requisition Form -->
                <form action="reject-requisition.php" method="post">
                    <div class="mb-3">
                        <label for="requisitionID" class="form-label">Requisition ID:</label>
                        <input type="text" id="requisitionID" name="id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rejectionRemarks" class="form-label">Rejection Remarks:</label>
                        <textarea id="rejectionRemarks" name="rejectionRemarks" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Reject Requisition</button>
                </form>
            </div>
        </div>
    </div>
</div>