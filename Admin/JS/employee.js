var addEmployeeBtn = document.querySelector(".add-btn");
var addEmployeeSectionBtn = document.querySelector("aside .sidebar a[data-location='add_employee']");

if (addEmployeeBtn && addEmployeeSectionBtn) {

    addEmployeeBtn.addEventListener("click", () => {

        addEmployeeSectionBtn.click();

    });

}

/* AJAX */

getData();

var EmpContainer = document.querySelector(".employee-list");

var EmpCounter = document.querySelector("#employeeCount");

async function getData() {

    await fetch("employees_fetch.php")

        .then(response => response.json())

        .then(data => {

            EmpContainer.innerHTML = ``;

            EmpCounter.innerText = `${data.length}`;

            for (let index = 0 ; index < data.length ; index++) {

                EmpContainer.innerHTML += `
                    <div class="employee-card">
                        <div class="employee-info">
                            <p><strong>Name:</strong> ${data[index].EmployeeName}</p>
                            <p><strong>Email:</strong> ${data[index].EmployeeEmail}</p>
                            <p><strong>Phone:</strong> ${data[index].EmployeePhone}</p>
                            <p><strong>Job:</strong> ${data[index].EmployeeRole}</p>
                            <p><strong>Personal ID:</strong> ${data[index].PersonalID}</p>
                            <p><strong>Salary:</strong> ${data[index].EmployeeSalary}</p>
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="EmployeeID" value="${data[index].EmployeeID}" />
                            <button type="submit" name="deleteEmployee" class="delete-btn"">🗑 Delete</button>
                        </form>
                    </div>`;

            }

        })

}

setInterval(getData, 1000);