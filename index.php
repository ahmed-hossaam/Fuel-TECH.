<?php

    session_start();

    require "data.php";

    if (!isset($_SESSION["logged_in"]) || !isset($_SESSION["UserID"])) {

        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();

    } elseif ($_SESSION["logged_in"] === "once") {

        $UserID = $_SESSION["UserID"];
        session_destroy();
        session_set_cookie_params(0, "/", "", true, true);
        session_start();
        $_SESSION["logged_in"] = true;
        $_SESSION["UserID"] = $UserID;

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

    if (isset($_POST["logout"])) {

        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();

    }

?>

<!Doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="description"
        content="Fuel Tech is a specialized website offering comprehensive car maintenance and care services. We provide convenient and fast solutions, including tire replacement, car washing, fuel delivery, repairs, and on-demand mechanic services. Our goal is to ensure customer satisfaction by delivering high-quality services tailored to their needs around the clock. With Fuel Tech, your car is in safe hands!" />

    <meta name="keywords"
        content="Car Maintenance, Car Care Services, Fuel Delivery, Tire Replacement, Car Washing, Auto Repairs, On-Demand Mechanics, Roadside Assistance, Car Service Near Me, Mobile Mechanic Services, Engine Repair, Oil Change Services, Affordable Car Care, Professional Auto Services, 24/7 Car Maintenance, Vehicle Inspection, Brake Repair, Fuel Tech Services, Car Detailing, Track Your Service" />

    <meta name="author" content="Fuel Tech Team" />

    <meta property="og:title" content="FUEL TECH" />

    <meta property="og:description"
        content="Fuel Tech is a specialized website offering comprehensive car maintenance and care services. We provide convenient and fast solutions, including tire replacement, car washing, fuel delivery, repairs, and on-demand mechanic services. Our goal is to ensure customer satisfaction by delivering high-quality services tailored to their needs around the clock. With Fuel Tech, your car is in safe hands!" />

    <meta property="og:image" content="https://moh7mmedehab.github.io/Fuel/Assets/Images/icon.png" />

    <meta property="og:url" content="https://moh7mmedehab.github.io/Fuel" />

    <meta property="og:type" content="website" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="CSS/style.css" />

    <link rel="stylesheet" href="CSS/loading.css" />

    <link rel="icon" href="Assets/Images/icon.png" />

    <title>Fuel Tech | For Cars Services</title>

</head>

<body>

    <div class="loading-section">

        <img src="Assets/Images/logo_light.svg" alt="Brand Logo" />

        <div class="bar">

            <span class="progress">



            </span>

        </div>

    </div>

    <nav class="container">

        <a href="#" class="brand">

            <img src="Assets/Images/logo_light.svg" alt="brand logo" />

        </a>

        <div class="menu fa-solid fa-bars">



        </div>

        <div class="s-s">

            <ul>

                <li>

                    <a href="" class="active">Home</a>

                </li>

                <li>

                    <a href="#services">Services</a>

                </li>

                <li>

                    <a href="#parteners">parteners</a>

                </li>
                <li>

                    <a href="#faqs">FAQS</a>

                </li>
                <li>

                    <a href="#faqs">Testimonials</a>

                </li>

                <li>

                    <a href="#contact">Contact</a>

                </li>

                <li>

                    <form action="" method="post">

                        <button type="submit" class="logout" name="logout">Logout</button>

                    </form>

                </li>


            </ul>

            <div class="divider">



            </div>

            <div class="options">

                <div class="translate">

                    <i class="fa-solid fa-globe"></i>

                    <p>AR</p>

                </div>

                <a class="history" href="history.php"><i class="fa-solid fa-clock-rotate-left"></i></a>

            </div>

        </div>

    </nav>

    <header class="container">

        <h1>

            Welcome to FUEL TECH

        </h1>

        <h2><span class="text"></span></h2>

    </header>
    <section id="services">
        <div class="img-slider">
            <div class="slide active">
                <div class="left">
                    <div class="info">
                        <h2>24/7 Fuel service, at petrol station rates.</h2>
                        <p> Enjoy our contactless fuel delivery straight to your car with flexible scheduling. Easy
                            booking, at your
                            convenience!</p>
                        <a href="request.php" class="btn-order">Order Now</a>
                    </div>
                </div>
                <div class="right">
                    <img src="Assets/Images/fuel.png" alt="">
                </div>
            </div>
            <div class="slide ">
                <div class="left">
                    <div class="info">
                        <h2>Stay charged with our battery change service.</h2>
                        <p>Unsure which battery you need? No bother – our specialist technicians will suggest the best
                            boost for
                            you.</p>
                        <a href="request.php" class="btn-order">Order Now</a>
                    </div>
                </div>
                <div class="right">
                    <img src="Assets/Images/battery.png" alt="">
                </div>
            </div>
            <div class="slide ">
                <div class="left">
                    <div class="info">
                        <h2>Rise and shine. Your car deserves a spa day too.</h2>
                        <p>Give your ride the glow it’s worthy of. Allow our specialist car wash team to come to you and
                            sparkle up
                            your day. </p>
                        <a href="request.php" class="btn-order">Order Now</a>
                    </div>
                </div>
                <div class="right">
                    <img src="Assets/Images/car wash.png" alt="">
                </div>
            </div>
            <div class="slide ">
                <div class="left">
                    <div class="info">
                        <h2>Tired tyres? We’ll upgrade your tread today.</h2>
                        <p>Avoid pointless trips to the garage when we can treat your ride to something fresh at your
                            doorstep.</p>
                        <a href="request.php" class="btn-order">Order Now</a>
                    </div>
                </div>
                <div class="right">
                    <img src="Assets/Images/tyres.png" alt="">
                </div>
            </div>
            <div class="slide ">
                <div class="left">
                    <div class="info">
                        <h2>Engine oil with free 10-point check</h2>
                        <p>Mobile oil change, free 10-point check & original filter replacement. Your car deserves the
                            best.</p>
                        <a href="request.php" class="btn-order">Order Now</a>
                    </div>
                </div>
                <div class="right">
                    <img src="Assets/Images/oil.png" alt="">
                </div>
            </div>
            <div class="slide ">
                <div class="left">
                    <div class="info">
                        <h2>Stuck at the roadside? No sweat.</h2>
                        <p>Ran out of fuel? Got a puncture? Battery died? Need a tow? Just Fuel tech it and we’ll be to
                            you in
                            minutes.</p>
                        <a href="request.php" class="btn-order">Order Now</a>
                    </div>
                </div>
                <div class="right">
                    <img src="Assets/Images/recuse.png" alt="">
                </div>
            </div>


            <div class="navigation">
                <div class="btn active"></div>
                <div class="btn"></div>
                <div class="btn"></div>
                <div class="btn"></div>
                <div class="btn"></div>
                <div class="btn"></div>
            </div>
        </div>
    </section>
    <section class="parteners" id="parteners">
        <h2 class="title">Parteners</h2>
        <div class="parteners_container">
            <div class="partener_card">
                <img src="Assets/Images/mobill-removebg-preview.png" alt="">
            </div>

            <div class="partener_card">
                <img src="Assets/Images/taqa-removebg-preview.png" alt="">
            </div>

            <div class="partener_card">
                <img src="Assets/Images/shell-removebg-preview.png" alt="">
            </div>

            <div class="partener_card">
                <img src="Assets/Images/gastec.png" alt="">
            </div>
        </div>
    </section>
    <div class="faqs" id="faqs">
        <div class="faq-container">
            <div class="faq-header">
                <img src="Assets/Images/logo_light.svg" alt="logo">
                <h1>Questions? Answered.</h1>
            </div>

            <!-- FAQ Item -->
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What services do you offer?
                    </h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="faq-answer">
                    <p>We provide a wide range of car services, including regular maintenance, oil changes, tire
                        replacement,
                        engine repair, car washing, and detailing.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do you provide on-site services?
                    </h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer on-site services such as car washing, battery replacement, and emergency roadside
                        assistance.
                    </p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>What are your operating hours?</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="faq-answer">
                    <p>24 Hours all week days</p>
                </div>
            </div>

        </div>
    </div>
    </section>
    <!-- Start Testimonials -->
    <div class="testimonials" id="testimonials">
        <h2 class="main-title">Testimonials</h2>
        <div class="container">
            <div class="box">
                <img decoding="async" src="Assets/Images/avatar-01.png" alt="" />
                <h3>Mohamed Farag</h3>
                <span class="title">Full Stack Developer</span>
                <div class="rate">
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est
                    natus
                    quaerat ducimus
                </p>
            </div>
            <div class="box">
                <img decoding="async" src="Assets/Images/avatar-02.png" alt="" />
                <h3>Mohamed Ibrahim</h3>
                <span class="title">Full Stack Developer</span>
                <div class="rate">
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est
                    natus
                    quaerat ducimus
                </p>
            </div>
            <div class="box">
                <img decoding="async" src="Assets/Images/avatar-03.png" alt="" />
                <h3>Shady Nabil</h3>
                <span class="title">Full Stack Developer</span>
                <div class="rate">
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est
                    natus
                    quaerat ducimus
                </p>
            </div>
            <div class="box">
                <img decoding="async" src="Assets/Images/avatar-04.png" alt="" />
                <h3>Amr Hendawy</h3>
                <span class="title">Full Stack Developer</span>
                <div class="rate">
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est
                    natus
                    quaerat ducimus
                </p>
            </div>
            <div class="box">
                <img decoding="async" src="Assets/Images/avatar-05.png" alt="" />
                <h3>Sherief Ashraf</h3>
                <span class="title">Full Stack Developer</span>
                <div class="rate">
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est
                    natus
                    quaerat ducimus
                </p>
            </div>
            <div class="box">
                <img decoding="async" src="Assets/Images/avatar-06.png" alt="" />
                <h3>Osama Mohamed</h3>
                <span class="title">Full Stack Developer</span>
                <div class="rate">
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="filled fas fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores et reiciendis voluptatum, amet est
                    natus
                    quaerat ducimus
                </p>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->
    <footer id="contact">
        <div class="social-icons">
            <img src="Assets/Images/logo_light.svg" id="footer-logo" alt="logo">
        </div>
        <div class="links">
            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
        </div>
        <div class="subscribe">
            <form action="https://formsubmit.co/ahmedsakhames@gmail.com" method="post">
                <input type="email" placeholder="Enter your email">
                <button class="btn-submit">Submit</button>
            </form>
        </div>
        <div class="copyright">Copyright &copy; All Rights Reserved At <b>Fuel Tech</b> 2025</div>
    </footer>
    <button class="scrollTop"><i class="fa-solid fa-arrow-up"></i></button>
    <script src="JS/main.js"></script>

</body>

</html>