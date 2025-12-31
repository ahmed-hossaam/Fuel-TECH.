<?php

session_set_cookie_params((365 * 24 * 60 * 60), "/", "", true, true);
session_start();

if (!isset($_SESSION["Admin"]) || !isset($_SESSION["AdminID"])) {

    header("Location: ../login.php");
    exit();
}

require "../data.php";

$stmt = $db->query("SELECT * FROM `admins` WHERE `AdminID` = {$_SESSION["AdminID"]}");

if (!($stmt->rowCount() == 1)) {

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_POST["logout"])) {

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_POST["accept"]) && (bool) $_POST["RequestID"] === true) {

    $stmt = $db->prepare("UPDATE `requests` SET `Statue` = :Statue, `AdminDescription` = :Description, `AdminID` = :AdminID, `RespondingDate` = CURRENT_TIMESTAMP WHERE `RequestID` = :RequestID");
    $stmt->execute(
        [
            "Statue" => "Accepted",
            "Description" => $_POST["request_description"],
            "RequestID" => $_POST["RequestID"],
            "AdminID" => $_SESSION["AdminID"]
        ]
    );

    header("Location: index.php");
    exit();
}

if (isset($_POST["cancel"]) && (bool) $_POST["RequestID"] === true) {

    $stmt = $db->prepare("UPDATE `requests` SET `Statue` = :Statue, `AdminDescription` = :Description, AdminID = :AdminID, `RespondingDate` = CURRENT_TIMESTAMP WHERE `RequestID` = :RequestID");
    $stmt->execute([
        "Statue" => "Cancelled",
        "Description" => $_POST["request_description"],
        "RequestID" => $_POST["RequestID"],
        "AdminID" => $_SESSION["AdminID"]
    ]);

    header("Location: index.php");
    exit();
}

if (isset($_POST["deleteEmployee"]) && (bool) $_POST["EmployeeID"] === true) {

    $db->query("DELETE FROM `employees` WHERE `EmployeeID` = {$_POST["EmployeeID"]}");

    header("Location: index.php");
    exit();
}

if (isset($_POST["add_employee"])) {

    try {

        $Name = $_POST["first_name"] . " " . $_POST["last_name"];
        $Role = $_POST["role"];
        $Salary = $_POST["salary"];
        $Email = $_POST["email"];
        $Phone = $_POST["phone"];
        $PersonalID = $_POST["personal_id"];
        $AdminID = $_SESSION["AdminID"];


        $stmt = $db->prepare("INSERT INTO `employees`(`EmployeeName`, `EmployeeEmail`, `EmployeePhone`, `EmployeeRole`, `PersonalID`, `EmployeeSalary`, `AdminID`) VALUES (:Name, :Email, :Phone, :Role, :PersonalID, :Salary, :AdminID)");
        $stmt->execute(
            [
                "Name" => $Name,
                "Email" => $Email,
                "Phone" => $Phone,
                "Role" => $Role,
                "PersonalID" => $PersonalID,
                "Salary" => $Salary,
                "AdminID" => $AdminID
            ]
        );

        header("Location: index.php");
        exit();
    } catch (Throwable $error) {
    }
}

if (isset($_POST["add_admin"])) {

    $stmt = $db->prepare("SELECT `AllPermissions` FROM `admins` WHERE `AdminID` = :AdminID");
    $stmt->execute(
        [
            "AdminID" => $_SESSION["AdminID"]
        ]
    );
    $permissions = $stmt->fetchColumn();

    if ($permissions == 1) {

        try {

            $username = strtolower(trim($_POST["username"]));
            $name = $_POST["name"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $stmt = $db->prepare("SELECT * FROM `admins` WHERE `AdminUsername` = :Username");
            $stmt->execute([
                "Username" => "$username"
            ]);

            if (($stmt->rowCount()) == 0) {

                $stmt = $db->prepare("INSERT INTO `admins`(AdminUsername, AdminName, PasswordHash) VALUES(:Username, :Name, :Password)");
                $stmt = $stmt->execute(
                    [
                        "Username" => "$username",
                        "Name" => "$name",
                        "Password" => "$password"
                    ]
                );
            }
        } catch (Throwable $error) {
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Tech | Admin Panel</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <div class="loading">
        <img src="Assets/Images/light_logo.svg" alt="Logo" />
        <div class="bar"></div>
    </div>
    <div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="./Assets/Images/logo.svg" alt="logo" id="logo">
                </div>
                <span class="close">
                    <button id="close-btn" class="material-icons-sharp"> close </button>
                </span>
            </div>
            <div class="sidebar">
                <a href="#" class="active" data-location="main">
                    <span class="material-icons-sharp"> trending_up</span>
                    <h3>Overview</h3>
                </a>
                <a href="#" data-location="order">
                    <span class="material-icons-sharp"> receipt_long </span>
                    <h3>Orders</h3>
                </a>
                <a href="#" data-location="Profile">
                    <span class="material-icons-sharp">
                        people
                    </span>
                    <h3>Profile</h3>
                </a>
                <!-- <a href="#" data-location="employee">
                    <span class="material-icons-sharp"> insights </span>
                    <h3>Employee</h3>
                </a> -->

                <!-- <a href="#" data-location="add_admin">
                        <span class="material-icons-sharp">
                            person
                            </span>
                        <h3>Add Admin</h3>
                    </a> -->
                <div class="logout-wrapper">

                    <span class="material-icons-sharp"> logout </span>

                    <form action="" method="post">

                        <input type="submit" name="logout" class="logout" value="Logout" />

                    </form>

                </div>

            </div>
        </aside>
        <main class="container-content">
            <h2><i class="fas fa-chart-line"></i>Overview</h2>
            <div class="insights-1">
                <div class="sales">
                    <div class="card">
                        <h3>Total Users</h3>
                        <div class="about">
                            <p class="total_users">0</p>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="expenses">
                    <div class="card">
                        <h3>Pending Orders</h3>
                        <div class="about">
                            <p class="pending">0</p>
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
                <div class="income">
                    <div class="card">
                        <h3>Active Services</h3>
                        <div class="about">
                            <p class="accepted">0</p>
                            <i class="fas fa-cogs"></i>
                        </div>
                    </div>
                </div>
            </div>
            <h2>More Analytics</h2>
            <div class="insights-1">
                <div class="sales">
                    <div class="card">
                        <h3>Employees</h3>
                        <div class="about">
                            <p class="online_orders">0</p>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="expenses">
                    <div class="card">
                        <h3>Cancelled Orders</h3>
                        <div class="about">
                            <p class="offline_orders">0</p>
                            <i class="material-icons-sharp local"> cancel </i>
                        </div>
                    </div>
                </div>
                <div class="income">
                    <div class="card">
                        <h3>NEW CUSTOMERS</h3>
                        <div class="about">
                            <p class="new_customers">0</p>
                            <i class="material-icons-sharp cart"> person </i>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="top-nav">
            <button id="menu-btn">
                <span class="material-icons-sharp"> menu </span>
            </button>
        </div>
    </div>

    <script src="JS/main.js"></script>

</body>

</html>