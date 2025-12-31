getData();

let sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const sidebarLinks = document.querySelectorAll('.sidebar a');
let main = document.querySelector("main");
let logoutContainer = document.querySelector(".logout-wrapper");
let logoutBtn = document.querySelector(".logout");

logoutContainer.addEventListener("click", () => {

  logoutBtn.click();

});

try {

  if (localStorage.getItem("currentPage")) {

    setContent(localStorage.getItem("currentPage"));

    sidebarLinks.forEach(link => {

      try {

        link.classList.remove("active");

      } catch {}

    });

    document.querySelector(`a[data-location="${localStorage.getItem("currentPage")}"]`).classList.add("active");

  }

} catch {

  setContent("main");

}

let loading = document.querySelector(".loading");

setTimeout(() => {

  loading.style.opacity = "0";

  setTimeout(() => {

    loading.remove();

  }, 250);

}, 800);

menuBtn.addEventListener("click", () => {
  sideMenu.classList.add("open"); 
});

closeBtn.addEventListener("click", () => {

  sideMenu.classList.remove("open");
});

async function getData() {

  try {

    let total_users = document.querySelector(".total_users");
    let pending_orders = document.querySelector(".pending");
    let accepted_orders = document.querySelector(".accepted");
    let online_orders = document.querySelector(".online_orders");
    let offline_orders = document.querySelector(".offline_orders");
    let new_customers = document.querySelector(".new_customers");

    await fetch("info_fetch.php")

      .then(response => response.json())

      .then(data => {

          total_users.innerText = data.total_users;
          pending_orders.innerText = data.pending;
          accepted_orders.innerText = data.accepted;
          online_orders.innerText = data.employees;
          offline_orders.innerText = data.cancelled;
          new_customers.innerText = data.new_customers;

      });

    } catch {}

}

setInterval(getData, 1000);

async function setContent(dataSet) {

  try {

    await fetch(`Templates/${dataSet}.html`)
    .then(response => response.text())
    .then(data => {
      main.innerHTML = data;
    });

    if (dataSet !== "main" && window[dataSet + "Loaded"] !== true) {

      let script = document.createElement("script");
      script.src = `JS/${dataSet}.js`;
      document.body.appendChild(script);
      window[dataSet + "Loaded"] = true;

    } else if (dataSet !== "main" && window[dataSet + "Loaded"] === true) {

      let script = document.querySelector(`script[src="JS/${dataSet}.js"]`);
      script.remove();

      let newScript = document.createElement("script");
      newScript.src = `JS/${dataSet}.js`;
      document.body.appendChild(newScript);

    }

    localStorage.setItem("currentPage", dataSet);

  } catch (error) {

    console.log("This Page Is Not Found !!", error);
  
   }

}


document.addEventListener('DOMContentLoaded', function () {

  sidebarLinks.forEach(link => {

      link.addEventListener('click', function (event) {

          event.preventDefault();

          sidebarLinks.forEach(link => link.classList.remove('active'));

          this.classList.add('active');

          let dataSet = link.dataset.location;

          setContent(dataSet);

      });

  });
  
});