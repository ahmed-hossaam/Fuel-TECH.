<?php

    session_set_cookie_params((365 * 24 * 60 * 60), "/", "", true, true);
    session_start();

    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {

        header("Location: index.php");

        exit();

    }

    require "data.php";

    if (isset($_POST["login"])) {

        $username = trim(strtolower($_POST["username"]));

        $password = $_POST["password"];

        $stmt = $db -> prepare("SELECT * FROM `users` WHERE `Username` = :Username OR `Email` = :Email");

        $stmt -> execute([
            "Username" => $username,
            "Email" => $username
        ]);

        $user_array = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        if (($stmt -> rowCount()) == 1) {

            $ID = $user_array[0]["UserID"];

            $password_hash = $user_array[0]["PasswordHash"];

            $verified = $user_array[0]["Verified"];

            if (password_verify($password, $password_hash)) {

                if ($verified == 1) {

                    if (isset($_POST["remember"])) {

                        $_SESSION["logged_in"] = true;

                        $_SESSION["UserID"] = $ID;

                        header("Location: index.php");

                        exit();

                    } else {

                        $_SESSION["logged_in"] = "once";

                        $_SESSION["UserID"] = $ID;

                        header("Location: index.php");

                        exit();

                    }

                } else {

                    $_SESSION["UserID"] = $ID;

                    header("Location: verify.php");

                }

            } else {

                echo <<<multi
                    <script>

                        document.addEventListener("DOMContentLoaded", () => {

                            Swal.fire({
                                title: 'Error!',
                                text: `Unable to log in. Please ensure your information is correct and try again.`,
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
                            text: `Unable to log in. Please ensure your information is correct and try again.`,
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

    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link rel="icon" href="Assets/Images/icon.png" />

        <link rel="stylesheet" href="CSS/login.css" />

        <title>Fuel Tech | Login Page</title>

    </head>

    <body>

        <div class="login-container">

            <div class="f-s">

                <img src="Assets/Images/logo.svg" alt="Logo" />

                <form action="" method="post" autocomplete="off">

                    <div class="input-wrapper">

                        <input type="text" id="username" name="username" required />

                        <label for="username">Username or Email</label>

                    </div>

                    <div class="input-wrapper">

                        <input type="password" id="password" name="password" required />

                        <label for="password">Password</label>

                    </div>

                    <div class="remember">

                        <input type="checkbox" name="remember" id="remember" />

                        <label for="remember">Remember Me</label>

                    </div>

                    <div class="btns">

                        <input type="submit" name="login" class="login" value="Login" />

                        <a href="signup.php" class="register">Register</a>

                    </div>

                    <p>Forgotten Your Password? <a href="reset_email.php">Reset It</a></p>

                </form>

            </div>

            <div class="s-s">

                <img src="Assets/Images/img.png" alt="Main Image" />

                <div class="overlay">

                    <p>Welcome To</p>

                    <h1>Fuel Tech Company</h1>

                    <div class="divider"></div>

                    <p class="message">Login To Your Account</p>

                </div>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </body>

</html>
