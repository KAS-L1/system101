<!-- User Management Cards -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Add User Card -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-2x text-success mb-3"></i>
                    <h6 class="card-title">Add User</h6>
                    <p class="card-text text-muted small">Add new user information, including contact details and
                        role.</p>
                    <button id="btnAddUser" class="btn btn-sm btn-success">Add User</button>
                </div>
            </div>
        </div>

        <!-- View Users -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-id-card fa-2x text-success mb-3"></i>
                    <h6 class="card-title">View User Profiles</h6>
                    <p class="card-text text-muted small">Access detailed user information, including contact
                        details and roles.</p>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#viewUserProfileModal">View Profiles</button>
                </div>
            </div>
        </div>

        <!-- User Reports -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                    <h6 class="card-title">User Performance Report</h6>
                    <p class="card-text text-muted small">Generate user reports based on performance metrics and
                        role effectiveness.</p>
                    <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                        data-bs-target="#userPerformanceReportModal">Generate Report</button>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Responsive Table for Users -->
<div class="container">
    <div class="table-responsive mt-4">
        <table id="dataTable" class="table table-bordered table-hover table-sm shadow-sm table-nowrap">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>USER ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $users = $DB->SELECT("users", "*", "ORDER BY id DESC");
                foreach ($users as $user) {
                ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $user['user_id']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['firstname']; ?></td>
                        <td><?= $user['lastname']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td><?= $user['contact']; ?></td>
                        <td><?= $user['role']; ?></td>
                        <td>
                            <?php if ($user['status'] == "Active") { ?>
                                <span class="badge bg-success">Active</span>
                            <?php } else if ($user['status'] == "Inactive") { ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php } else { ?>
                                <span class="badge bg-secondary">Pending</span>
                            <?php } ?>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-primary btnEditUser"
                                    data-user_id=" <?= $user['user_id'] ?>">Edit</button>
                                <button class="btn btn-sm btn-success activateUser"
                                    data-id="<?= $user['id'] ?>">Activate</button>
                                <button class="btn btn-sm btn-danger deactivateUser"
                                    data-id="<?= $user['id'] ?>">Deactivate</button>
                                <button class="btn btn-sm btn-warning removeUser" data-id="<?= $user['id'] ?>">Remove</button>
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

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
    // Open Add User Modal
    $('#btnAddUser').click(function() {
        $.post('api/user/create_modal.php', function(res) {
            $('#responseModal').html(res);
            $('#addUserModal').modal('show');
        });
    });

    $('.btnEditUser').click(function() {
        const user_id = $(this).data('user_id');
        $.post('api/user/edit_modal.php', {
            user_id: user_id
        }, function(res) {
            $('#responseModal').html(res);
            $('#editUserModal').modal('show');
        });
    });;



    // Activate User
    $('.activateUser').click(function() {
        const id = $(this).data('id');
        $.post('api/user/activate.php', {
            id: id
        }, function(res) {
            $('#response').html(res);
        });
    });

    // Deactivate User
    $('.deactivateUser').click(function() {
        const id = $(this).data('id');
        $.post('api/user/deactivate.php', {
            id: id
        }, function(res) {
            $('#response').html(res);
        });
    });

    // Remove User
    $('.removeUser').click(function() {
        const id = $(this).data('id');
        $.post('api/user/remove.php', {
            id: id
        }, function(res) {
            $('#response').html(res);
        });
    });
</script>