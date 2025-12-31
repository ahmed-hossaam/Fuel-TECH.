let container = document.querySelector("tbody");

/* AJAX */

fetch(`history_fetch.php?UserID=${UserID}`)
    .then(response => response.json())
    .then(data => {
        for (let index = 0 ; index < data.length ; index++) {
            let servicesUL = "";
            let services = JSON.parse(data[index]["Services"]);
            if (services) {
                for (let service = 0 ; service < services.length ; service++) {
                    servicesUL += `<li>${services[service]}</li>`;
                }
            }
            let issuesUL = "";
            let issues = JSON.parse(data[index]["Issues"]);
            if (issues) {
                for (let issue = 0 ; issue < issues.length ; issue++) {
                    issuesUL += `<li>${issues[issue]}</li>`;
                }
            }
            container.innerHTML += 
            `
                            <tr>

                                <td>${data[index]["RequestID"]}</td>

                                <td>

                                    <ul class="date">

                                        ${data[index]["Date"]}

                                    </ul>

                                </td>

                                <td>${data[index]["CarType"]}</td>

                                <td>${data[index]["CarModel"]}</td>

                                <td>

                                    <ul class="services">

                                        ${servicesUL || "No Services"}

                                    </ul>

                                </td>

                                <td>

                                    <ul class="issues">

                                        ${issuesUL || "No Issues"}

                                    </ul>

                                </td>

                                <td class="${data[index]["Statue"]}">${data[index]["Statue"]}</td>

                            </tr>
            `;
        }
    });