<?php
require 'php/connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    $uname = $_SESSION["uname"];
    $role = $_SESSION["role"];
    $result = mysqli_query($conn, "select * from users where uname = '$uname'");
    $fetch = mysqli_fetch_assoc($result);
} else {
    echo '<script> alert("YOU MUST LOG IN FIRST")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
           
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .section1 {
            background-color: gray;
            padding: 30px;
            border-radius: 10px;
            color: #fff;
            text-align: center;
            max-width: 800px;
        }

        .navbar {
            background-color: #a9a9a9;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
        }

        .nav-link {
            color: #fff !important;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #333;
        }

        .content h1 {
            margin-bottom: 20px;
        }

        .content p {
            text-align: justify;
        }
    </style>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
                <?php
                if ($_SESSION == true) {
                    echo '<a class="btn btn-warning" href="php/logout.php">Logout</a>';
                } else {
                    echo '<a class="btn btn-warning" href="php/login.php">Login</a>';
                }
                ?>
            </ul>
        </div>
    </nav>

    <section class="section1">
        <div class="content">
            <h1>Thank you For Booking in! <?php if (empty($_SESSION)) {
                                                echo '';
                                            } else {
                                                echo $fetch['fname'];
                                            } ?></h1>
            <p>"We would like to express our deepest gratitude to all our valued tenants for choosing Azzians Place as your home away from home. Your trust and confidence in our services have greatly contributed to our success and growth. It's been a privilege to serve you, and we look forward to providing you with the comfort and convenience you've come to expect from us. Thank you for being a part of our Azzians Place family." now just wait for our confirmation and visit us for further discussions.</p>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
