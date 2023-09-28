<?php
session_start();
require_once "./template/header.php";
require_once "./template/utilities.php";

notLogin();

$conn = database("localhost","to_do_list","root","");


?>

<?php
    // old data
    $sql = "SELECT * FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":id" => $_GET['id']
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $currentUserId = userId();
    block($row['user_id'],$currentUserId);
?>

<?php
    // edit data
    if(isset($_POST['editBtn'])){
        $status = true;
        if(empty($_POST['title']) || $_POST['title'] == ""){
            setcookie('emptyEditTitle',"You need to fill list title.");
            $status = false;
        }
        if(empty($_POST['deadline']) || $_POST['deadline'] == ""){
            setcookie('emptyEditDeadline',"You need to fill list deadline.");
            $status = false;
        }

        if($status){
            $sql = "UPDATE tasks SET title = :title, deadline = :deadline WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":title" => $_POST['title'],
                ":deadline" => $_POST['deadline'],
                ":id" => $_POST['id']
            ]);

            setcookie('success',"You have edited a list.");
            setcookie("oldTitle","",time() - 3600);
            setcookie("oldDeadline","",time() - 3600);
            header("Location: ./dashboard.php");
        }else{
            setcookie("oldTitle",$_POST['title']);
            setcookie("oldDeadline",$_POST['deadline']);
            header("Location: ./edit.php?id={$_POST['id']}" );
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
                    Edit List
                </div>
                <div class="card-body">
                    <form action="./edit.php" method="POST">
                        <!-- get list id if $status is false -->
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <!-- $row['title'] -->
                            <input type="text" name="title" class="form-control" value="<?php
                                if(isset($_COOKIE['oldTitle'])){
                                    echo htmlentities($_COOKIE['oldTitle']);
                                }elseif(isset($row['title'])){
                                    echo htmlentities($row['title']);
                                }
                            ?>" id="title" placeholder="Enter your list...">
                            <p class="text-danger">
                                <?php flash("emptyEditTitle") ?>
                            </p>
                        </div>
                        <div class="form-group mt-3">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control" value="<?php if(isset($_COOKIE['oldDeadline'])){
                                    echo htmlentities($_COOKIE['oldDeadline']);
                                }elseif(isset($row['deadline'])){
                                    echo htmlentities($row['deadline']);
                                } ?>" id="deadline" placeholder="Enter list deadline...">
                            <p class="text-danger">
                            <?php flash("emptyEditDeadline") ?>
                            </p>
                        </div>
                        <input type="submit" name="editBtn" class="btn btn-primary mt-3 w-100" value="Edit" />
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php
    require_once "./template/footer.php"
?>