// let inputs = document.querySelectorAll(".code");
// let resend = document.querySelector(".resend");

// function isCookieSet(name) {
//     return document.cookie.split('; ').some(cookie => cookie.startsWith(name + '='));
// }

// inputs.forEach((input, index) => {
//     input.addEventListener("input", (e) => {
//         let value = e.target.value;
//         if (!/^\d$/.test(value)) {
//             e.target.value = "";
//             return;
//         }
//         if (index < inputs.length - 1) {
//             inputs[index + 1].focus();
//         }
//     });

//     input.addEventListener("keydown", (e) => {
//         if (e.key === "Backspace" && index > 0 && !e.target.value) {
//             inputs[index - 1].focus();
//         }
//     });
// });

// resend.addEventListener("click", () => {
//     if (!isCookieSet("Timeout")) {
//         window.location.reload();
//     } else {

//         Swal.fire({
//             title: 'Error!',
//             text: `There Is Timeout 20 Second, Code Will Be Send Automatically`,
//             icon: 'error',
//             confirmButtonText: 'OK',
//             customClass: {
//                 container: 'my-swal-container',
//                 popup: 'my-swal-popup',
//                 content: 'my-swal-content'
//             },
//                 backdrop: `
//                     rgba(0,0,0,0.4)
//                 `,
//                 heightAuto: false,
//                 allowOutsideClick: false,
//                 scrollbarPadding: false
//             });

//         };

//         setTimeout(() => {
//             window.location.reload();
//         }, 30 * 1000);
//     }
// );