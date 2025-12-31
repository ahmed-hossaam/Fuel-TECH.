<?php

    session_start();

    require "data.php";
    require "save_file.php";

    if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["UserID"])) {

        header("Location: login.php");
        exit();

    }

    if (!isset($_SESSION["Last_Request"])) {

        header("Location: request.php");
        exit();

    }

    $stmt = $db -> prepare("SELECT * FROM `requests` WHERE `RequestID` = :RequestID");
    $stmt -> execute([
        "RequestID" => $_SESSION["Last_Request"]
    ]);
    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    if ($rows[0]["IssuesForm"] != null) {

        header("Location: review.php");
        exit();

    }

    if (isset($_POST["submit_issues"])) {

        $issues = $_POST["problems"];
        $issue_image = $_FILES["photo"];
        $description = $_POST["details"];

        try {

            $image_url = save_file($issue_image, $image_types, $image_size);

        } catch (Throwable $error) {

            $image_url = null;

        }

        if ($issues || !empty($issue_image) || $description) {

            $stmt = $db -> prepare("UPDATE `requests` SET `Issues` = :Issues, `Description` = :Description, `IssueImage` = :IssueImage, `IssuesForm` = 1 WHERE `RequestID` = :RequestID");
            $stmt -> execute([
                "Issues" => json_encode($issues),
                "Description" => $description,
                "IssueImage" => $image_url,
                "RequestID" => $_SESSION["Last_Request"]
            ]);

            header("Location: review.php");
            exit();

        } else {

            $stmt = $db -> prepare("UPDATE `requests` SET `IssuesForm` = 0 WHERE `RequestID` = :RequestID");
            $stmt -> execute([
                "RequestID" => $_SESSION["Last_Request"]
            ]);
    
            header("Location: review.php");
            exit();

        }

    } elseif (isset($_POST["skip"])) {

        $stmt = $db -> prepare("UPDATE `requests` SET `IssuesForm` = 0 WHERE `RequestID` = :RequestID");
        $stmt -> execute([
            "RequestID" => $_SESSION["Last_Request"]
        ]);

        header("Location: review.php");
        exit();

    }

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Car Repair Request</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="CSS/issues.css" />

</head>

<body>

    <div class="form-container">

        <div class="head">
            <a href="<?php echo $_SESSION['previous_page']; ?>">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <img src="Assets/Images/logo_light.svg" alt="logo" id="logo">

        </div>

        <form action="" method="post" enctype="multipart/form-data">

            <h3 for="problems" id="head-label">What issues are you experiencing?</h3>

            <div class="checkbox-group">

                <label><input type="checkbox" name="problems[]" value="Car won't start"> Car won't start</label>

                <label><input type="checkbox" name="problems[]" value="Battery issue"> Battery issue</label>

                <label><input type="checkbox" name="problems[]" value="Engine noise"> Engine noise</label>

                <label><input type="checkbox" name="problems[]" value="Overheating"> Overheating</label>

                <label><input type="checkbox" name="problems[]" value="Fluid leak"> Fluid leak</label>

                <label><input type="checkbox" name="problems[]" value="A/C issue"> A/C issue</label>

                <label><input type="checkbox" name="problems[]" value="Car shakes"> Car shakes</label>

                <label><input type="checkbox" name="problems[]" value="Brake issue"> Brake issue</label>

                <label><input type="checkbox" name="problems[]" value="Burning smell"> Burning smell</label>

                <label><input type="checkbox" name="problems[]" value="Tire issue"> Tire issue</label>

                <label><input type="checkbox" name="problems[]" value="Transmission issue"> Transmission issue</label>

                <label><input type="checkbox" name="problems[]" value="Check Engine light"> Check Engine light</label>

            </div>

            <p id="alert"></p>

            <!-- <video id="video-preview" style="display: none; max-width: 100%;" autoplay></video>

                <canvas id="canvas" style="display: none;"></canvas>
                
                <img id="captured-image" style="display: none; max-width: 100%; margin-top: 10px;"> -->

            <input type="file" name="photo" accept="image/*" style="display: none;" id="issue" />

            <label style="text-align: center" for="issue" id="capture-btn" type="button">Shot The Breakdown</label>

            <button id="snap-btn" type="button" style="display: none;">Tap To Take</button>

            <label for="details">Describe The Breakdown:</label>

            <textarea id="details" name="details" class='input-box full-width'
                placeholder="Describe The Breakdown"></textarea>

            <button type="submit" name="skip" id="skip">Skip</button>

            <input type="submit" name="submit_issues" value="Submit Request" id="submit-btn">

        </form>

    </div>

    <script src="JS/issues.js"></script>

</body>

</html>