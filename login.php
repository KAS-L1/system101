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
        <title><?=APP_NAME?> | Login</title>
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
                        <h3 class="my-0 ms-1">Login to <?=APP_NAME?></h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_GET['res']) AND $_GET['res'] == "password-reset"){ ?>
                            <div class="alert alert-success">
                                Password successfully reset. Try to login with your new password.
                            </div>
                        <?php } ?>
                        <div id="response" class="small"></div>
                        <form id="formLogin">
                            <div class="form-floating mb-3">
                                <input type="text" id="username" name="username" class="form-control" placeholder="Username" />
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" />
                                <label for="password">Password</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember"/>
                                <label class="form-check-label" for="remember">Remember Password</label>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small text-success" href="forgot-password">Forgot Password?</a>
                                <button class="btn btn-success">Login</button>
                            </div>
                        </form>
                        <script>
                            $('#formLogin').submit(function(e){
                                e.preventDefault();
                                var formData = $(this).serialize();
                                $.post("api/auth/login.php", formData, function(response){
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