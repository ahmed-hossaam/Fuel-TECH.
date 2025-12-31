<?php

    session_start();

    if (!isset($_SESSION["Admin"])) {

        header("Location: ../index.php");
        exit();

    }

    require "../data.php";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $users = count($db -> query("SELECT * FROM `users`") -> fetchALL(PDO::FETCH_ASSOC));
    $pending = count($db -> query("SELECT * FROM `requests` WHERE `Statue` = 'Pending'") -> fetchALL(PDO::FETCH_ASSOC));
    $accepted = count($db -> query("SELECT * FROM `requests` WHERE `Statue` = 'Accepted'") -> fetchALL(PDO::FETCH_ASSOC));
    $employees = count($db -> query("SELECT * FROM `employees`") -> fetchAll(PDO::FETCH_ASSOC));
    $cancelled = count($db -> query("SELECT * FROM `requests` WHERE `Statue` = 'Cancelled'") -> fetchALL(PDO::FETCH_ASSOC));
    $new_customers = count($db -> query("SELECT * FROM `users` WHERE `Date` >= NOW() - INTERVAL 30 DAY") -> fetchALL(PDO::FETCH_ASSOC));

    $info = [
        "total_users" => $users,
        "pending" => $pending,
        "accepted" => $accepted,
        "employees" => $employees,
        "cancelled" => $cancelled,
        "new_customers" => $new_customers
    ];

    echo json_encode($info);

?>