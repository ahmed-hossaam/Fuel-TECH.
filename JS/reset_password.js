        // Toggle password visibility
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const toggleBtn = input.nextElementSibling.nextElementSibling;
            
            if (input.type === "password") {
                input.type = "text";
                toggleBtn.textContent = "Hide";
            } else {
                input.type = "password";
                toggleBtn.textContent = "Show";
            }
        }
        
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBars = document.querySelectorAll('.strength-bar');
        const strengthText = document.querySelector('.strength-text');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            // Reset all bars
            strengthBars.forEach(bar => bar.classList.remove('active'));
            
            // Set active bars based on strength
            for (let i = 0; i < strength; i++) {
                strengthBars[i].classList.add('active');
            }
            
            // Update strength text
            if (password.length === 0) {
                strengthText.textContent = "Password strength";
            } else if (strength === 1) {
                strengthText.textContent = "Weak";
            } else if (strength === 2) {
                strengthText.textContent = "Fair";
            } else if (strength === 3) {
                strengthText.textContent = "Good";
            } else {
                strengthText.textContent = "Strong";
            }
        });
        
        // Simple password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            return strength;
        }
        
        // Confirm password validation
        const confirmInput = document.getElementById('confirm-password');
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert("Passwords don't match!");
            }
        });