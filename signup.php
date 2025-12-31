<?php

    session_set_cookie_params((365 * 24 * 60 * 60), "/", "", true, true);
    session_start();

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {

        header("Location: index.php");

    }

    require "data.php";

    if (isset($_POST["signup"])) {

        $username = trim(strtolower($_POST["username"]));

        $email = trim($_POST["email"]);

        $password = $_POST["password"];

        $c_password = $_POST["c_password"];

        $username_exists = $db -> query("SELECT * FROM `users` WHERE `username`='$username'");

        $email_exists = $db -> query("SELECT * FROM `users` WHERE `email`='$email'");

        if (($username_exists -> rowCount()) == 0) {

            if (($email_exists -> rowCount()) == 0) {

                    if ($password == $c_password) {

                        $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_DEFAULT);

                        $stmt = $db -> prepare("INSERT INTO `users`(`Username`, `PasswordHash`, `Email`) VALUES(:Username, :PasswordHash, :Email)");

                        $stmt -> execute([

                            "Username" => $username,

                            "PasswordHash" => $password,

                            "Email" => $email,

                        ]);

                        $stmt = $db -> query("SELECT * FROM `users` WHERE Username = '$username'");

                        $ID = ($stmt -> fetchAll(PDO::FETCH_ASSOC)[0]["UserID"]);

                        $_SESSION["UserID"] = $ID;

                        header("Location: verify.php");

                        exit();

                    } else {

                echo <<<multi
                    <script>

                        document.addEventListener("DOMContentLoaded", () => {

                            Swal.fire({
                                title: 'Error!',
                                text: `Passwords Doesn't Match.`,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: {
                                    container: 'my-swal-container',
                                    popup: 'my-swal-popup',
                                    content: 'my-swal-content'
                                },
                                    backdrop: `
                                        rgba(0,0,0,0.4)
                                    `,
                                    heightAuto: false,
                                    allowOutsideClick: false,
                                    scrollbarPadding: false
                                })

                            });

                    </script>
                multi;

                    }

            } else {

                echo <<<multi
                    <script>

                        document.addEventListener("DOMContentLoaded", () => {

                            Swal.fire({
                                title: 'Error!',
                                text: `This Email Is Already Exists.`,
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: {
                                    container: 'my-swal-container',
                                    popup: 'my-swal-popup',
                                    content: 'my-swal-content'
                                },
                                    backdrop: 
                                        rgba(0,0,0,0.4)
                                    `,
                                    heightAuto: false,
                                    allowOutsideClick: false,
                                    scrollbarPadding: false
                                })

                            });

                    </script>
                multi;

            }

        } else {

            echo <<<multi
                <script>

                    document.addEventListener("DOMContentLoaded", () => {

                        Swal.fire({
                            title: 'Error!',
                            text: `This Username Is Already Exists.`,
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: {
                                container: 'my-swal-container',
                                popup: 'my-swal-popup',
                                content: 'my-swal-content'
                            },
                                backdrop: `
                                    rgba(0,0,0,0.4)
                                `,
                                heightAuto: false,
                                allowOutsideClick: false,
                                scrollbarPadding: false
                            })

                        });

                    </script>
                multi;

        }

    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" href="Assets/Images/icon.png" />

        <link rel="stylesheet" href="CSS/signup.css" />

        <title>Fuel Tech | Signup Page</title>

    </head>

    <body>

        <div class="login-container">

            <div class="f-s">

                <img src="Assets/Images/logo.svg" alt="Logo" />

                <form action="" method="post" autocomplete="off" id="form-signup">

                    <div class="input-wrapper">

                        <input type="text" id="username" name="username" required />

                        <label for="username">Username</label>

                    </div>

                    <div class="input-wrapper">

                        <input type="text" id="email" name="email" required />

                        <label for="email">Email</label>

                    </div>

                    <div class="input-wrapper">

                        <input type="password" id="password" name="password" required />

                        <label for="password">Password</label>

                    </div>

                    <div class="input-wrapper">

                        <input type="password" id="c_password" name="c_password" required />

                        <label for="c_password">Confirm Password</label>

                    </div>

                    <div class="strength-wrapper">

                        <div class="strength"></div>

                        <div class="strength"></div>

                        <div class="strength"></div>

                        <div class="strength"></div>

                        <div class="strength"></div>

                    </div>

                    <div class="btns">

                        <input type="submit" name="signup" class="signup" value="Register" />

                        <a href="login.php" class="login">Login</a>

                    </div>

                    <p>We Are Working For Your Safety.</p>

                </form>

            </div>

            <div class="s-s">

                <img src="Assets/Images/img.png" alt="Main Image" />

                <div class="overlay">

                    <p>Welcome To</p>

                    <h1>Fuel Tech Company</h1>

                    <div class="divider"></div>

                    <p class="message">Register & Join us</p>

                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="JS/signup.js"></script>

    </body>

</html>
