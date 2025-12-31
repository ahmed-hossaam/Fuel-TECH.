<?php

    session_set_cookie_params((365 * 24 * 60 * 60), "/", "", true, true);
    session_start();

    if (!isset($_SESSION["UserID"])) {

        header("Location: signup.php");
        exit();

    }

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "data.php";
    require "vendor/autoload.php";

    $userEmail = $db -> query("SELECT `email` FROM `users` WHERE `UserID` = {$_SESSION["UserID"]}") -> fetchColumn();

    if (isset($_POST["verify"])) {

        $userCode = $_POST["otp1"] . $_POST["otp2"] . $_POST["otp3"] . $_POST["otp4"] . $_POST["otp5"] . $_POST["otp6"];
        $realCode = $db -> query("SELECT VerificationCode FROM `users` WHERE `UserID` = {$_SESSION["UserID"]}") -> fetchColumn();

        if ($userCode == $realCode) {

            $db -> query("UPDATE `users` SET `Verified` = 1 WHERE `UserID` = {$_SESSION["UserID"]}");
            $_SESSION["logged_in"] = true;
            header("Location: index.php");
            exit();

        } else {

            echo <<<multi
                <script>

                    document.addEventListener("DOMContentLoaded", () => {

                        Swal.fire({
                            title: 'Error!',
                            text: `This Code Isn't Correct !!`,
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

    if (!isset($_COOKIE["Timeout"])) {

        $mail = new PHPMailer(true);

        try {

            $verificationCode = rand(100000, 999999);

            $mail -> isSMTP();
            $mail -> Host = "smtp.gmail.com";
            $mail -> SMTPAuth = true;
            $mail -> Username = "fueltech.supp@gmail.com";
            $mail -> Password = "qcxh osqs qovf bcek";
            $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail -> Port = 587;
            $mail -> setFrom("fueltech.supp@gmail.com", "Fuel Tech");
            $mail -> addAddress($userEmail);
            $mail -> isHTML(true);
            $mail -> Subject = "Verification Code";
            $mail->Body = "
                <p>Hello,</p>
                <p>Your verification code is: <b style='color: #006aff;'>$verificationCode</b></p>
                <p>Please enter this code to verify your account. This code is valid forever. If you didn’t request this, please ignore this message.</p>
                <p>Thank you,<br>Fuel Tech</p>
                ";
            $mail -> send();

            $db -> query("UPDATE `users` SET VerificationCode = '$verificationCode' WHERE UserID = {$_SESSION["UserID"]}");

            setcookie("Timeout", true, time() + 30, "/", "", true, false);

        } catch (Exception $error) {echo $error;}

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Tech | Verification</title>
    <link rel="stylesheet" href="CSS/verify.css" />
</head>
<body>
    <section id="varification">
        <div class="container">
            <img src="./Assets/Images/logo.svg" alt="">
            <h2>Verify Code</h2>
            <p class="subtitle">Please enter the code we just sent to email</p>
            <p class="email"><?=$userEmail?></p>
            <div class="otp-inputs">
                <form action="" method="post" autocomplete="off">
                    <input type="text" name="otp1" class="code" maxlength="1">
                    <input type="text" name="otp2" class="code" maxlength="1">
                    <input type="text" name="otp3" class="code" maxlength="1">
                    <input type="text" name="otp4" class="code" maxlength="1">
                    <input type="text" name="otp5" class="code" maxlength="1">
                    <input type="text" name="otp6" class="code" maxlength="1">
                    <p class="resend-text">Didn't receive OTP? <a href="">Resend code</a></p>
                    <input class="verify-btn" name="verify" class="resend" type="submit" value="Verify" />
                </form>
            </div>   
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/verify.js"></script>
</body>
</html>