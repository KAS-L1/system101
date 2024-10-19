<?php

?>

<div class="container my-5">
    <!-- Profile Header -->
    <div class="profile-header text-center">
        <!-- Profile Picture Wrapper -->
        <div class="position-relative d-inline-block">
            <!-- Profile Picture -->
            <?php
            if (!empty(AUTH_USER['profile_pic'])) {
                $profilePic = '../../assets/uploads/' . AUTH_USER['profile_pic'];
            } else {
                $profilePic = '../../assets/img/default_profile_picture.png';  // Default image if not uploaded
            }
            ?>
            <img id="profilePic" src="<?= $profilePic; ?>" alt="Profile Picture" class="rounded-circle profile-pic shadow-sm"
                style="width: 150px; height: 150px; object-fit: cover; border: 5px solid white;">

            <!-- Camera Icon Overlay (Updated for success color and better positioning) -->
            <div class="camera-icon-wrapper position-absolute bottom-0 end-0 bg-light text-success rounded-circle p-3 shadow-sm"
                style="cursor: pointer; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                <i class="bi bi-camera-fill"></i>
                <input type="file" id="profilePicInput" name="profilePicture" style="display: none;" />
            </div>
        </div>

        <!-- Profile Name -->
        <div class="mt-3">
            <h3 class="mb-0"><?= CHARS(AUTH_USER['firstname']) . " " . CHARS(AUTH_USER['lastname']); ?></h3>
            <p class="text-muted mb-0"><?= CHARS(AUTH_USER['role']); ?></p>
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
                    <form id="accountSettingsForm" enctype="multipart/form-data">
                        <!-- Use the session user_id for hidden user_id field -->
                        <input type="hidden" name="user_id" value="<?= CHARS(AUTH_USER['user_id']); ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" id="firstName" name="firstname" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['firstname']); ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" id="lastName" name="lastname" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['lastname']); ?>" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">User Name</label>
                                <input type="text" id="userName" name="username" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['username']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['email']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" id="contact" name="contact" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['contact']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control rounded-3"
                                    value="<?= CHARS(AUTH_USER['address']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="aboutMe" class="form-label">About Me</label>
                            <!-- Prepopulate the aboutMe field with session data -->
                            <textarea id="aboutMe" name="aboutMe" class="form-control rounded-3" rows="3" placeholder="Tell something about yourself!"><?= CHARS(AUTH_USER['about_me']) ?></textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success rounded-3 shadow-sm" id="saveChanges">Save changes</button>
                        </div>
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
                        <input type="hidden" name="user_id" value="<?= CHARS(AUTH_USER['user_id']); ?>">

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
                        <div class="text-end">
                            <button type="submit" class="btn btn-success rounded-3 shadow-sm" id="changePasswordBtn">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="response"></div>

<!-- JavaScript for Handling the Form Submission and Preview -->
<script>
    // Trigger file input when camera icon is clicked
    document.querySelector('.camera-icon-wrapper').addEventListener('click', function() {
        document.getElementById('profilePicInput').click();
    });

    // Preview the uploaded profile picture
    document.getElementById('profilePicInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePic').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Submit the account settings form with AJAX
    $('#accountSettingsForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Create a new FormData object and append the form fields
        var formData = new FormData(this);

        // Append the profile picture file if selected
        var profilePicInput = document.getElementById('profilePicInput');
        if (profilePicInput.files.length > 0) {
            formData.append('profilePicture', profilePicInput.files[0]);
        }

        $.ajax({
            type: 'POST',
            url: 'api/profile-setting/update_form.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#response').html(response); // Display response
            },
            error: function(xhr, status, error) {
                $('#response').html('<div class="alert alert-danger">An error occurred while saving the changes. Please try again later.</div>');
            }
        });
    });

    // Submit the change password form
    $('#formChangePassword').submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        var formData = $(this).serialize();
        $.post("api/profile-setting/change_password.php", formData, function(response) {
            $('#response').html(response); // Display response
        });
    });
</script>