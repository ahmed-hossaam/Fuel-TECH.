<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Step 3</title>
    <link rel="stylesheet" href="CSS/reset_password.css">
</head>
<body>
    <div class="reset-container">
        <div class="form-side">
            <img src="Assets/Images/logo.svg" alt="Logo">
            
            <h2 class="title">Create New Password</h2>
            <p class="description">Your new password must be different from previous passwords</p>
            
            <form action="login.html">
                <div class="input-wrapper">
                    <input type="password" required id="password">
                    <label for="password">New Password</label>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')">Show</span>
                </div>

                <div class="password-strength">
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                    <div class="strength-bar"></div>
                </div>
                <div class="strength-text">Password strength</div>

                <div class="password-requirements">
                    <ul>
                        <li>At least 8 characters</li>
                        <li>Include at least one uppercase letter</li>
                        <li>Include at least one number</li>
                        <li>Include at least one special character</li>
                    </ul>
                </div>
                
                <div class="input-wrapper">
                    <input type="password" required id="confirm-password">
                    <label for="confirm-password">Confirm Password</label>
                    <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password')">Show</span>
                </div>
                
                <div class="btns">
                    <button type="submit" class="continue">Reset Password</button>
                    <a href="reset_verify.php" class="back">Back</a>
                </div>
            </form>
        </div>
        
        <div class="image-side">
            <img src="Assets/Images/img.png" alt="Security">
            <div class="overlay">
                <p>FINAL STEP</p>
                <div class="divider"></div>
                <h1>Create a secure password</h1>
                <p class="message">Choose a strong password that you don't use elsewhere to keep your account secure.</p>
            </div>
        </div>
    </div>

    <script src="JS/reset_password.js"></script>
</body>
</html>