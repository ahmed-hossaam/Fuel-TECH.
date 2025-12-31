<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Step 1</title>
    <link rel="stylesheet" href="CSS/reset_email.css">
</head>
<body>
    <div class="reset-container">
        <div class="form-side">
            <img src="Assets/Images/logo.svg" alt="Logo">
            
            <h2 class="title">Reset Password</h2>
            <p class="description">Enter your email address and we'll send you a verification code</p>
            
            <form action="reset_verify.php" method="post" id="reset_email" autocomplete="off">
                <div class="input-wrapper">
                    <input type="text" id="email" required>
                    <label for="email">Email Address</label>
                </div>
                
                <div class="btns">
                    <button type="submit" class="continue">Send Code</button>
                    <a href="login.php" class="cancel">Cancel</a>
                </div>
                
                <p>Remember your password? <a href="login.php">Login</a></p>
            </form>
        </div>
        
        <div class="image-side">
            <img src="Assets/Images/img.png" alt="Security">
            <div class="overlay">
                <p>PASSWORD RECOVERY</p>
                <div class="divider"></div>
                <h1>Securely reset your password</h1>
                <p class="message">We'll help you get back into your account in just a few easy steps.</p>
            </div>
        </div>
    </div>
    <script src="JS/reset_email.js"></script>
</body>
</html>