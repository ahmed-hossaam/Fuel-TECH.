let signupForm = document.querySelector("#form-signup");

let usernameInput = document.querySelector("#username");

let passwordInput = document.querySelector("#password");

let emailInput = document.querySelector("#email");

let passwordCInput = document.querySelector("#c_password");

let usernameRegex = /^[a-zA-Z0-9_]{4,25}$/;

let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,30}$/;

let emailRegex = /^[a-zA-Z0-9._%+-]{1,100}@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

let strengthBars = document.querySelectorAll(".strength");

passwordInput.addEventListener("input", (event) => {

    strengthBars.forEach(bar => {

        bar.classList.remove("active");

    });

    for (let index = 0 ; index < checkPasswordStrength(event.target.value) ; index++) {

        strengthBars[index].classList.add("active");

    }

});

function checkValidation(username, email, password, passwordConfirm) {

    if (username.trim() === "" || email.trim() === "" || password.trim() === "" || passwordConfirm.trim() === "") {

        Swal.fire({
            title: 'Error!',
            text: `Please Fill All Fields.`,
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

        return false;

    }

    if (!usernameRegex.test(username)) {

        Swal.fire({
            title: 'Error!',
            text: `This Username ( ${username} ) Is Invalid.`,
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

        return false;

    } else if (!emailRegex.test(email)) {

        Swal.fire({
            title: 'Error!',
            text: `This Email ( ${email} ) Is Invalid.`,
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

        return false;

    } else if (!passwordRegex.test(password)) {

        Swal.fire({
            title: 'Error!',
            text: `Password Must be 8-30 Characters Long, Contain Uppercase & Lowercase Letters, a Number, and a Special Character.`,
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

        return false;

    } else if (!(passwordConfirm === password)) {

        Swal.fire({
            title: 'Error!',
            text: `The Passwords Doesn't Match !!`,
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

        return false;

    }

    return true;

}

function checkPasswordStrength(password) {

    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;

    return strength;

}

signupForm.addEventListener("submit", (event) => {

    if (!checkValidation(usernameInput.value, emailInput.value, passwordInput.value, passwordCInput.value)) {

        event.preventDefault();

    }

});
