<?php
session_start();
require_once "./template/header.php";
require_once "./template/utilities.php";

notLogin();

$conn = database("localhost","to_do_list","root","");

?>

<?php
    if(isset($_POST['createBtn'])){
        $status = true;

        if(empty($_POST['title']) || $_POST['title'] == ""){
            setcookie("emptyTitle", "You need to fill list title.");
            $status = false;
        }

        if(empty($_POST['deadline']) || $_POST['deadline'] == ""){
            setcookie("emptyDeadline", "You need to fill list deadline.");
            $status = false;
        }

        if($status){
            $userId = userId();

            $sql = "INSERT INTO tasks (user_id,title,deadline) VALUES (:userId,:title,:deadline)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":userId" => $userId,
                ":title" => $_POST['title'],
                ":deadline" => $_POST['deadline']
            ]);

            setcookie("oldCreateTitle","");
            setcookie("success","You have successfully created a list!");
            header("Location: ./dashboard.php");
        }else{
            setcookie("oldCreateTitle",$_POST['title']);
            header("Location: ./create.php");
        }
    }
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
                            <a class="nav-link active text-primary" aria-current="page" href="./dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="./create.php">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="./logout.php">Logout</a>
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
                    Create List
                </div>
                <div class="card-body">
                    <form action="./create.php" method="POST">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter your list..." value="<?php oldData('oldCreateTitle') ?>">
                            <p class="text-danger">
                                <?php flash("emptyTitle") ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control" id="deadline" placeholder="Enter list deadline...">
                            <p class="text-danger">
                            <?php flash("emptyDeadline") ?>
                            </p>
                        </div>
                        <input type="submit" name="createBtn" class="btn btn-primary mt-3 w-100" value="Create" />
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php
    require_once "./template/footer.php"
?>