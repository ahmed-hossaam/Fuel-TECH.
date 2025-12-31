let cursor = document.querySelector(".text");

let typingSpeed = 80;

let services = ["Engine Oil Change", "Battery Change", "Tires Change", "Rescue", "Gas | Petrol | CNG", "Car Wash"];

let serviceIndex = 0;

let wordIndex = 0;

let isTyping = true;

let language = document.querySelector(".translate");

let languageText = document.querySelector(".translate p");

let theme = document.querySelector(".theme i");

let menuButton = document.querySelector(".menu");

let menu = document.querySelector(".s-s");

let toggled = false;

let loadingSection = document.querySelector(".loading-section");

let scrollTop = document.querySelector(".scrollTop");

let headerH2 = document.querySelector("header h2");

window.addEventListener("load", () => {

    setTimeout(() => {

        loadingSection.style.opacity = 0;

        setTimeout(() => {

            document.body.removeChild(loadingSection);

        }, 250);

    }, 1500);

});

window.addEventListener("scroll", () => {

    if (window.scrollY >= 500) {

        scrollTop.style.opacity = "1";

        scrollTop.disabled = false;

    } else {

        scrollTop.style.opacity = "0";

        scrollTop.disabled = true;

    }

});

/* Checking */

let links = document.querySelectorAll("link");

let logo = document.querySelector("nav img");

switch (localStorage.getItem("language")) {

    case "EN":

        document.body.style.direction = "ltr";

        languageText.innerText = "AR";

        document.querySelector("html").lang = "en";

        break;

    case "AR":

        document.body.style.direction = "rtl";

        languageText.innerText = "EN";

        document.querySelector("html").lang = "ar";

        services = ["تغيير زيت محرك", "تغيير بطارية", "تغيير اطارات", "انقاذ", "غاز | بنزين | غاز مضغوط", "غسيل سيارات"];

        headerH2.style.borderLeft = "1px solid #3c9bee";

        headerH2.style.borderRightColor = "transparent";

        fetch("JS/JSON/ar.json")
            .then(response => response.json())
            .then(data => {
                for (let key in data) {
                    for (let key2 in data[key]) {
                        var element = document.querySelectorAll(key);
                        element[key2].innerText = data[key][key2];
                    }
                }
            })

        break;

}

/* Checking */

function typeWriterEffect() {

    let currentService = services[serviceIndex];

    if (isTyping) {

        cursor.innerText = currentService.slice(0, wordIndex++);

        if (wordIndex > currentService.length) {

            isTyping = false;

            setTimeout(typeWriterEffect, 1500);

            return;

        }

    } else {

        cursor.innerText = currentService.slice(0, wordIndex--);

        if (wordIndex < 0) {

            wordIndex = 0;

            isTyping = true;

            serviceIndex = (++serviceIndex % services.length);

            setTimeout(typeWriterEffect, 1500);

            return;

        }

    }

    setTimeout(typeWriterEffect, isTyping ? typingSpeed : typingSpeed - 20)

}

typeWriterEffect();

language.addEventListener("click", () => {

    switch (window.localStorage.getItem("language")) {

        case "EN":

            languageText.innerText = "EN";

            window.localStorage.setItem("language", "AR");

            location.reload();

            break;

        case "AR":

            languageText.innerText = "AR";

            window.localStorage.setItem("language", "EN");

            location.reload();

            break;

        default:

            languageText.innerText = "EN";

            window.localStorage.setItem("language", "AR");

            location.reload();

        }

    }

);

window.addEventListener("resize", () => {

    if (window.innerWidth >= 992) {

        if (toggled) {

            menuButton.click();

        }

    }

});

menuButton.addEventListener("click", () => {

    if (!toggled) {

        if (languageText.innerText == "AR") {

            menu.style.height = "265px";

        } else {

            menu.style.height = "275px";

        }

        toggled = true;

    } else {

        menu.style.height = "0px";

        toggled = false;

    }

});

scrollTop.addEventListener("click", () => {

    window.scrollTo({

        top: 0,

        left: 0,

        behavior: "smooth"

    });

});

//Autoplay Image Slider with Navigation 

// slider 

var slides = document.querySelectorAll('.slide');
var buttons = document.querySelectorAll('.btn');
let currentSlide = 1;

// Image Slider with Manual Navigation
var manualNavigation = function(manual){
slides.forEach((slide) => {
    slide.classList.remove('active');
    buttons.forEach((btn) => {
        btn.classList.remove('active');
    });
});
    slides[manual].classList.add('active');
    buttons[manual].classList.add('active');
}

buttons.forEach((btn, i) => {
    btn.addEventListener("click", () => {
    manualNavigation(i);
    currentSlide = i;
    });
});

//Autoplay Image Slider with Navigation 
var repeat = function(activeClass){
    let active = document.getElementsByClassName('active');
    let i = 1;

    var repeater = () => {
        setTimeout(function(){
            [...active].forEach((activeSlide) => {
            activeSlide.classList.remove('active');
    });

    slides[i].classList.add('active');
    buttons[i].classList.add('active');
    i++;

    if(slides.length == i){
        i = 0;
    }
    if(i >= slides.length){
        return;
    }
    repeater();
        }, 5000);
    }
    repeater();
}
repeat();
//FAQS
document.querySelectorAll('.faq-question').forEach((item) => {
    item.addEventListener('click', () => {
        const answer = item.nextElementSibling;
        const icon = item.querySelector('svg');

        answer.classList.toggle('open');
        icon.style.transform = answer.classList.contains('open') ? 'rotate(180deg)' : 'rotate(0deg)';
    });
});