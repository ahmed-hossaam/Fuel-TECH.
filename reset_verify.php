<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Step 2</title>
    <link rel="stylesheet" href="CSS/reset_verify.css">
</head>
<body>
    <div class="reset-container">
        <div class="form-side">
            <img src="Assets/Images/logo.svg" alt="Logo">
            
            <h2 class="title">Verification Code</h2>
            <p class="description">We've sent a verification code to <span class="email">example@email.com</span></p>
            
            <form action="reset_password.php" method="post" autocomplete="off">
                <div class="verification-code">
                    <input type="text" maxlength="1" autofocus>
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                    <input type="text" maxlength="1">
                </div>
                
                <div class="btns">
                    <button type="submit" class="continue">Verify</button>
                    <a href="reset_email.php" class="back">Back</a>
                </div>
                
                <p>Didn't receive a code? <a href="">Resend Code</a></p>
            </form>
        </div>
        
        <div class="image-side">
            <img src="Assets/Images/img.png" alt="Verification">
            <div class="overlay">
                <p>VERIFICATION</p>
                <div class="divider"></div>
                <h1>Almost there!</h1>
                <p class="message">Enter the verification code sent to your email to continue the password reset process.</p>
            </div>
        </div>
    </div>

    <script src="JS/reset_verify.js"></script>
</body>
</html>