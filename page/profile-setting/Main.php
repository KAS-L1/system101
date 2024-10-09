<div class="container my-5">
    <!-- Profile Header -->
    <div class="card mb-4 shadow-sm rounded-3">
        <div class="card-body text-center rounded-3 bg-light">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <img src="/assets/img/malupiton.jpg" alt="Profile Picture" class="rounded-circle shadow-sm"
                    style="width: 100px; height: 100px;">
                <div class="ms-3">
                    <h4 class="mb-0" id="profile-name">Adela Parkson</h4>
                    <small class="text-muted">Account type: <strong id="profile-role">Administrator</strong></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Account Settings -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-header  rounded-top-3 bg-light">
                    <h5 class="mb-0">Account Settings</h5>
                    <small class="text-muted">Here you can change your account information</small>
                </div>

                <div class="card-body">
                    <form id="accountSettingsForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username*</label>
                                <input type="text" id="username" name="username" class="form-control rounded-3"
                                    value="@parkson.adela">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address*</label>
                                <input type="email" id="email" name="email" class="form-control rounded-3"
                                    value="adela@simmymple.com">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" id="firstName" name="firstname" class="form-control rounded-3"
                                    value="Adela" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" id="lastName" name="lastname" class="form-control rounded-3"
                                    value="Parkson" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" id="contact" name="contact" class="form-control rounded-3"
                                    value="+1234567890">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control rounded-3"
                                    value="1234 Main St, Cityville">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select rounded-3">
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Pending">Pending</option>
                                <option value="Deactivated">Deactivated</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="aboutMe" class="form-label">About Me</label>
                            <textarea id="aboutMe" name="aboutMe" class="form-control rounded-3" rows="3"
                                placeholder="Tell something about yourself in 150 characters!">Hello! I'm Adela Parkson, an administrator at Paradise Hotel Logistics.</textarea>
                        </div>
                        <button type="button" class="btn btn-success rounded-3 shadow-sm" id="saveChanges">Save
                            changes</button>
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
                    <form id="passwordChangeForm">
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input type="password" id="oldPassword" name="oldPassword" class="form-control rounded-3"
                                placeholder="Old Password">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" id="newPassword" name="newPassword" class="form-control rounded-3"
                                placeholder="New Password">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword"
                                class="form-control rounded-3" placeholder="Confirm New Password">
                        </div>
                        <button type="button" class="btn btn-success rounded-3 shadow-sm" id="changePasswordBtn">Change
                            Password</button>
                    </form>
                </div>
            </div>

            <!-- Security Settings Card (Separate) -->
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
                        <input type="text" id="securityQuestion1" class="form-control rounded-3"
                            placeholder="Your first pet's name?">
                    </div>
                    <div class="mb-3">
                        <label for="securityQuestion2" class="form-label">Security Question 2</label>
                        <input type="text" id="securityQuestion2" class="form-control rounded-3"
                            placeholder="Mother's maiden name?">
                    </div>
                    <!-- Login Activity -->
                    <div class="mb-3">
                        <label class="form-label">Recent Login Activity</label>
                        <ul class="list-group rounded-3">
                            <li class="list-group-item">Last Login: 2024-10-09 18:45 from 192.168.1.10</li>
                            <li class="list-group-item">Previous Login: 2024-10-08 16:30 from 192.168.1.11</li>
                        </ul>
                    </div>
                    <!-- Save Security Settings Button -->
                    <button type="button" class="btn btn-success rounded-3 shadow-sm">Save Security Settings</button>
                </div>
            </div>
        </div>
    </div>
</div>