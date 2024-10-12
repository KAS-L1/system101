<?php

// Check if session variables are set or set default values
$firstname = isset($_SESSION['firstname']) ? $_SESSION['firstname'] : '';
$lastname = isset($_SESSION['lastname']) ? $_SESSION['lastname'] : '';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$contact = isset($_SESSION['contact']) ? $_SESSION['contact'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$aboutMe = isset($_SESSION['aboutMe']) ? $_SESSION['aboutMe'] : '';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; // Ensure session has user_id

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
                    <h4 class="mb-0" id="profile-name"><?= CHARS($firstname . ' ' . $lastname) ?></h4>
                    <small class="text-muted">Account type: <strong id="profile-role"><?= CHARS($role) ?></strong></small>
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
                    <form id="accountSettingsForm" method="POST" action="update.php">
                        <!-- Use the session user_id for hidden user_id field -->
                        <input type="hidden" name="user_id" value="<?= CHARS($user_id) ?>">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <!-- Prepopulate the firstname field with session data -->
                                <input type="text" id="firstName" name="firstname" class="form-control rounded-3"
                                    value="<?= CHARS($firstname) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <!-- Prepopulate the lastname field with session data -->
                                <input type="text" id="lastName" name="lastname" class="form-control rounded-3"
                                    value="<?= CHARS($lastname) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <!-- Prepopulate the email field with session data -->
                                <input type="email" id="email" name="email" class="form-control rounded-3"
                                    value="<?= CHARS($email) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <!-- Prepopulate the contact field with session data -->
                                <input type="text" id="contact" name="contact" class="form-control rounded-3"
                                    value="<?= CHARS($contact) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <!-- Prepopulate the address field with session data -->
                                <input type="text" id="address" name="address" class="form-control rounded-3"
                                    value="<?= CHARS($address) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="aboutMe" class="form-label">About Me</label>
                            <!-- Prepopulate the aboutMe field with session data -->
                            <textarea id="aboutMe" name="aboutMe" class="form-control rounded-3" rows="3" placeholder="Tell something about yourself in 150 characters!"><?= CHARS($aboutMe) ?></textarea>
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
                    <form id="passwordChangeForm" method="POST" action="/api/profile-setting/reset-password.php">
                        <!-- Use the session user_id for hidden user_id field -->
                        <input type="hidden" name="user_id" value="<?= CHARS($user_id) ?>">

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

            <!-- Security Settings Section -->
            <div class="card mt-4 shadow-sm rounded-3">
                <div class="card-header bg-light rounded-top-3">
                    <h5 class="mb-0">Security Settings</h5>
                    <small class="text-muted">Manage additional security features</small>
                </div>
                <div class="card-body">
                    <!-- Enable Two-Factor Authentication (2FA) -->
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="enable2FA" name="enable2FA">
                        <label class="form-check-label" for="enable2FA">Enable Two-Factor Authentication (2FA)</label>
                    </div>

                    <!-- Security Questions -->
                    <div class="mb-3">
                        <label for="securityQuestion1" class="form-label">Security Question 1</label>
                        <input type="text" id="securityQuestion1" class="form-control rounded-3" placeholder="Your first pet's name?">
                    </div>

                    <div class="mb-3">
                        <label for="securityQuestion2" class="form-label">Security Question 2</label>
                        <input type="text" id="securityQuestion2" class="form-control rounded-3" placeholder="Mother's maiden name?">
                    </div>

                    <!-- Login Activity -->
                    <div class="mb-3">
                        <label class="form-label">Recent Login Activity</label>
                        <ul class="list-group rounded-3">
                            <li class="list-group-item">Last Login: 2024-10-09 18:45 from 192.168.1.10</li>
                            <li class="list-group-item">Previous Login: 2024-10-08 16:30 from 192.168.1.11</li>
                        </ul>
                    </div>

                    <button type="button" class="btn btn-success rounded-3 shadow-sm">Save Security Settings</button>
                </div>
            </div>
        </div>
    </div>
</div>
