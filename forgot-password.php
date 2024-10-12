<?php require("app/init.php") ?>
<?php if(isset($_COOKIE['_usertoken'])) redirectUrl("/dashboard?res=redirect-login") ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?=APP_NAME?> | Password Recovery</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div id="layoutAuthentication" class="container d-flex justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="card shadow-lg border-0 rounded-lg">
                     <div class="card-header d-flex align-items-center justify-content-start"">
                        <img src="<?= APP_LOGO ?>" alt="Logo" class="ms-5" style="height: 40px;">
                        <h3 class="my-0 ms-2">Password Discovery</h3>
                    </div>
                    <div class="card-body">
                        <div id="response" class="small"></div>
                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link to reset your password.</div>
                        <form id="formForgotPassword">
                            <div class="form-floating mb-3">
                                <input type="email" id="email" name="email" class="form-control" placeholder="your email" />
                                <label for="email">Email</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small text-success" href="login.php">Return to login</a>
                                <button type="submit" class="btn btn-success">Reset Password</button>
                            </div>
                        </form>
                        <script>
                            $('#formForgotPassword').submit(function(e){
                                e.preventDefault();
                                var formData = $(this).serialize();
                                $.post("api/auth/forgot-password.php", formData, function(response){
                                    $('#response').html(response);
                                });                                       
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>