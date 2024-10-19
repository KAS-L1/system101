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
                <form id="formAddUser">
                    <div class="form-group mb-3">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control" id="user_firstname" name="user_firstname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control" id="user_lastname" name="user_lastname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_contact">Contact Number:</label>
                        <input type="tel" class="form-control" id="user_contact" name="user_contact" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_address">Address:</label>
                        <input type="text" class="form-control" id="user_address" name="user_address" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="user_role">User Role:</label>
                        <select id="user_role" name="user_role" class="form-select" required>
                            <option selected disabled>Select role...</option>
                            <option value="ADMIN">ADMIN</option>
                            <option value="LOGISTIC">LOGISTIC</option>
                            <option value="FINANCE">FINANCE</option>
                            <option value="STAFF">STAFF</option>
                            <option value="VENDOR">VENDOR</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="add_user">Add User</button>
                    </div>
                </form>
                <div id="responseCreateUser"></div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Handling the Form Submission -->
<script>
$('#formAddUser').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize();
    $.post("api/user/create.php", formData, function(response) {
        $('#responseCreateUser').html(response); // Display response in the modal
    });
});
</script>