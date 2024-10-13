<?php require("app/init.php"); ?>

<?php

if (isset($_GET['token']) or !empty($_GET['token'])) {
    $where = array('forgot_token' => $_GET['token']);
    $user = $DB->SELECT_ONE_WHERE("users", "*", $where);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Password Reset</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .requirements {
            font-size: 0.9em;
            color: #dc3545;
        }

        .valid {
            color: #28a745;
        }

        .invalid {
            color: #dc3545;
        }
    </style>
</head>

<body class="bg-primary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header d-flex align-items-center justify-content-start"">
                        <img src=" <?= APP_LOGO ?>" alt="Logo" class="" style="height: 40px;">
                        <h3 class="my-0 ms-1">Reset Your Password</h3>
                    </div>
                    <div class="card-body">

                        <?php if (!isset($_GET['token']) or empty($_GET['token'])) { ?>

                            <div class="alert alert-danger text-center">
                                Token is required please check your url
                            </div>

                        <?php } else if (empty($user)) { ?>

                            <div class="alert alert-warning text-center">
                                Token is invalid please check your url
                            </div>

                        <?php } else { ?>

                            <!-- Display any error or success messages here -->
                            <div id="response" class="mb-3"></div>

                            <!-- Password Reset Form -->
                            <form id="formResetPassword">
                                <!-- Hidden field for the token passed via URL -->
                                <input type="hidden" name="token" value="<?= CHARS($_GET['token']) ?>" />

                                <!-- New Password Field -->
                                <div class="form-floating mb-3">
                                    <input type="password" id="newPassword" name="newPassword" class="form-control" placeholder="New Password" required />
                                    <label for="newPassword">New Password</label>
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="form-floating mb-3">
                                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm Password" required />
                                    <label for="confirmPassword">Confirm Password</label>
                                </div>

                                <!-- Password Requirements -->
                                <div class="requirements mb-3">
                                    Password must contain:
                                    <ul>
                                        <li id="minLength" class="invalid">At least 8 characters</li>
                                        <li id="uppercase" class="invalid">At least 1 uppercase letter</li>
                                        <li id="lowercase" class="invalid">At least 1 lowercase letter</li>
                                        <li id="number" class="invalid">At least 1 number</li>
                                        <li id="special" class="invalid">At least 1 special character (e.g., !@#$%^&*)</li>
                                    </ul>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Reset Password</button>
                            </form>
                            <script>
                                $('#formResetPassword').submit(function(e) {
                                    e.preventDefault();
                                    var formData = $(this).serialize();
                                    $.post("api/auth/reset-password.php", formData, function(response) {
                                        $('#response').html(response);
                                    });
                                });
                            </script>

                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>

    <script>
        // JavaScript to validate the password against the requirements
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const submitBtn = document.getElementById('submitBtn');

        const minLength = document.getElementById('minLength');
        const uppercase = document.getElementById('uppercase');
        const lowercase = document.getElementById('lowercase');
        const number = document.getElementById('number');
        const special = document.getElementById('special');

        // Regex patterns to check for each requirement
        const patterns = {
            minLength: /.{8,}/,
            uppercase: /[A-Z]/,
            lowercase: /[a-z]/,
            number: /[0-9]/,
            special: /[!@#$%^&*(),.?":{}|<>]/
        };

        // Function to validate password
        function validatePassword() {
            let isValid = true;

            // Check each requirement and update UI accordingly
            if (patterns.minLength.test(newPassword.value)) {
                minLength.classList.remove('invalid');
                minLength.classList.add('valid');
            } else {
                minLength.classList.remove('valid');
                minLength.classList.add('invalid');
                isValid = false;
            }

            if (patterns.uppercase.test(newPassword.value)) {
                uppercase.classList.remove('invalid');
                uppercase.classList.add('valid');
            } else {
                uppercase.classList.remove('valid');
                uppercase.classList.add('invalid');
                isValid = false;
            }

            if (patterns.lowercase.test(newPassword.value)) {
                lowercase.classList.remove('invalid');
                lowercase.classList.add('valid');
            } else {
                lowercase.classList.remove('valid');
                lowercase.classList.add('invalid');
                isValid = false;
            }

            if (patterns.number.test(newPassword.value)) {
                number.classList.remove('invalid');
                number.classList.add('valid');
            } else {
                number.classList.remove('valid');
                number.classList.add('invalid');
                isValid = false;
            }

            if (patterns.special.test(newPassword.value)) {
                special.classList.remove('invalid');
                special.classList.add('valid');
            } else {
                special.classList.remove('valid');
                special.classList.add('invalid');
                isValid = false;
            }

            // Enable the submit button if all requirements are met
            submitBtn.disabled = !isValid;
        }

        // Listen for input changes on newPassword and confirmPassword fields
        newPassword.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
    </script>
</body>

</html>