<?php

    header("Content-Type: application/json");
    header("Control-Access-Allow-Origin: *");

    require "data.php";

    if (isset($_GET["UserID"])) {
        $stmt = $db -> prepare("SELECT * FROM `requests` WHERE `UserID` = :UserID");
        $stmt -> execute([
            "UserID" => $_GET["UserID"]
        ]);
    }

    echo json_encode($stmt -> fetchAll(PDO::FETCH_ASSOC));

?>