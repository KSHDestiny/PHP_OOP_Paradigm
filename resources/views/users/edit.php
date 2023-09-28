<?php
require_once __DIR__ . "/../../template/header.php";
require_once __DIR__ . "/../../template/utilities.php";

notLogin();
?>

    <section>
        <nav class="navbar navbar-expand-lg bg-transparent fixed-top">
            <div class="container-sm-fluid container-md">
                <a class="navbar-brand text-primary font-script" href="#">CRUD Project with pure PHP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active text-primary" aria-current="page" href="/application/index.php/users/dashboard">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="/application/index.php/users/create">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="/application/index.php/logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </section>

    <section id="createList" class="vh-100 row align-items-center g-0">
        <div class="col-8 col-md-6 col-lg-5 mx-auto">
            <div class="card text-primary">
                <div class="card-header text-center h3">
                    Edit List
                </div>
                <div class="card-body">
                    <form action="/application/index.php/users/update" method="POST">
                        <!-- get list id if $status is false -->
                        <input type="hidden" name="id" value="<?= $task['id'] ?>">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <!-- $task['title'] -->
                            <input type="text" name="title" class="form-control" value="<?php
                                if(isset($_COOKIE['oldTitle'])){
                                    echo htmlentities($_COOKIE['oldTitle']);
                                }elseif(isset($task['title'])){
                                    echo htmlentities($task['title']);
                                }
                            ?>" id="title" placeholder="Enter your list...">
                            <p class="text-danger">
                                <?php flash("emptyTitle") ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control" value="<?php if(isset($_COOKIE['oldDeadline'])){
                                    echo htmlentities($_COOKIE['oldDeadline']);
                                }elseif(isset($task['deadline'])){
                                    echo htmlentities($task['deadline']);
                                } ?>" id="deadline" placeholder="Enter list deadline...">
                            <p class="text-danger">
                            <?php flash("emptyDeadline") ?>
                            </p>
                        </div>
                        <input type="submit" name="editBtn" class="btn btn-primary mt-3 w-100" value="Edit" />
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
require_once __DIR__ . "/../../template/footer.php";
?>