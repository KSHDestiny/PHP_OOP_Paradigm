<?php
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
        ":id" => $_POST['id']
    ]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $currentUserId = userId();

    if($row['user_id'] != $currentUserId){
        block($row['user_id'],$currentUserId);
    }else{
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
    
        setcookie('success',"You have deleted a list.");
        header("Location: ./dashboard.php");
    }


?>

<?php 

?>