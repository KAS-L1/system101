<!-- Add Supplier -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Add Supplier</h6>
                    <p class="card-text text-muted small">Add new supplier information, including contact details, terms, and contracts.</p>
                    <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#addSupplierModal">Add Supplier</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Edit Supplier</h6>
                    <p class="card-text text-muted small">Modify existing supplier details or update performance records.</p>
                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editSupplierModal">Edit Supplier</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Remove Supplier</h6>
                    <p class="card-text text-muted small">Remove a supplier from the approved list.</p>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#removeSupplierModal">Remove Supplier</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Add Supplier -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Supplier Form -->
                <form action="add-supplier.php" method="post">
                    <div class="mb-3">
                        <label for="supplierName" class="form-label">Supplier Name:</label>
                        <input type="text" id="supplierName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactPerson" class="form-label">Contact Person:</label>
                        <input type="text" id="supplierContactPerson" name="contact_person" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactNumber" class="form-label">Contact Number:</label>
                        <input type="text" id="supplierContactNumber" name="contact_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierEmail" class="form-label">Email:</label>
                        <input type="email" id="supplierEmail" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Address:</label>
                        <input type="text" id="supplierAddress" name="address" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 2: Edit Supplier -->
<div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Edit Supplier Form -->
                <form action="edit-supplier.php" method="post">
                    <div class="mb-3">
                        <label for="supplier Name" class="form-label">Supplier Name:</label>
                        <input type="text" id="supplierName" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactPerson" class="form-label">Contact Person:</label>
                        <input type="text" id="supplierContactPerson" name="contact_person" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierContactNumber" class="form-label">Contact Number:</label>
                        <input type="text" id="supplierContactNumber" name="contact_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierEmail" class="form-label">Email:</label>
                        <input type="email" id="supplierEmail" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="supplierAddress" class="form-label">Address:</label>
                        <input type="text" id="supplierAddress" name="address" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 3: Remove Supplier -->
<div class="modal fade" id="removeSupplierModal" tabindex="-1" aria-labelledby="removeSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeSupplierModalLabel">Remove Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Remove Supplier Form -->
                <form action="remove-supplier.php" method="post">
                    <div class="mb-3">
                        <label for="supplierID" class="form-label">Supplier ID:</label>
                        <input type="text" id="supplierID" name="id" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Supplier Profile -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">View Supplier Profile</h6>
                    <p class="card-text text-muted small">Access detailed supplier information, including performance metrics and contract terms.</p>
                    <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewSupplierProfileModal">View Supplier Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Supplier Performance Report</h6>
                    <p class="card-text text-muted small">Generate performance reports based on delivery time, quality, and pricing consistency.</p>
                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#supplierPerformanceReportModal">Generate Report</a>
                </ div>
            </div>
        </div>
    </div>
</div>

<!-- Modal 4: View Supplier Profile -->
<div class="modal fade" id="viewSupplierProfileModal" tabindex="-1" aria-labelledby="viewSupplierProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal -title" id="viewSupplierProfileModalLabel">View Supplier Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- View Supplier Profile Form -->
                <form action="view-supplier-profile.php" method="post">
                    <div class="mb-3">
                        <label for="supplierID" class="form-label">Supplier ID:</label>
                        <input type="text" id="supplierID" name="id" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">View Supplier Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 5: Supplier Performance Report -->
<div class="modal fade" id="supplierPerformanceReportModal" tabindex="-1" aria-labelledby="supplierPerformanceReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierPerformanceReportModalLabel">Supplier Performance Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Supplier Performance Report Form -->
                <form action="supplier-performance-report.php" method="post">
                    <div class="mb-3">
                        <label for="supplierID" class="form-label">Supplier ID:</label>
                        <input type="text" id="supplierID" name="id" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Generate Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>