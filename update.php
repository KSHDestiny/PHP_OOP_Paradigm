<?php

session_start();
require_once "./template/utilities.php";
notLogin();
$conn = database("localhost","to_do_list","root","");

?>

<?php
    if(isset($_POST['id']) && isset($_POST['checked'])){
        $sql = "UPDATE tasks SET done = :done WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":done" => $_POST['checked'],
            ":id" => $_POST['id']
        ]);
    }
?>