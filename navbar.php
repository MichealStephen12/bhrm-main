<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
    // Assuming you have already set $_SESSION['uname'] when the user logs in.
        if(!empty($_SESSION['uname'])){
            $uname = $_SESSION['uname'];

            $query = "select * from users where uname = '$uname'";
            $result = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($result);

        } // Fallback to 'Guest' if session is not set
    ?>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
    }

    /* Navbar Container */
    .navbar {
        margin: 0 200px;
        background-color: #fff;
        padding: 10px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Navbar Brand */
    .navbar-brand img {
        width: 80px;
        height: 80px;
    }

    /* Navbar Links */
    .nav-links {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .nav-link {
        color: black;
        text-decoration: none;
        padding: 10px 15px;
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .nav-link:hover {
        color: #007BFF;  /* Color change on hover */
        transform: scale(1.05);  /* Slight scale effect */
    }

    /* Login/Profile Area */
    .login {
        display: flex;
        align-items: center;
        position: relative;
       
    }.login a{
        color: white;
    }

    .button{
        color: rgb(255, 255, 255);
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        background-color: #007bff;
        margin-right: 20px;
    }

    /* Profile Dropdown */
    .profile-dropdown {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .profile-img {
        width: 45px; /* Slightly increased image size */
        height: 45px; /* Slightly increased image size */
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px; /* Adds space between image and text */
    }

    .profile-dropdown span {
        font-weight: bold;
        color: #333;
        margin-right: 10px; /* Ensures there is space before the dropdown */
    }

    /* Dropdown Content */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 180px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 10;  /* Increased z-index to ensure dropdown stays above other elements */
        border-radius: 5px;
        top: 70%;  /* Position dropdown directly below the profile section */
        left: 0;  /* Align the dropdown with the left of the profile section */
        margin-top: 10px;  /* Adds extra space between the profile and the dropdown */
    }

    /* Dropdown Items */
    .dropdown-content a {
        color: black;
        padding: 10px 15px;
        text-decoration: none;
        display: block;
        transition: background-color 0.3s ease;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    /* Show Dropdown on Hover */
    .profile-dropdown:hover .dropdown-content {
        display: block;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .navbar {
            margin: 0;
            padding: 10px 20px;
            flex-direction: column;
        }

        .nav-links {
            flex-direction: column;
            margin-top: 10px;
            gap: 10px;
        }

        .login {
            margin-top: 10px;
            justify-content: flex-start;
        }
    }

    @media (max-width: 480px) {
        .navbar {
            margin: 0;
            padding: 10px 10px;
        }

        .navbar-brand img {
            width: 60px;
            height: 60px;
        }

        .nav-link {
            padding: 8px 12px;
        }

        .profile-dropdown span {
            font-size: 14px; /* Adjust font size for smaller screens */
        }
    }

    </style>

    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="Logo">
        </a>
        <div class="nav-links">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link" href="about.php">About Us</a>
            <a class="nav-link" href="contact.php">Contact</a>
            <?php
            if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'admin') {
                echo '<a class="nav-link" href="php/bhapplications.php">View Applications</a>';
            }
            if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord') {
                echo '<a class="nav-link" href="reservation.php">Reservations</a>';
            }
            ?>

            <?php if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'user'): ?>
                <a class="nav-link" href="reservation.php">My Reservation</a>
            <?php endif; ?>
        </div>
        <div class="login">
            <?php if (empty($_SESSION['uname'])): ?>
                <a class="button" href="php/login.php">Login</a>
            <?php else: ?>
            <div class="profile-dropdown">
                <!-- Display User Image and First Name -->
                <span>Welcome, <?php echo $fetch['fname']; ?></span>
                <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="php/logout.php">Logout</a>
                </div>
                <img src="<?php echo $fetch['image']?>" alt="Profile Image" class="profile-img">

            </div>
            <?php endif; ?>
        </div>
    </nav>


</body>
</html>