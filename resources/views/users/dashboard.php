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
                        foreach($tasks as $task){
                            if($task['done'] == 1){
                                $lineThrough = "text-decoration-line-through";
                                $checked = "checked";
                            }else{
                                $lineThrough = "";
                                $checked = "";
                            }

                            $deadline = htmlentities(date("M-d-o",strtotime($task['deadline'])));
                            $title = htmlentities($task['title']);
                            $id = htmlentities($task['id']);

                            echo "
                            <tr class='row $lineThrough'>
                                <td class='text-secondary col-4'>$title</td>
                                <td class='text-secondary col-4'>$deadline</td>
                                <td class='ps-4 col-2'>
                                    <input type='checkbox' name='' class='form-check' id='$id' $checked>
                                </td>
                                <td class='text-secondary col-2 d-flex'>
                                    <a href='/application/index.php/users/edit?id=$id'>
                                        <i class='bi bi-pencil-square me-3'></i>
                                    </a>
                                    <i class='bi bi-trash'></i>
                                    <form action='/application/index.php/users/delete' method='POST'>
                                        <input type='hidden' name='id' value='$id'>
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

    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <!-- <script src="../assets/js/app.js"></script> -->
    <script>
        $(document).ready(function(){
            $(".bi-trash").click((e)=>{
                let sureDelete = confirm("Are you sure you want to delete?");
                if(sureDelete){
                    e.target.nextElementSibling.submit();
                }
            })

            $(".form-check").click((e)=>{
                let checked = e.target.checked;
                checked = checked ? 1 : 0;

                if(checked == 1){
                    e.target.parentElement.parentElement.classList.add("text-decoration-line-through");
                }else{
                    e.target.parentElement.parentElement.classList.remove("text-decoration-line-through");
                }

                let id = e.target.id;

                $.ajax({
                    method: "POST",
                    url: "/application/index.php/users/done",
                    dataType: "json",
                    data: {
                        id : id,
                        checked : checked
                    }
                })
            });
        });
    </script>

<?php
require_once __DIR__ . "/../../template/footer.php"
?>