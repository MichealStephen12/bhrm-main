<?php
require 'connection.php';

$errors = array(); // Initialize the errors array

if (!empty($_SESSION['uname']) && !empty($_SESSION['role'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) && empty($password)) {
        array_push($errors, "Missing all fields");
    } elseif (empty($email)) {
        array_push($errors, "Missing Email");
    } elseif (empty($password)) {
        array_push($errors, "Missing Password");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid.");
    }

    $query = "SELECT * FROM `users` WHERE uname = '$email' and pass = '$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result)) {
        $role = $row['role'];

        if ($role == 'admin') {
            $_SESSION["uname"] = $row['uname'];
            $_SESSION["role"] = $row["role"];
            header("Location: ../index.php");
            exit;
        } elseif ($role == 'user') {
            $_SESSION["uname"] = $row['uname'];
            $_SESSION["role"] = $row["role"];
            header("Location: ../index.php");
            exit;
        } elseif ($role == 'landlord'){
            $_SESSION["uname"] = $row['uname'];
            $_SESSION["role"] = $row["role"];
            $_SESSION["hname"] = $row['hname'];
            header("Location: ../boardinghouse.php");
            exit;
        }
    } else {
        array_push($errors, "Account is not found.");
    }


}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN</title>
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            background-color: #e6e6e6; /* Background color */
        }
    </style>

</head>
<body>

    <!-- Navbar -->
    <!-- Login Form -->
    <div class="container-fluid">
        <div class="row" style="padding-top: 10%;">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center; background-color: #a9a9a9; border-radius: 20px; padding: 10px;">
                <div class="row">
                    <div class="col-md-12" style="padding-bottom: 15px;">
                    <a href="../index.php"><img src="../images/logo.png" height="100px"></a>
                    </div>
                    <div class="col-md-12">
                        <span style="font-weight: 100; font-size: 17px;">Login To Your Account</span>
                    </div>
                    <div class="col-md-12">
                        <form method="POST" action="login.php">
                            <div class="row">
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 20px 20px 10px 20px;">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="Email" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: 200; padding: 0px 20px 10px 20px;">
                                    <button type="submit" class="btn btn-warning" name="submit">Sign in now</button>
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <div class="row">
                                        <div class="col-md-6" style="text-align: left; font-size: 13px; font-weight: 100;">
                                            <a href="signup.php" style="text-decoration: none; color: black;">Account? Register Now</a>
                                        </div>
                                        <div class="col-md-6" style="text-align: right; font-size: 13px; font-weight: 100;">
                                            <a href="forgot.html" style="text-decoration: none; color: black;">Forgot Password</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php 
                        if (count($errors) > 0) {
                            foreach ($errors as $error) {
                                echo "<p style='color: red; font-size: 14px; font-weight: 200; padding: 10px;'>$error</p>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
