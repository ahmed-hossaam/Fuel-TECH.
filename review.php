<?php

    session_start();

    if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["UserID"])) {

        header("Location: login.php");
        exit();

    }

    require "data.php";

    $stmt = $db -> prepare("SELECT * FROM `requests` WHERE `UserID` = :UserID ORDER BY `Date` DESC");
    $stmt -> execute([
        "UserID" => $_SESSION["UserID"]
    ]);
    $rows = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $statue = $rows[0]["Statue"];
    $admin_msg = $rows[0]["AdminDescription"];

    if (isset($_POST["confirm"])) {

        $stmt = $db -> prepare("UPDATE `requests` SET `Statue` = :Statue WHERE `RequestID` = :RequestID");
        $stmt -> execute([
            "Statue" => "Pending",
            "RequestID" => $_SESSION["Last_Request"]
        ]);
        
        header("Location: review.php");

    } elseif (isset($_POST["cancel"])) {

        $stmt = $db -> prepare("DELETE FROM `requests` WHERE `RequestID` = :RequestID");
        $stmt -> execute([
            "RequestID" => $rows[0]["RequestID"]
        ]);
        unset($_SESSION["Last_Request"]);
        header("Location: index.php");
        exit();

    }

    if (isset($_POST["back"])) { 
        header("Location: index.php");
        exit(); 
    }
    
        
    

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="CSS/review.css" />

    <title>Fuel Tech | Reveiw Data</title>

</head>

<body>

    <div class="container">
        <h2>Order Review</h2>
             <div class="head">
                    <a href="<?php echo $_SESSION['previous_page']; ?>">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <img src="Assets/Images/logo_light.svg" alt="logo" id="logo">
                </div>
                

        <table class="order-details">

            <tr>

                <th>Order ID</th>

                <td><?=$rows[0]["RequestID"]?></td>

            </tr>

            <tr>

                <th>Name</th>

                <td><?=$rows[0]["Name"]?></td>

            </tr>

            <tr>

                <th>Phone</th>

                <td><?=$rows[0]["PhoneNumber"]?></td>

            </tr>

            <tr>

                <th>Car Type</th>

                <td><?=$rows[0]["CarType"]?></td>

            </tr>

            <tr>

                <th>Car Model</th>

                <td><?=$rows[0]["CarModel"]?></td>

            </tr>

            <tr>

                <th>Services</th>

                <td>

                    <ol>

                        <?php
                        
                            foreach(json_decode($rows[0]["Services"]) as $row) {
                                echo "<li>$row</li>";
                            }
                        
                        ?>

                    </ol>

                </td>

            </tr>

            <tr>

                <th>Breakdowns</th>

                <td>

                    <ol>

                        <?php

                                    if ($rows[0]["Issues"]) {
                                
                                        foreach(json_decode($rows[0]["Issues"]) as $row) {
                                            echo "<li>$row</li>";
                                        }

                                    } else {

                                        echo "No Issues";

                                    }
                                
                                ?>

                    </ol>

                </td>

            </tr>

            <tr>

                <th>Location </th>

                <td><a class="location" href="<?=$rows[0]["LocationURL"]?>">Location </a></td>

            </tr>

            <?php if ($statue != "Not-Confirmed"):?>

            <tr>

                <th class="">Statue</th>

                <td class="<?=$statue?>"><?=$statue?></td>

            </tr>


            <?php endif;?>

            <?php if ($admin_msg):?>

            <tr>

                <th>Admin Message</th>

                <td><?=$admin_msg?></td>

            </tr>

            <?php endif;?>

        </table>

                
        <?php if ($statue == "Not-Confirmed"):?>

        <p class="note">
            NOTE: If you clicked confirm ,
            our car will start move to your location. Please review your order carefully before proceeding.
        </p>

        <form action="" method="post">

            <div class="buttons">

                <button type="submit" class="btn btn-confirm" name="confirm">Confirm</button>

                <button type="submit" class="btn btn-cancel" name="cancel">Cancel</button>

            </div>

        </form>

        <?php endif;?>
        <form action="" method="post">
            <div class="back">
                <button type="submit" name="back" class="back-home">Back To Home Page
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </form>

    </div>

</body>

</html>