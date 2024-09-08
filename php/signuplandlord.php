<?php
require 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    header("location: ../index.php");
}

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $hname = $_POST['hname'];
    $conpassword = $_POST['confirmpassword'];

    $query = "SELECT * FROM `users` WHERE uname = '$uname'";
    $result = mysqli_query($conn, $query);
    $errors = array();

    if (empty($fname) && empty($lname) && empty($uname) && empty($pass) && empty($conpassword)) {
        array_push($errors, "Missing all fields");
    } elseif (empty($fname)) {
        array_push($errors, "Missing First Name");
    } elseif (empty($lname)) {
        array_push($errors, "Missing Last Name");
    } elseif (empty($uname)) {
        array_push($errors, "Missing Email");
    } elseif (empty($pass)) {
        array_push($errors, "Missing Password");
    } elseif (!filter_var($uname, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid.");
    } elseif (strlen($pass) < 3) {
        array_push($errors, "Password must be 8 characters long.");
    } elseif ($pass !== $conpassword) {
        array_push($errors, "Password didn't match.");
    } elseif ($result && mysqli_num_rows($result) > 0) {
        array_push($errors, "Email already exists.");
    }
    
    if (count($errors) > 0) {
        $error_messages = implode("\\n", $errors); // Combine error messages into a single string
        echo "<script>alert('$error_messages');</script>"; // Display the alert button with error messages
    } else {
        $query = "INSERT INTO `users`(`id`, `fname`, `lname`, `uname`, `pass`, `role`, `hname`) VALUES ('','$fname','$lname','$uname','$pass', 'landlord', `$hname`)";
        mysqli_query($conn, $query);
        echo "<script>alert('Successfully added the information.');</script>"; // Display success message in an alert button
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>REGISTRATION</title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6; /* Background color */
        }
    </style>


</head>
<body>
    <div class="container-fluid">
        <div class="row" style="padding-top: 5%;">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center; background-color: #a9a9a9; border-radius: 20px; padding: 10px;">
                <div class="row">
                    <div class="col-md-12" style="padding-bottom: 15px;">
                        <img src="../images/logo.png" height="100px">
                    </div>
                    <div class="col-md-12">
                        <span style="font-weight: 100; font-size: 17px;">Registration Form</span>
                    </div>
                    <div class="col-md-12">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>First Name</label>
                                    <input type="text" name="fname" placeholder="First Name" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Last Name</label>
                                    <input type="text" name="lname" placeholder="Last Name" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 20px 20px 10px 20px;">
                                    <label>Email</label>
                                    <input type="email" name="uname" placeholder="Your Email" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Password</label>
                                    <input type="password" name="pass" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirmpassword" placeholder="Confirm Password" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Your Boarding House</label>
                                    <input type="password" name="hname" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: 200; padding: 0px 20px 10px 20px;">
                                    <button type="submit" name="submit" class="btn btn-warning">Register</button>
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 13px; font-weight: 100;">
                                    <a href="login.php" style="text-decoration: none; color: black;">Already have an Account? Login Now</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>