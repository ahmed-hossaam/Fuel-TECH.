<?php

    session_set_cookie_params((365 * 24 * 60 * 60));

    session_start();

    require "../data.php";

    if (isset($_SESSION["Admin"]) && isset($_SESSION["AdminID"])) {

        header("Location: index.php");
        exit();

    }

    if (isset($_POST["login"])) {

        try {

            $username = strtolower(trim($_POST["username"]));
            $password = $_POST["password"];

            $stmt = $db -> prepare("SELECT * FROM `admins` WHERE `AdminUsername` = :Username");
            $stmt -> execute([
                "Username" => "$username"
            ]);
            
            if (($stmt -> rowCount()) == 1) {

                $stmt = $stmt -> fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $stmt["PasswordHash"])) {

                    $_SESSION["Admin"] = true;
                    $_SESSION["AdminID"] = $stmt["AdminID"];
                    header("Location: index.php");
                    exit();

                }

            }

        } catch (Throwable $error) {}

    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Fuel Tech | Admin Login</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
        
        <link rel="stylesheet" href="CSS/login.css" />

    </head>

    <body>

        <div class="login-container">

            <h2>Admin Login</h2>

            <form action="" method="post" autocomplete="off">

                <input type="text" name="username" placeholder="Username" required>

                <input type="password" name="password" placeholder="Password" required>

                <button type="submit" name="login">Login</button>

            </form>

        </div>

    </body>

</html>