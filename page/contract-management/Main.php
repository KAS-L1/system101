<!-- Contract Management UI -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Create Contract</h6>
                    <p class="card-text text-muted small">Draft and create contracts with suppliers for approved purchase orders.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createContractModal">Create Contract</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">View Contracts</h6>
                    <p class="card-text text-muted small">Access a list of all current contracts with suppliers.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewContractsModal">View Contracts</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Renew Contract</h6>
                    <p class="card-text text-muted small">Initiate contract renewals based on supplier performance and requirements.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#renewContractModal">Renew Contract</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                    <h6 class="card-title">Amend Contract</h6>
                    <p class="card-text text-muted small">Update or modify existing contracts based on mutual agreements with the supplier.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#amendContractModal">Amend Contract</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Create Contract -->
<div class="modal fade" id="createContractModal" tabindex="-1" aria-labelledby="createContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createContractModalLabel">Create Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Create Contract Form -->
                <form action="create-contract.php" method="post">
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name:</label>
                        <input type="text" id="supplierName" name="supplierName" class="form-control " required>
                    </div>
                    <div class="mb-3">
                        <label for="contractType" class="form-label">Contract Type:</label>
                        <select id="contractType" name="contractType" class="form-select" required>
                            <option value="">Select Contract Type</option>
                            <option value="Service Contract">Service Contract</option>
                            <option value="Supply Contract">Supply Contract</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contractDuration" class="form-label">Contract Duration:</label>
                        <input type="number" id="contractDuration" name="contractDuration" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Contract</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: View Contracts -->
<div class="modal fade" id="viewContractsModal" tabindex="-1" aria-labelledby="view ContractsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewContractsModalLabel">View Contracts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- View Contracts Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Contract ID</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Contract Type</th>
                            <th scope="col">Contract Duration</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CON-001</td>
                            <td>Supplier 1</td>
                            <td>Service Contract</td>
                            <td>12 months</td>
                            <td>Active</td>
                        </tr>
                        <tr>
                            <td>CON-002</td>
                            <td>Supplier 2</td>
                            <td>Supply Contract</td>
                            <td>6 months</td>
                            <td>Expired</td>
                        </tr>
                        <tr>
                            <td>CON-003</td>
                            <td>Supplier 3</td>
                            <td>Service Contract</td>
                            <td>24 months</td>
                            <td>Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Renew Contract -->
<div class="modal fade" id="renewContractModal" tabindex="-1" aria-labelledby="renewContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="renewContractModalLabel">Renew Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Renew Contract Form -->
                <form action="renew-contract.php" method="post">
                    <div class="mb-3">
                        <label for="contractID" class="form-label">Contract ID:</label>
                        <input type="text" id="contractID" name="contractID" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="renewalDuration" class="form-label">Renewal Duration:</label>
                        <input type="number" id="renewalDuration" name="renewalDuration" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Renew Contract</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: Amend Contract -->
<div class="modal fade" id="amendContractModal" tabindex="-1" aria-labelledby="amendContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="amendContractModalLabel">Amend Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Amend Contract Form -->
                <form action="amend-contract.php" method="post">
                    <div class="mb-3">
                        <label for="contractID" class="form-label">Contract ID:</label>
                        <input type="text" id="contractID" name="contractID" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="amendmentDetails" class="form-label">Amendment Details:</label>
                        <textarea id="amendmentDetails" name="amendmentDetails" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Amend Contract</button>
                </form>
            </div>
        </div>
    </div>
</div>

