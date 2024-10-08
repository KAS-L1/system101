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

<!-- Modal: View User Profile -->
<div class="modal fade" id="viewUserProfileModal" tabindex="-1" aria-labelledby="viewUserProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserProfileModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- User Profile Table -->
                <div class="table-responsive mt-4">
                    <table id="dataTable" class="table table-bordered table-hover table-sm">
                        <thead class="table text-success">
                            <tr>
                                <th>#</th>
                                <th>User Id</th>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Address</th>
                                <th>User Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $i = 1; 
                        $users = $DB->SELECT('users', '*'); 
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
                                <td><?= $user['address']; ?></td>
                                <td><?= $user['role']; ?></td>
                                <td><?= $user['status']; ?></td>
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

<!-- Responsive Table for Users -->
<div class="container">
    <div class="table-responsive mt-4">
        <table id="dataTable" class="table table-bordered table-hover table-sm shadow-sm table-nowrap">
            <thead class="thead-light text-success">
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
                        <?php if($user['status'] == "Active"){ ?>
                        <span class="badge bg-success">Active</span>
                        <?php } else if($user['status'] == "Deactivated"){ ?>
                        <span class="badge bg-danger">Deactivated</span>
                        <?php } else { ?>
                        <span class="badge bg-secondary">Pending</span>
                        <?php } ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-light shadow-sm btnEditUser"
                                data-user_id=" <?= $user['user_id'] ?>"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-success shadow-sm btnActivateUser"
                                data-user_id="<?=$user['user_id']?>"><i class="bi bi-check-circle"></i></button>
                            <button class="btn btn-sm btn-danger shadow-sm btnDeactivateUser"
                                data-user_id="<?=$user['user_id']?>"><i class="bi bi-x-circle"></i></button>
                            <button class="btn btn-sm btn-warning shadow-sm btnRemoveUser"
                                data-user_id="<?=$user['user_id']?>"><i class="bi bi-trash"></i></button>
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
$('.btnActivateUser').click(function() {
    const user_id = $(this).data('user_id');
    $.post('api/user/active.php', {
        user_id: user_id
    }, function(res) {
        $('#response').html(res);
    });
});

// Deactivate User
$('.btnDeactivateUser').click(function() {
    const user_id = $(this).data('user_id');
    $.post('api/user/deactivate.php', {
        user_id: user_id
    }, function(res) {
        $('#response').html(res);
    });
});

// Remove User
$('.btnRemoveUser').click(function() {
    const user_id = $(this).data('user_id');
    $.post('api/user/remove.php', {
        user_id: user_id
    }, function(res) {
        $('#response').html(res);
    });
});
</script>