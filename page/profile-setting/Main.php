<?php
?>

<div class="container my-5">
    <!-- Profile Header -->
    <div class="card mb-4 shadow-sm rounded-3">
        <div class="card-body text-center rounded-3 bg-light">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <img src="/assets/img/malupiton.jpg" alt="Profile Picture" class="rounded-circle shadow-sm"
                    style="width: 100px; height: 100px;">
                <div class="ms-3">
                    <!-- Use session variables to show the profile name and role -->
                    <h4 class="mb-0" id="profile-name"><?= CHARS(AUTH_USER['firstname']) . " " . CHARS(AUTH_USER['lastname']) ?>
                    </h4>
                    <small class="text-muted">Account type: <strong id="profile-role"><?= CHARS(AUTH_USER['role']) ?></strong></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Account Settings -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-header rounded-top-3 bg-light">
                    <h5 class="mb-0">Account Settings</h5>
                    <small class="text-muted">Here you can change your account information</small>
                </div>

                <div class="card-body">
                    <form id="accountSettingsForm">
                        <!-- Use the session user_id for hidden user_id field -->
                        <input type="hidden" name="user_id" value="<?= CHARS(AUTH_USER['user_id']) ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <!-- Prepopulate the firstname field with session data -->
                                <input type="text" id="firstName" name="firstname" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['firstname']) ?>" disabled>
                            </div>
                            <div class=" col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <!-- Prepopulate the lastname field with session data -->
                                <input type="text" id="lastName" name="lastname" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['lastname']) ?>" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <!-- Prepopulate the email field with session data -->
                                <input type="email" id="email" name="email" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['email']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <!-- Prepopulate the contact field with session data -->
                                <input type="text" id="contact" name="contact" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['contact']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <!-- Prepopulate the address field with session data -->
                                <input type="text" id="address" name="address" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['address']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="aboutMe" class="form-label">About Me</label>
                            <!-- Prepopulate the aboutMe field with session data -->
                            <textarea id="aboutMe" name="aboutMe" class="form-control rounded-3" rows="3" placeholder="Tell something about yourself in 150 characters!"><?= CHARS(AUTH_USER['about_me']) ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-success rounded-3 shadow-sm" id="saveChanges">Save changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-light rounded-top-3">
                    <h5 class="mb-0">Change Password</h5>
                    <small class="text-muted">Here you can set your new password</small>
                </div>
                <div class="card-body">
                    <form id="formChangePassword">
                        <!-- Use the session user_id for hidden user_id field -->
                        <input type="hidden" name="user_id" value="<?= CHARS(AUTH_USER['user_id']) ?>">

                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input type="password" id="oldPassword" name="oldPassword" class="form-control rounded-3"
                                placeholder="Old Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" id="newPassword" name="newPassword" class="form-control rounded-3"
                                placeholder="New Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword"
                                class="form-control rounded-3" placeholder="Confirm New Password" required>
                        </div>

                        <button type="submit" class="btn btn-success rounded-3 shadow-sm" id="changePasswordBtn">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="response"></div>

<!-- JavaScript for Handling the Form Submission -->
<script>
    $('#formChangePassword').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize();
        $.post("api/profile-setting/change_password.php", formData, function(response) {
            $('#response').html(response); // Display response in the modal
        });
    });

    $('#accountSettingsForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        var formData = $(this).serialize();
        $.post("api/profile-setting/update_form.php", formData, function(response) {
            $('#response').html(response); // Display response in the modal
        });
    });
</script>