<!-- Add Supplier -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Add Supplier</h6>
                    <p class="card-text text-muted small">Add new supplier information, including contact details, terms, and contracts.</p>
                    <button id="btnAddSupplier" class="btn btn-sm btn-info">Add Supplier</button>
                </div>
            </div>
        </div>
        <!-- View Supplier -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-id-badge fa-2x text-info mb-3"></i>
                    <h6 class="card-title">View Supplier Profile</h6>
                    <p class="card-text text-muted small">Access detailed supplier information, including performance metrics and contract terms.</p>
                    <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewSupplierProfileModal">View Supplier Profile</a>
                </div>
            </div>
        </div>
        <!-- View Supplier Performance -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Supplier Performance Report</h6>
                    <p class="card-text text-muted small">Generate performance reports based on delivery time, quality, and pricing consistency.</p>
                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#supplierPerformanceReportModal">Generate Report</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Responsive Table for Suppliers -->
<div class="container">
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-hover table-sm shadow-sm">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Contract</th>
                    <th>Performance Score</th>
                    <th>Status</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $suppliers = $DB->SELECT("suppliers", "*", "ORDER BY id DESC");
                foreach ($suppliers as $supplier) {
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $supplier['id']; ?></td>
                        <td><?= $supplier['name'] ?></td>
                        <td><?= $supplier['contact_number'] ?></td>
                        <td><?= $supplier['email'] ?></td>
                        <td><?= $supplier['contract'] ?></td>
                        <td><?= $supplier['performance_score'] ?></td>
                        <td>
                            <?php if($supplier['status'] == "Active"){ ?>
                                <span class="badge bg-secondary">Active</span>
                            <?php } else if($supplier['status'] == "Inactive"){ ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php } ?>
                        </td>
                        <td><?= $supplier['updated_at'] ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary addSupplier" data-supplier_id="<?= $supplier['id'] ?>">Edit</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Container for Dynamic Modals -->
<div id="responseModal"></div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    // Open Add Supplier Modal and Load Content via AJAX
    $('#btnAddSupplier').click(function(){
        $.post('api/supplier/create_modal.php', function(res){
            $('#responseModal').html(res); // Load modal content
            $('#addSupplierModal').modal('show'); // Show modal after content is loaded
        });
    });
</script>
