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
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login to <?=APP_NAME?></h3></div>
                                    <div class="card-body">

                                        <?php if(isset($_GET['res']) AND $_GET['res'] == "password-reset"){ ?>
                                            <div class="alert alert-success">
                                                Password successfully reset try to login your new password.
                                            </div>
                                        <?php } ?>

                                        <div id="response" class="small"></div>
                                        <form id="formLogin">
                                            <div class="form-floating mb-3">
                                                <input type="text" id="username" name="username" class="form-control" />
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" id="password" name="password" class="form-control" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="remember" name="remember"/>
                                                <label class="form-check-label" for="remember">Remember Password</label>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="forgot-password">Forgot Password?</a>
                                                <button class="btn btn-primary">Login</button>
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
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright <?=APP_COPYRIGHT?></div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>


