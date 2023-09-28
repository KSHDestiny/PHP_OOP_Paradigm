<?php 
session_start();
require_once "./template/utilities.php";
require_once "./template/header.php";

notLogin();
?>

<?php
    $conn = database("localhost","to_do_list","root","");
    $userId = userId();

    $sql = "SELECT * FROM tasks WHERE user_id = :userId";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ":userId" => $userId
    ]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <section class="min-vh-100 container-fluid container-md pt-7">
        <div class="pt-9 pt-md-6 mx-3">
        <p class="text-success text-center">
            <?php
                flash("success")
            ?>
        </p>
            <h3 class="text-secondary display-6">To do Lists</h3>
            <table class="table table-striped">
                <thead>
                    <tr class="row">
                        <th class="text-secondary col-4">Title</th>
                        <th class="text-secondary col-4">Deadline</th>
                        <th class="text-secondary col-2">Done</th>
                        <th class="text-secondary col-2">Option</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php
                        foreach($rows as $row){
                            if($row['done'] == 1){
                                $lineThrough = "text-decoration-line-through";
                                $checked = "checked";
                            }else{
                                $lineThrough = "";
                                $checked = "";
                            }

                            $deadline = date("M-d-o",strtotime($row['deadline']));
                            echo "
                            <tr class='row $lineThrough'>
                                <td class='text-secondary col-4'>{$row['title']}</td>
                                <td class='text-secondary col-4'>$deadline</td>
                                <td class='ps-4 col-2'>
                                    <input type='checkbox' name='' class='form-check' id='{$row['id']}' $checked>
                                </td>
                                <td class='text-secondary col-2 d-flex'>
                                    <a href='edit.php?id={$row['id']}'>
                                        <i class='bi bi-pencil-square me-3 text-secondary'></i>
                                    </a>
                                    <i class='bi bi-trash'></i>
                                    <form action='delete.php' method='POST'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                    </form>
                                </td>
                            </tr>
                            ";
                        }
                    ?>

                </tbody>
            </table>
        </div>
    </section>

    <script src="./node_modules/jquery/dist/jquery.min.js"></script>;
    <script src="./assets/js/app.js"></script>
<?php
    require_once "./template/footer.php"
?>