<!-- Add Supplier -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Add Supplier</h6>
                    <p class="card-text text-muted small">Add new supplier information, including contact details,
                        terms, and contracts.</p>
                    <button id="btnAddSupplier" class="btn btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#addSupplierModal">Add Supplier</button>
                </div>
            </div>
        </div>

        <!-- View Supplier -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-id-badge fa-2x text-info mb-3"></i>
                    <h6 class="card-title">View Supplier Profile</h6>
                    <p class="card-text text-muted small">Access detailed supplier information, including performance
                        metrics and contract terms.</p>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#viewSupplierProfileModal">View Supplier Profile</button>
                </div>
            </div>
        </div>

        <!-- View Supplier Performance -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Supplier Performance Report</h6>
                    <p class="card-text text-muted small">Generate performance reports based on delivery time, quality,
                        and pricing consistency.</p>
                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#supplierPerformanceReportModal">Generate Report</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Supplier -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Supplier Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="supplier_name">Supplier Name:</label>
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                    </div>
                    <div class="form-group">
                        <label for="supplier_address">Supplier Address:</label>
                        <input type="text" class="form-control" id="supplier_address" name="supplier_address">
                    </div>
                    <div class="form-group">
                        <label for="supplier_contact_number">Supplier Contact Number:</label>
                        <input type="text" class="form-control" id="supplier_contact_number"
                            name="supplier_contact_number">
                    </div>
                    <div class="form-group">
                        <label for="supplier_email">Supplier Email:</label>
                        <input type="email" class="form-control" id="supplier_email" name="supplier_email">
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_supplier">Add Supplier</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: View Supplier Profile -->
<div class="modal fade" id="viewSupplierProfileModal" tabindex="-1" aria-labelledby="viewSupplierProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewSupplierProfileModalLabel">Supplier Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Supplier Profile Table -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supplier ID</th>
                                <th>Supplier Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $i = 1; 
                        $suppliers = $DB->SELECT('suppliers', '*'); 
                        foreach ($suppliers as $supplier) {
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $supplier['id']; ?></td>
                                <td><?= $supplier['name']; ?></td>
                                <td><?= $supplier['address']; ?></td>
                                <td><?= $supplier['contact_number']; ?></td>
                                <td><?= $supplier['email']; ?></td>
                                <td><?= $supplier['status']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Responsive Table for Suppliers -->
<div class="container">
    <div class="table-responsive mt-4">
        <table id="dataTable" class="table table-bordered table-hover table-sm shadow-sm table-nowrap">
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
                        <span class="badge bg-success">Active</span>
                        <?php } else if($supplier['status'] == "Inactive"){ ?>
                        <span class="badge bg-danger">Inactive</span>
                        <?php } else { ?>
                        <span class="badge bg-secondary">Pending</span>
                        <?php } ?>
                    </td>
                    <td><?= $supplier['updated_at'] ?></td>
                    <td>
                        <div class="d-flex gap-2">

                            <button class="btn btn-sm btn-primary addSupplier"
                                data-id="<?= $supplier['id'] ?>">Edit</button>

                            <?php if($supplier['status'] != "Active"){ ?>
                            <button class="btn btn-sm btn-success selectActive"
                                data-id="<?=$supplier['id']?>">Active</button>
                            <?php }else{ ?>
                            <button class="btn btn-sm btn-success" disabled>Active</button>
                            <?php } ?>

                            <?php if($supplier['status'] != "Inactive"){ ?>
                            <button class="btn btn-sm btn-danger selectInactive"
                                data-id="<?=$supplier['id']?>">Inactive</button>
                            <?php }else{ ?>
                            <button class="btn btn-sm btn-danger" disabled>Inactive</button>
                            <?php } ?>

                            <!-- Remove Button -->
                            <button class="btn btn-sm btn-warning selectRemove"
                                data-id="<?=$supplier['id']?>">Remove</button>

                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Container for Dynamic Modals -->
<div id="responseModal"></div>
<div id="response"></div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
// Open Add Supplier Modal and Load Content via AJAX
$('#btnAddSupplier').click(function() {
    $.post('api/supplier/create_modal.php', function(res) {
        $('#responseModal').html(res); // Load modal content
        $('#addSupplierModal').modal('show'); // Show modal after content is loaded
    });
});

$('.addSupplier').click(function() {
    const id = $(this).data('id');
    $.post('api/supplier/edit_modal.php', {
        id: id
    }, function(res) {
        $('#responseModal').html(res);
        $('#editSupplierModal').modal('show');
    });
});

$('.selectActive').click(function() {
    const id = $(this).data('id');
    $.post('api/supplier/active.php', {
        id: id
    }, function(res) {
        $('#response').html(res);
    });
});

$('.selectInactive').click(function() {
    const id = $(this).data('id');
    $.post('api/supplier/inactive.php', {
        id: id
    }, function(res) {
        $('#response').html(res);
    });
});

$('.selectRemove').click(function() {
    const id = $(this).data('id');
    $.post('api/supplier/remove.php', {
        id: id
    }, function(res) {
        $('#response').html(res);
    });
});
</script>