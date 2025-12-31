<?php

    session_start();

    if (!isset($_SESSION["UserID"]) || !isset($_SESSION["logged_in"])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Employee Profile and Orders</title>

        <link rel="stylesheet" href="CSS/history.css">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />

    </head>

    <body>

        <div class="container">

            <main class="container-content">

                <section class="recent-orders">

                    <table id="recent-orders--table">

                        <caption>

                            <h2 id="orders-heading">Orders</h2>

                        </caption>

                        <thead>

                            <tr>

                                <th>Order ID</th>

                                <th>Date and time</th>

                                <th>Car Type</th>

                                <th>Car Model</th>

                                <th>Services</th>

                                <th>Issues</th>

                                <th>Request Status</th>

                            </tr>

                        </thead>

                        <tbody>



                        </tbody>

                    </table>

                </section>

            </main>

        </div>

        <script>let UserID = <?=$_SESSION["UserID"]?>;</script>
        <script src="JS/history.js"></script>

    </body>

</html>