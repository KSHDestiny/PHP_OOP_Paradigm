<?php
    require_once __DIR__ . "/../template/utilities.php";
    login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
</head>
<body>
    <main class="bg-image min-vh-100">
        <section>
                <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
                    <div class="container-sm-fluid container-md">
                        <a class="navbar-brand text-primary" href="#">CRUD Project with pure PHP</a>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link text-primary" href="/application/index.php/registerPage">Register</a>
                            </li>
                        </ul>
                    </div>
                </nav>
        </section>


        <section class="vh-100 row align-items-center g-0">
            <div class="col-8 col-md-6 col-lg-5 mx-auto">
                <div class="card text-primary">
                    <div class="card-header text-center h3">
                        Login Form
                    </div>
                    <div class="card-body">
                        <form action="/application/index.php/login" method="POST">
                            <div class="form-group">
                                <label for="" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" value="<?php
                                    oldData("oldEmail");
                                ?>" placeholder="Enter your Email...">
                                <p class="text-danger">
                                <?php
                                    flash("emptyEmail");
                                ?>
                                </p>
                            </div>
                            <div class="form-group mt-3">
                                <label for="" class="form-label">Password</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="Enter your Password...">
                                <p class="text-danger">
                                <?php
                                    flash("emptyPassword");

                                    flash("wrongPassword");
                                ?>
                                </p>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary mt-3 w-100" value="Login" />
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>