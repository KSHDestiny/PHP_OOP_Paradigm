<?php
    require_once("./template/utilities.php");
    session_start();

    $conn = database("localhost","to_do_list","root","");
?>

<?php
    if(isset($_POST['login'])){
        $status = true;

        // empty email
        if(!isset($_POST['userEmail']) || $_POST['userEmail'] == ""){
            $status = false;
            setcookie("emptyEmail", "You need to fill your email.");
        }

        // empyt pasword
        if(!isset($_POST['userPassword']) || $_POST['userPassword'] == ""){
            $status = false;
            setcookie("emptyPassword", "You need to fill your password.");
        }

        if($status){
            
            $sql = "SELECT password FROM users WHERE email = :email";
            $statement = $conn->prepare($sql);
            $statement->execute([
                ":email" => $_POST['userEmail']
            ]);

            $row = $statement->fetch(PDO::FETCH_ASSOC);

            if(password_verify($_POST['userPassword'], $row['password'])){
                // delete old email
                // setcookie("oldEmail","", time() - 3600);

                 // store session for login
                $_SESSION['token'] = rand(0000000,9999999) . "_" . $_POST['userEmail'] . rand(0000000,9999999);

                // store cookie for login
                setcookie('token',$_SESSION['token'], time() + (3600 * 24));

                // get id from user table
                $sql = "SELECT id FROM users WHERE email = :email";
                $statement = $conn->prepare($sql);
                $statement->execute(([
                    ":email" => $_POST['userEmail']
                ]));
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                // store user id in cookie
                setcookie('userId',rand(0000000,9999999). $user['id'] . rand(0000000000,9999999999), time() + (3600 * 24));

                header("Location: ./dashboard.php");
            }else{
                // wrong password
                setcookie("wrongPassword","Wrong Password");

                // old email
                setcookie("oldEmail",$_POST['userEmail']);

                header("Location: ./index.php");
            }
        }else{
            // old email
            setcookie("oldEmail",$_POST['userEmail']);
            
            // empty data
            header("Location: ./index.php");
        }
    }
?>