let fuel = document
    .getElementById("fuel")
    .addEventListener("change", function () {
        let fuelType = document.getElementById("fuel-type");
        if (this.checked) {
            fuelType.style.display = "block";
        } else {
            fuelType.style.display = "none";
        }
    });

// validation on form
let submitBtn = document.getElementById("submit");
let username = document.getElementById("name");
let phone = document.getElementById("phone");
let carType = document.getElementById("car-type");
let carModel = document.getElementById("car-model");
let locationIn = document.getElementById("location");

// get alerts
let nameAlert = document.getElementById("name-alert");
let phoneAlert = document.getElementById("phone-alert");
let typeAlert = document.getElementById("type-alert");
let modelAlert = document.getElementById("model-alert");
let locationAlert = document.getElementById("location-alert");

submitBtn.addEventListener("click", (event) => {
    let nameValue = username.value.trim();
    let phoneValue = phone.value.trim();
    let cartypevalue = carType.value.trim();
    let carmodelvalue = carModel.value.trim();
    let locationValue = locationIn.value.trim();

    // let isValid=true
    // event.preventDefault();

    if (nameValue == "") {
        nameAlert.textContent = "Please enter your name";
        nameAlert.style.color = "red";
        nameAlert.style.marginTop = "6px";
        // event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        // isValid=false
    } else {
        nameAlert.textContent = "";
    }
    if (locationValue == "") {
        locationAlert.textContent = "Please press get location";
        locationAlert.style.color = "red";
        locationAlert.style.marginTop = "6px";
        // event.preventDefault();
        // isValid=false
    } else {
        locationAlert.textContent = "";
    }

    if (phoneValue.length != 11) {
        phoneAlert.textContent = "Please enter correct phone number";
        phoneAlert.style.color = "red";
        phoneAlert.style.marginTop = "6px";
        // event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        // isValid=false
    } else {
        phoneAlert.textContent = "";
    }

    if (cartypevalue == "") {
        typeAlert.textContent = "Please enter your car type";
        typeAlert.style.color = "red";
        typeAlert.style.marginTop = "6px";
        // event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        // isValid=false
    } else {
        typeAlert.textContent = "";
    }
    if (carmodelvalue == "") {
        modelAlert.textContent = "Please enter your car model";
        modelAlert.style.color = "red";
        modelAlert.style.marginTop = "6px";
        // event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        // isValid=false
    } else {
        modelAlert.textContent = "";
    }

    // ckeck on ckeckBoxes
    let servicesAlert = document.getElementById("services-alert");
    let checkBoxes = document.querySelectorAll("input[type=checkbox]:checked");
    if (checkBoxes.length === 0) {
        servicesAlert.textContent = "Please choose one service at least";
        servicesAlert.style.color = "red";
        // event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        // isValid=false
    } else {
        servicesAlert.textContent = "";
    }
});

// get location
let locationInput = document.querySelector("#location");
let locationBtn = document.querySelector("#get-location");

function getLocation() {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            let link = `https://google.com/maps/place/${position.coords.latitude},${position.coords.longitude}`;
            locationInput.value = link;
        },
        () => {
            alert("Please enable the location permission so that we can reach you.");
        }
    );
}

locationBtn.addEventListener("click", getLocation);
