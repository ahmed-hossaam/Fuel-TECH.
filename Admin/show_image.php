<?php

    session_start();

    $token = "vnbGdDazQ2dATcdhoPzP";

    if (!isset($_SESSION["Admin"]) || !isset($_SESSION["AdminID"])) {

        header("Location: ../index.php");
        exit();

    }

    if (isset($_GET["img"]) && isset($_GET["token"]) && $_GET["token"] == $token) {

        $path = "../Users_Imgs/{$_GET["img"]}";
        $type = mime_content_type($path);
    
        header("Content-Type: $type");
        header("Content-Size: " . filesize($path));
    
        readfile($path);

    }

?>