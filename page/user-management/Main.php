<!-- User Management Cards -->
<div class="container mt-4 py-5">
    <div class="row text-center">
        <!-- Add User Card -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-2x text-info mb-3"></i>
                    <h6 class="card-title">Add User</h6>
                    <p class="card-text text-muted small">Add new user information, including contact details and
                        role.</p>
                    <button id="btnAddUser" class="btn btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">Add User</button>
                </div>
            </div>
        </div>

        <!-- View Users -->
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <i class="fas fa-id-card fa-2x text-info mb-3"></i>
                    <h6 class="card-title">View User Profiles</h6>
                    <p class="card-text text-muted small">Access detailed user information, including contact
                        details and roles.</p>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
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

<!-- Modal: Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add User Form -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group mb-3">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group mb-3">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="firstname" name="firstname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_contact">Contact Number:</label>
                        <input type="text" class="form-control" id="user_contact" name="user_contact">
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_role">User Role:</label>
                        <select class="form-control" id="user_role" name="user_role">
                            <option value="ADMIN">Admin</option>
                            <option value="LOGISTIC">Logistic</option>
                            <option value="FINANCE">Finance</option>
                            <option value="STAFF">Staff</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add_user">Add User</button>
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
                    <th>ID</th>
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
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['username']; ?></td>
                    <td><?= $user['firstname']; ?></td>
                    <td><?= $user['lastname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['contact']; ?></td>
                    <td><?= $user['role']; ?></td>
                    <td>
                        <?php if($user['status'] == "Active"){ ?>
                        <span class="badge bg-success">Active</span>
                        <?php } else if($user['status'] == "Inactive"){ ?>
                        <span class="badge bg-danger">Inactive</span>
                        <?php } else { ?>
                        <span class="badge bg-secondary">Pending</span>
                        <?php } ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary editUser" data-id="<?= $user['id'] ?>">Edit</button>
                            <button class="btn btn-sm btn-success activateUser"
                                data-id="<?=$user['id']?>">Activate</button>
                            <button class="btn btn-sm btn-danger deactivateUser"
                                data-id="<?=$user['id']?>">Deactivate</button>
                            <button class="btn btn-sm btn-warning removeUser" data-id="<?=$user['id']?>">Remove</button>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Handling Modals and AJAX Requests -->
<script>
// Open Add User Modal
$('#btnAddUser').click(function() {
    $.post('api/user/create_modal.php', function(res) {
        $('#responseModal').html(res);
        $('#addUserModal').modal('show');
    });
});

// Edit User Modal
$('.editUser').click(function() {
    const id = $(this).data('id');
    $.post('api/user/edit_modal.php', {
        id: id
    }, function(res) {
        $('#responseModal').html(res);
        $('#editUserModal').modal('show');
    });
});

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