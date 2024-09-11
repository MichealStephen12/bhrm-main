<?php

require 'php/connection.php';
if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"] == 'user')) {
    unset($_SESSION['hname']);
}

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    $uname = $_SESSION["uname"];
    $role = $_SESSION["role"];
    $result = mysqli_query($conn, "select * from users where uname = '$uname'");
    $fetch = mysqli_fetch_assoc($result);
}

if (!empty($_SESSION["uname"]) && $_SESSION["role"] == 'landlord') {
    header('location: boardinghouse.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        
        a{
            text-decoration: none;
            color: black;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            color: black;
        }

        .background {
            background-image: url(images/a2.png);
            background-size: cover;  /* Ensure the image covers the entire container */
            background-position: center; /* Position the background image centrally */
            background-repeat: no-repeat;  /* Prevent the background from repeating */
            min-height: 100vh;  /* Ensure the section is at least the height of the viewport */
        }


        .navbar {
            margin: 0 200px;
            background-color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: black;
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
        }

        .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-link {
            color: black;
            text-decoration: none;
            padding: 0 10px;
        }

        .login {
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @media (max-width: 768px) {
            .navbar {
                margin: 0;
                padding: 10px 20px;
                flex-direction: column;
            }

            .nav-links {
                flex-direction: column;
                margin-top: 10px;
            }

            .nav-link {
                padding: 5px 0;
            }

            .login {
                margin-top: 10px;
            }
        }


        .section1 {
            background-color: white;
            margin: 60px 200px 60px 200px;
            height: auto;
            font-weight: 20;
            display: flex;
            border-radius: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center; 
            padding: 20px;
            text-align: center;
        }

        .section1 h1 {
            font-size: 1.5vw; /* Adjust based on screen width */
            margin-bottom: 10px;
        }

        .section1 p {
            width: 80%; /* Use percentage for responsive width */
            font-size: 1.3vw; /* Adjust font-size based on viewport */
            margin-top: 20px;
        }

        /* Responsive adjustments for smaller screens */
        @media screen and (max-width: 768px) {
            .section1 {
                margin: 40px 20px;
            }

            .section1 h1 {
                font-size: 5vw; /* Larger text for smaller screens */
            }

            .section1 p {
                font-size: 3.5vw; /* Larger paragraph text for better readability */
                width: 100%; /* Make the text span the full width */
            }
        }


        .section2{
            background-color: white;
            margin: 60px 200px 60px 200px;
            padding-top: 20px;
            display: flex;
            border-radius: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card{
            width: 325px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 10px 20px #aaaaaa;
            margin: 20px;
            padding-bottom: 10px;
        }

        .card img{
            width: 100%;
            height: auto;
        }
        
        .card-content{
            padding: 16px;
        }

        .card-content h5{
            font-size: 28px;
            margin-bottom: 8px;
        }

        .card-content p{
            color: black;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .card-content a{
            margin-top: 20px;
        }

        .button{
            color: black;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
            font-family: Arial, sans-serif;
        }

        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .footer .row {
            display: flex;
            justify-content: space-between;
        }

        .footer-col {
            width: 30%;
        }

        .footer-col h4 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .footer-col ul {
            list-style-type: none;
            padding-left: 0;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-col ul li a:hover {
            color: #ffc107;
        }

        .footer-col .social-links a {
            color: white;
            margin-right: 10px;
            font-size: 15px;
            transition: color 0.3s ease;
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        .footer-col .social-links a:first-child {
            margin-top: 0px;
        }

        .footer-col .social-links a:hover {
            color: #ffc107;
        }

        .footer-bottom-text {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="background">
        <nav class="navbar">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Logo">
            </a>
            <div class="nav-links">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="about.php">About Us</a>
                <a class="nav-link" href="contact.php">Contact</a>
                <?php
                if (!empty ($_SESSION['uname']) && $_SESSION['role'] == 'admin') {
                    echo '<a class="nav-link" href="php/bhapplications.php">View Applications</a>';
                }
                ?>
            </div>
            <div class="login">
                <?php
                    if ($_SESSION == true) {
                        echo '<a class="button" href="php/logout.php">Logout</a>';
                    } else {
                        echo '<a class="button" href="php/login.php">Login</a>';
                    }
                ?>
            </div>
        </nav>

        <div class="section1">
            <h1>Welcome to Maranding Boarding House Center
                <?php if (!empty($_SESSION)) {
                    echo $fetch['fname'];
                } ?>
            </h1>
            <p>Where we show you the best boarding houses around Maranding. Please select your desired boarding house and
                have an amazing experience and chill moments ahead.</p>
        </div>

        <div class="section2">
            <?php
                if (!empty($_SESSION) && $_SESSION['role'] == 'admin') {
                    $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname";
                    $result = mysqli_query($conn, $query);
                    while ($fetch = mysqli_fetch_assoc($result)) {
                        $id = $fetch['id'];
                        $hname = $fetch['hname'];
                ?>  
            <div class="card">
                <img src="<?php echo $fetch["image"] ?>" width="40%" alt="Boarding House">
                <div class="card-content">
                    <h5>Name: <?php echo $fetch["hname"] ?></h5>
                    <p>Owner: <?php echo $fetch["owner"] ?></p>
                    <p>Address: <?php echo $fetch["haddress"] ?></p>
                </div> 
            </div>
            <?php
                }
            }
            ?>
            
            <?php
            if (empty($_SESSION) || $_SESSION['role'] == 'user') {
                $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname";
                $result = mysqli_query($conn, $query);
                while ($fetch = mysqli_fetch_assoc($result)) {
                    $id = $fetch['id'];
                    $hname = $fetch['hname'];
            ?>   
            <div class="card">
                <img src="<?php echo $fetch["image"] ?>" alt="">
                <div class="card-content">
                    <h5>Name: <?php echo $fetch["hname"] ?></h5>
                    <p>Owner: <?php echo $fetch["landlord"] ?></p>
                    <p>Address: <?php echo $fetch["haddress"] ?></p>
                    <p>Contact No#: <?php echo $fetch["contactno"] ?></p>
                    <br>
                    <?php if (!empty($_SESSION) && $_SESSION['role'] == 'admin'): ?>
                        <a href="php/function.php?edit=<?php echo $id; ?>" class="button">Update</a>
                        <a href="php/function.php?delete=<?php echo $id; ?>" class="button">Delete</a>
                    <?php else : ?>
                        <a href="boardinghouse.php?hname=<?php echo $hname; ?>" class="button">More Details</a>
                    <?php endif; ?>
                </div>     
            </div>
            <?php
                }
            }
            ?>
        </div>


        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="footer-col">
                        <h4>About Us</h4>
                        <ul>
                            <li><a href="#">Company Info</a></li>
                            <li><a href="#">Our Team</a></li>
                            <li><a href="#">Careers</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Follow Us</h4>
                        <div class="social-links">
                            <a href="#">Facebook<i class="fab fa-facebook-f"></i></a>
                            <a href="#">Twitter<i class="fab fa-twitter"></i></a>
                            <a href="#">Instagram<i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <p class="footer-bottom-text">© 2024 Your Company Name. All Rights Reserved.</p>
            </div>
        </footer>
    </div>
</body>

</html>
