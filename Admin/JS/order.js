var ordersContainer = document.querySelector(".orders-container");

getData();

/* AJAX */

function getData() {

    fetch("orders_requests.php")

        .then(response => response.json())

        .then(data => {

            ordersContainer.innerHTML = ``;

            for (let index = 0 ; index < data.length ; index++) {

                if (data[index].Statue == "Pending") {

                    let services = JSON.parse(data[index].Services);

                    let servicesUL = ``;

                    for (let service of services) {

                        servicesUL += `
                        
                            <li>${service}</li>
                        
                        `;

                    };

                    let issues = JSON.parse(data[index].Issues);
                    let issuesUL = ``;

                    if (issues) {

                        for (let issue of issues) {

                            issuesUL += `
                            
                                <li>${issue}</li>
                            
                            `;

                        };

                    } else {

                        issues = "N/A";
                        issuesUL = `<li>${issues}</li>`;

                    }

                    ordersContainer.innerHTML += `
                        <tr>
                            <td class="name">${data[index].Name}</td>
                            <td>${data[index].PhoneNumber}</td>
                            <td><a href="${data[index].LocationURL}">Show link</a></td>
                            <td>${data[index].CarType}</td>
                            <td>${data[index].CarModel}</td>
                            <td>
                                <ul class="services">

                                    ${servicesUL}

                                </ul>
                            </td>
                            <td>
                                <ul class="issues">

                                    ${issuesUL}

                                </ul>
                            </td>
                            <td class="request">
                                <form action="" method="post" class="content-request">
                                    <ul>
                                        <li>
                                            <input type="text" name="request_description" class="request-status" />
                                            <input type="hidden" name="RequestID" value="${data[index].RequestID}" />
                                        </li>
                                        <li>
                                            <button type="submit" class="accepted" name="accept"><i class="fa-solid fa-check"></i></button>
                                            <button type="submit" class="cancel" name="cancel"><i class="fa-solid fa-xmark"></i></button>
                                        </li>
                                    </ul>
                                </form>
                            </td>
                        </tr>
                    `;

                }

            }

        })

}

setInterval(getData, 20000);