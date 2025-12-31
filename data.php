<?php

    $config = [
        "host" => "localhost",
        "dbname" => "fuel_tech",
        "charset" => "utf8",
        "username" => "root",
        "password" => ""
    ];

    try {

        $db = new PDO("mysql:host={$config["host"]};dbname={$config["dbname"]};charset={$config["charset"]}", $config["username"], $config["password"]);

    } catch (PDOException $error) {}

?>