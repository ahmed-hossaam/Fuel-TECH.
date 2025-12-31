<?php

    session_start();

    if (!isset($_SESSION["Admin"])) {

        header("Location: ../index.php");
        exit();

    }

    require "../data.php";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $requests = $db -> query("SELECT * FROM `employees`") -> fetchALL(PDO::FETCH_ASSOC);

    echo json_encode($requests);

?>