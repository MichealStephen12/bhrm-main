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


        // Query to count new reservations
        $query = "SELECT COUNT(*) AS new_application FROM bhapplication WHERE status = 'Pending'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $newReservations = $row['new_application'];
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <style>
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background-color: #343a40;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            justify-content: start;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar-brand {
            text-align: center;
            margin-bottom: 20px;
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #f4f4f4;
            transition: transform 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.1);
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: left;
            justify-content: center;
            gap: 10px;
        }

        .nav-links li {
            margin-bottom: 10px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #ffc107;
            color: white;
        }

        .dropdown {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown .username {
            font-weight: bold;
            font-size: 15px;
        }

        .dropdown img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            margin-right: 10px;
        }

        .li-background {
            background-color: gray; /* Gray background */
            color: white; /* Text color for contrast */
            padding: 10px 15px; /* Add some padding for spacing */
            border-radius: 5px; /* Smooth rounded corners */
            margin: 5px 0; /* Add space between list items */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            font-size: 16px; /* Font size for readability */
            transition: background-color 0.3s, color 0.3s; /* Smooth transitions */
            position: relative; /* Ensure positioning for dropdown menu */
        }

        .li-background:hover {
            background-color: #555; /* Darker gray on hover */
            color: #f0f0f0; /* Slightly lighter text color on hover */
        }

        /* Show dropdown-menu when hovering over li-background */
        .li-background:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            display: none; /* Hide menu by default */
            position: absolute;
            top: 150%; /* Align just below the parent */
            left: 0;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            min-width: 150px;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px 15px;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .dropdown-menu a:hover {
            background-color: #f0f0f0;
        }


        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-toggle {
            display: flex;
            align-items: center;
            cursor: pointer;
            justify-content: space-between;
        }

        .dropdown-toggle span {
            margin-left: auto;
            font-size: 12px;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .navbar {
                width: 180px;
                padding: 15px 10px;
            }

            .navbar-brand img {
                width: 60px;
                height: 60px;
            }

            .nav-link {
                font-size: 14px;
            }

            body {
                margin-left: 180px;
            }
        }
    </style>

    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="/bhrm-main/images/logo.png" alt="Logo">
        </a>
        <ul class="nav-links">
        <div class="li-background">
            <li class="dropdown">
                <img src="/bhrm-main/<?php echo $fetch['image']?>" alt="Profile">
            </li>
            <li class="dropdown">
                <div class="dropdown-toggle">
                    <span class="username"> Welcome <?php echo $fetch['fname']; ?></span>
                    <span>▼</span>
                </div>
                <div class="dropdown-menu">
                    <a href="/bhrm-main/profile.php">Profile</a>
                    <a href="settings.php">Settings</a>
                    <a href="/bhrm-main/php/logout.php">Logout</a>
                </div>
            </li>
        </div>
            <li><a class="nav-link active" href="/bhrm-main/dashboardadmin.php">Dashboard</a></li>
            <li><a class="nav-link" href="/bhrm-main/index.php">Manage Boarding House</a></li>
            <li><a class="nav-link" href="/bhrm-main/php/bhapplications.php">Applications (<?php echo $newReservations; ?>)</a></li>
        </ul>
    </nav>

</body>
</html>
