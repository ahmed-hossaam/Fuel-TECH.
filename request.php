<?php

    session_start();

    require "data.php";
    require "save_file.php";

    if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["UserID"])) {

        header("Location: login.php");
        exit();

    }

    $stmt = $db -> prepare("SELECT `UserID` FROM `users` WHERE `UserID` = :UserID");
    $stmt -> execute(
        [
            "UserID" => $_SESSION["UserID"]
        ]
    );

    if ($stmt -> rowCount() != 1) {

        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();

    }

    if (isset($_POST["request"])) {

        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $cartype = $_POST["cartype"];
        $carmodel = $_POST["carmodel"];
        $services = $_POST["service"];
        $location = $_POST["location"];

        if (in_array("Fuel", $services)) {

            $fuel = $_POST["petrol"];
            $services[array_search("Fuel", $services)] = $fuel;

        }

        if (isset($_FILES["front_face"]) && $_FILES["front_face"]["error"] === 0) {

            $front_face = $_FILES["front_face"];
            $front_face = save_file($front_face, $image_types, $image_size);

        }

        if (isset($_FILES["back_face"]) && $_FILES["back_face"]["error"] === 0) {

            $back_face = $_FILES["back_face"];
            $back_face = save_file($back_face, $image_types, $image_size);

        }

        $stmt = $db -> prepare("INSERT INTO `requests`(`UserID`, `Name`, `PhoneNumber`, `CarType`, `CarModel`, `Services`, `LocationURL`, `FrontID`, `BackID`) VALUES(:UserID, :Name, :Phone, :CarType, :CarModel, :Services, :LocationURL, :FrontID, :BackID)");
        $stmt -> execute(
            [
                "UserID" => $_SESSION["UserID"],
                "Name" => $name,
                "Phone" => $phone,
                "CarType" => $cartype,
                "CarModel" => $carmodel,
                "Services" => json_encode($services),
                "LocationURL" => $location,
                "FrontID" => $front_face,
                "BackID" => $back_face
            ]
        );

        $_SESSION["Last_Request"] = $db -> query("SELECT `RequestID`, `Date` FROM `requests` WHERE `UserID` = {$_SESSION["UserID"]} ORDER BY `Date` DESC") -> fetchColumn();
        header("Location: issues.php");
        
    }

$_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'] ?? 'index.php';
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Quote</title>
    <link rel="stylesheet" href="CSS/request.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <section id="request">
        <div class="container">
            <div class="form-box">
                <h1>Request a Quote</h1>
                <div class="head">
                    <a href="<?php echo $_SESSION['previous_page']; ?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="Assets/Images/logo_light.svg" alt="logo" id="logo">
                </div>
                <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="input-box">
                            <label>Your Name</label>
                            <input type="text" name="name" placeholder="Enter your name" id="name">
                            <p id="name-alert"></p>
                        </div>
                        <div class="input-box">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="Enter your Phone Number" id="phone"
                                onkeypress="return /[0-9+]/.test(event.key)">
                            <p id="phone-alert"></p>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-box">
                            <label>Car Type</label>
                            <input type="text" name="cartype" placeholder="Enter car type" id="car-type">
                            <p id="type-alert"></p>
                        </div>
                        <div class="input-box">
                            <label>Car Model</label>
                            <input type="text" name="carmodel" placeholder="Enter car model" id="car-model">
                            <p id="model-alert"></p>
                        </div>
                    </div>

                    <!--  Services Selection (Checkbox Section) -->
                    <div class="checkbox-group">
                        <label class="checkbox-title">What service do you want?</label>
                        <div class="checkbox-container">
                            <div class="checkbox-column">
                                <label><input type="checkbox" name="service[]" value="Fuel" id="fuel"> Fuel</label>
                                <label><input type="checkbox" name="service[]" value="Car Wash"> Car wash</label>
                                <label><input type="checkbox" name="service[]" value="Tires"> Tires</label>
                                <label><input type="checkbox" name="service[]" value="Rescue"> Rescue</label>
                            </div>
                            <div class="checkbox-column">
                                <label><input type="checkbox" name="service[]" value="Engine Oil"> Engine
                                    oil</label>
                                <label><input type="checkbox" name="service[]" value="Battery"> Battery</label>
                                <label><input type="checkbox" name="service[]" value="Maintenance">Maintenance
                                </label>
                                <label><input type="checkbox" name="service[]" value="Engine Check"> Engine
                                    Check</label>
                            </div>
                            <div class="checkbox-column" id="fuel-type">
                                <p>Select the type of fuel</p>
                                <label><input type="radio" name="petrol" value="Gasoline 95"> Gasoline 95</label>
                                <label><input type="radio" name="petrol" value="Gasoline 80" checked> Gasoline
                                    80</label>
                                <label><input type="radio" name="petrol" value="Gasoline 92"> Gasoline 92</label>
                                <label><input type="radio" name="petrol" value="Natural Gas"> Natural gas</label>
                            </div>
                        </div>
                        <p id="services-alert"></p>
                    </div>
                    <div class="input-group">
                        <div class="input-box">
                            <label for="front_face" class="label-btn">ID Front Face</label>
                            <input type="file" name="front_face" id="front_face" accept="image/*" required />
                            <p id="type-alert"></p>
                        </div>
                        <div class="input-box">
                            <label for="back_face" class="label-btn">ID Back Face</label>
                            <input type="file" name="back_face" id="back_face" accept="image/*" required />
                            <p id="model-alert"></p>
                        </div>
                    </div>
                    <div class="input-box full-width">
                        <label>Get Location</label>
                        <input type="text" readonly name="location" id="location">
                        <p id="location-alert"></p>
                        <button type="button" class="submit-btn" id="get-location">Get Location</button>
                    </div>
                    <button type="submit" class="submit-btn" id='submit' name="request">Request a Quote</button>
                </form>
            </div>
        </div>
    </section>

    <script src="JS/request.js"></script>
</body>

</html>