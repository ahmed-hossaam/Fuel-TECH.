<?php

    session_start();

    if (!isset($_SESSION["Admin"])) {

        header("Location: ../index.php");
        exit();

    }

    require "../data.php";

    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");

    $requests = $db -> query("Select * FROM `requests`") -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($requests);

?>