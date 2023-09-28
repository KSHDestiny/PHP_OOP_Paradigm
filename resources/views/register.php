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
    <link rel="stylesheet" href="../../node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
</head>
<body>
    <main class="bg-image min-vh-100">
        <section>
            <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
                <div class="container-sm-fluid container-md">
                    <a class="navbar-brand text-primary" href="#">CRUD Project with pure PHP</a>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="/application/index.php/index">Login</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </section>


        <section class="vh-100 row align-items-center g-0">
            <div class="col-8 col-md-6 col-lg-5 mx-auto">
                <div class="card text-primary">
                    <div class="card-header text-center h3">
                        Register Form
                    </div>
                    <div class="card-body">
                        <form action="/application/index.php/register" method="POST">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php
                                    oldData("oldRegisterName")
                                ?>" placeholder="Enter your Name...">
                                <p class="text-danger">
                                    <?php
                                        flash("emptyName");
                                    ?>
                                </p>
                            </div>
                            <div class="form-group mt-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php
                                    oldData("oldRegisterEmail");
                                ?>" placeholder="Enter your Email...">
                                <p class="text-danger">
                                    <?php
                                        flash("emptyEmail");

                                        flash("sameEmail");
                                    ?>
                                </p>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" value="" class="form-control" placeholder="Enter your Password...">
                                <p class="text-danger">
                                    <?php
                                        if(isset($_COOKIE['emptyPassword'])){
                                            echo $_COOKIE['emptyPassword'];
                                            setcookie('emptyPassword',"",time() - 3600);
                                        }elseif(isset($_COOKIE['weakPassword'])){
                                            echo $_COOKIE['weakPassword'];
                                            setcookie('weakPassword',"",time() - 3600);
                                        }
                                    ?>
                                </p>
                            </div>
                            <div class="form-group mt-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" value="" class="form-control" placeholder="Confirm Password...">
                                <p class="text-danger">
                                    <?php
                                        flash("notMatchPassword");
                                    ?>
                                </p>
                            </div>
                            <input type="submit" name="register" class="btn btn-primary mt-3 w-100" value="Register" />
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

<script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>