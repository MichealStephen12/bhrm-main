<?php 
require 'php/connection.php';

if(!empty($_SESSION["uname"]) && $_SESSION["role"] == 'landlord'){
    $uname = $_SESSION['uname'];
    $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname where boardinghouses.owner = '$uname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);   
}elseif(!empty($_SESSION["uname"]) && $_SESSION["role"] == 'user'){
    if (isset($_GET['hname'])){
        $_SESSION['hname'] = $_GET['hname'];
        $hname = $_SESSION['hname'];
        $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname where boardinghouses.hname = '$hname'";
        $result = mysqli_query($conn, $query);
        $fetch = mysqli_fetch_assoc($result); 
    }
}else{
    $_GET['hname'];
    $hname = $_GET['hname'];
    $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname where boardinghouses.hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
</head>
<!-- Bootstrap CSS -->
    <style>
        /* Custom CSS */
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
            box-sizing: border-box;
            color: black;
        }

        .background {
            background-image: url(images/a2.png);
            background-size: cover;  /* Ensure the image covers the entire container */
            background-position: center; /* Position the background image centrally */
            background-repeat: no-repeat;  /* Prevent the background from repeating */
            min-height: 150vh;  /* Ensure the section is at least the height of the viewport */
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

        .login{
            width: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }.login a{
            color: white;
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

        .content-background{
            background-color: white;
            margin: 60px 200px 90px 200px;
            border-radius: 10px;
        }


        .secrow1{
            display: flex;
            justify-content: center;
            align-items: top;
        }

        .secrow1 img{
            overflow: hidden;
            width: 80%;
            height: 100%;
        }

        .text-box {
            background-color: #f9f9f9; /* Light background */
            padding: 20px;            /* Adds space inside the box */
            border-radius: 10px;       /* Rounded corners */
            box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.1); /* Subtle shadow */       /* Adds space below the box */
            font-family: Arial, sans-serif; /* Clean font */
            color: #333;               /* Text color */
        }

        .text-box h1 {
            color: #444;               /* Heading color */
            margin-bottom: 15px;       /* Space below the heading */
        }

        .text-box p {
            line-height: 1.6;          /* Improve readability */
        }

        .secrow2 h1{
            font-size: 50px;
        }

        .secrow2 p{
            margin-top: 20px;
            font-size: 20px;
        }

        .section2{
            margin: auto;
            width: 80%;
            background-color: rgb(255, 255, 255);
            height: 130px;
            font-weight: 20;
            border-radius: 10px;
            padding: 20px;
            display: flex;
            
        }

        @media (max-width: 1000px){
            .section2{
                width: 100%;
                margin: 0px auto 0 auto;
            }
        }

        .room-header{
            display: flex;
            flex-direction: row;
        }

        

        .form{
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
        }

        @media (max-width: 1000px){
            .form form{
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
            }
        }

        .form select {
            padding: 10px; /* Padding inside the select */
            font-size: 16px; /* Text size inside the select */
            border: 2px solid #ccc; /* Border around the select */
            border-radius: 8px; /* Rounded corners */
            background-color: #f9f9f9; /* Background color */
            color: #333; /* Text color */
            outline: none; /* Remove default focus outline */
            transition: border-color 0.3s ease; /* Smooth transition for border color */
        }

        @media (max-width: 1000px){
            .form select{
                width: 45%;
            }
        }

        .form select:focus {
            border-color: #007bff; /* Change border color on focus */
        }

        .btn{
            color: rgb(255, 255, 255);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
        }

        .section3{
            height: auto;
            display: flex;
            border-radius: 10px;
            flex-wrap: wrap;
            padding-top: 5px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 20px;
        }

        @media (max-width: 1000px){
            .section3{
                justify-content: center;
            }
        }

        .section3::-webkit-scrollbar {
            display: none; /* For Chrome, Safari, and Opera */
        }

        .card{
            width: 325px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 10px 20px #aaaaaa;
            margin: 20px;
            padding-bottom: 10px;
            height: auto;
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
        
        .room-btn{
            margin-top: 20px;
        }

        .card-content a{
            margin-top: 20px;
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
<body>
    <div class="background">
        <nav class="navbar">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" alt="Logo">
            </a>
            <div class="nav-links">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link" href="about.php">About</a>
                <a class="nav-link" href="contact.php">Contact</a>
                <?php if(empty($_SESSION['uname'])){
                    echo '<a class="nav-link" href="index.php">Back</a>';
                } ?>
                <?php  
                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                        echo '<a class="nav-link" href="reservation.php">View Reservation</a>';
                    } 

                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'user'){
                        echo '<a class="nav-link" href="reservation.php?">View Reservation</a>';
                        echo '<a class="nav-link" href="index.php">Back</a>';
                    }
                ?>
            </div>
            <div class="login">
                <?php
                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                        echo '<a class="btn" href="php/logout.php">Logout</a>';
                    } 
                    if (empty($_SESSION["uname"])){
                        echo '<a class="btn" href="php/login.php">Login</a>';
                    }
                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'user'){
                        echo '<a class="btn" href="php/logout.php">Logout</a>';
                    }
                ?>
            </div>
          
        </nav>


        <div class="content-background">
            <div class="section1">
                <?php if(!empty($_SESSION["uname"]) && $_SESSION["role"] == 'landlord'){
                ?> 
                <style>
                    .section1{
                        background-color: white;
                        height: auto;
                        font-weight: 20;
                        display: grid;
                        justify-content: center;
                        grid-template-columns: 1fr  1fr;
                        grid-template-rows: 1fr ;
                        border-radius: 10px;
                        padding: 30px;
                        padding-top: 30px;
                    }

                    canvas{
                        width: 500px;
                        padding: 10px;
                        justify-content: center;
                    }

                    .chart {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                    }

                    .chart h3{
                        text-align: center;
                        padding: 5px;
                    }

                    @media (max-width: 1000px){
                        canvas{
                            width: 450px;
                            padding: 10px;
                            justify-content: center;
                        }

                        .section1{
                            display: flex;
                            flex-wrap: wrap;
                            
                        }
                    }
                </style>
                <div class="chart">
                    <h3>Number of tenants per Room Type</h3>
                    <div class="chart-container">
                        <canvas id="tenantChart"></canvas>
                    </div>
                </div>
                <div class="chart">
                    <h3>Number of tenants per Room Numer</h3>
                    <div class="chart-container">
                        <canvas id="tenantOccupancyChart"></canvas>
                    </div>
                </div>
                <div class="chart">
                    <h3>Total Tenants</h3>
                    <div class="chart-container">
                        <canvas id="totalTenantsChart"></canvas>
                    </div>
                </div>
                <div class="chart">
                    <h3>Total Tenants by Month</h3>
                    <div class="chart-container">
                        <canvas id="tenantsByMonthChart"></canvas>
                    </div>
                </div>
               
               
                <?php } else {  ?>
                <style>
                    .section1{
                        background-color: white;
                        height: auto;
                        font-weight: 20;
                        display: grid;
                        grid-template-columns: 1fr  1fr;
                        border-radius: 10px;
                        padding: 20px;
                        padding-top: 30px;
                    }
                </style>
                <div class="secrow1">
                    <img src="<?php echo $fetch["image"] ?>">
                </div>
                <div class="secrow2">
                    <div class="text-box">
                        <h1>Welcome to <?php if(!empty($_SESSION['hname'])){ echo $_SESSION['hname']; }else {  echo $_GET['hname']; } ?></h1>
                        <p>Introducing <?php if(!empty($_SESSION['hname'])){ echo $_SESSION['hname']; }else {  echo $_GET['hname']; } ?>: The Epitome of Comfort and Convenience in Maranding, Lala, Lanao del Norte</p>
                        <p>Located in the serene town of Maranding, Lala, Lanao del Norte, Aziannas Place stands as the premier boarding house, offering an unparalleled living experience for students and professionals alike.</p>
                        <p>At <?php if(!empty($_SESSION['hname'])){ echo $_SESSION['hname']; }else {  echo $_GET['hname']; } ?>, we understand the importance of a comfortable 
                        and conducive living environment. Our spacious and well-appointed rooms provide a haven for relaxation and productivity. Each room is thoughtfully designed with modern furnishings, ensuring a cozy and inviting atmosphere.</p>
                    </div>
                </div>
                <?php
                }
                ?>      

                <?php
                    $roomTypes = [];
                    $tenantCounts = [];
                    
                    if(!empty($_SESSION['hname'])){ 
                        $hname = $_SESSION['hname']; 
                    }  
                    else {  
                        $hname = $_GET['hname']; 
                    }

                     // Get the boarding house name from the session
                    
                    // Query to count occupied rooms based on room type and the current boarding house (hname)
                    $query = "SELECT room_type, SUM(capacity) AS tenant_count 
                            FROM rooms 
                            WHERE hname = '$hname' AND status = 'occupied' 
                            GROUP BY room_type";
                    $result = mysqli_query($conn, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $roomTypes[] = $row['room_type'];
                        $tenantCounts[] = $row['tenant_count'];
                    }
                ?>

                <?php
                    $tenantCountsStatus = [];
                    $roomNumbers = [];
                    
                    if(!empty($_SESSION['hname'])){ 
                        $hname = $_SESSION['hname']; 
                    }  
                    else {  
                        $hname = $_GET['hname']; 
                    } // Get the boarding house name from the session
                    
                    // Query to get the number of tenants in each occupied room (based on capacity)
                    $query_tenants_status = "
                        SELECT room_no, capacity 
                        FROM rooms 
                        WHERE hname = '$hname' 
                        AND status = 'occupied'";
                        
                    $result_tenants_status = mysqli_query($conn, $query_tenants_status);
                    
                    while ($row = mysqli_fetch_assoc($result_tenants_status)) {
                        $roomNumbers[] = $row['room_no'];
                        $tenantCountsStatus[] = $row['capacity'];  // Assuming capacity means the number of tenants
                    }
                ?>
                <?php
                    $totalTenants = 0;

                    if(!empty($_SESSION['hname'])){ 
                        $hname = $_SESSION['hname']; 
                    }  
                    else {  
                        $hname = $_GET['hname']; 
                    } // Get the boarding house name from session
                    
                    // Query to get the total number of tenants based on room availability and capacity
                    $query_total_tenants = "
                        SELECT SUM(capacity) AS total_tenants
                        FROM rooms 
                        WHERE hname = '$hname' 
                        AND status = 'occupied'";
                        
                    $result_total_tenants = mysqli_query($conn, $query_total_tenants);
                    
                    if ($row = mysqli_fetch_assoc($result_total_tenants)) {
                        $totalTenants = $row['total_tenants']; // This will hold the total number of tenants
                    }
                ?>

                <?php
                    if (!empty($_SESSION['hname'])){
                        $hname = $_SESSION['hname'];
                    }else{
                        $hname = $_GET['hname'];
                    }
                    $query = "
                    SELECT 
                        MONTH(datein) AS month, 
                        SUM(capacity) AS total_tenants
                    FROM 
                        rooms
                    WHERE 
                        status = 'occupied' AND hname = '$hname'
                    GROUP BY 
                        MONTH(datein)
                    UNION ALL
                    SELECT 
                        month, 
                        0 AS total_tenants
                    FROM 
                        (SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) AS months
                    WHERE 
                        month NOT IN (SELECT MONTH(datein) FROM rooms WHERE status = 'occupied' AND hname = '$hname')
                    ORDER BY 
                        month;
                    ";
                    
                    $result = mysqli_query($conn, $query);                                       
                    $months = [];
                    $tenantCountsByMonth = [];

                    while ($row = mysqli_fetch_assoc($result)) {
                        $months[] = $row['month'];
                        $tenantCountsByMonth[] = $row['total_tenants'];
                    }

                    // Ensure months are ordered correctly
                    $data = array_combine($months, $tenantCountsByMonth);
                    ksort($data); // Sort data by month
                    $months = array_keys($data);
                    $tenantCountsByMonth = array_values($data);
       
                ?>

            </div>

            
            <div class="section2">
                <div class="room-header">
                    <div class="room-content">
                        <?php 
                            if (empty($_SESSION['uname'])){
                            ?>
                                <style>
                                    .room-content{
                                        display: flex;
                                        
                                        align-items: center;

                                    }.button{
                                    }
                                </style>
                            <?php } else{ ?>
                                <style>
                                    .room-content{
                                        display: flex;
                                        flex-direction: column;
                                        align-items: center;
                                        width: 150px;
                                    }.button{
                                        margin-top: 15px;
                                    }
                                </style>
                            <?php } ?>
                            
                        <h2>Rooms</h2>
                        <div class="button">
                            <?php 
                                if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION["role"] == "landlord"){
                                    echo "<a href='php/addroom.php' class='btn'>Add Rooms</a>"; 
                                }
                            ?>
                        </div>
                      
                        
                    </div>
                </div>


                <div class="form">
                    <form method="get" action="boardinghouse.php">
                        <!-- Retain hname in the form -->
                        <input type="hidden" name="hname" value="<?php echo isset($_GET['hname']) ? $_GET['hname'] : $_SESSION['hname']; ?>">
                        <select name="room_type" onchange="this.form.submit()">
                            <option value="">All Rooms</option>
                            <option value="Single Room" <?php if (isset($_GET['room_type']) && $_GET['room_type'] == 'Single Room') echo 'selected'; ?>>Single Room</option>
                            <option value="Double Room" <?php if (isset($_GET['room_type']) && $_GET['room_type'] == 'Double Room') echo 'selected'; ?>>Double Room</option>
                            <!-- Add other room types as needed -->
                        </select>

                        <select name="availability" onchange="this.form.submit()">
                            <option value="">All Availability</option>
                            <option value="Available" <?php if (isset($_GET['availability']) && $_GET['availability'] == 'Available') echo 'selected'; ?>>Available</option>
                            <option value="Occupied" <?php if (isset($_GET['availability']) && $_GET['availability'] == 'Occupied') echo 'selected'; ?>>Occupied</option>
                            <option value="Under Maintenance" <?php if (isset($_GET['availability']) && $_GET['availability'] == 'Under Maintenance') echo 'selected'; ?>>Under Maintenance</option>
                        </select>
                    </form>
                </div>  
            </div>


            
            <div class="section3">
                <?php 
                if (!empty($_SESSION["uname"]) && $_SESSION['role'] == 'landlord'){
                    if (isset($_GET['hname'])) {
                            $_SESSION['hname'] = $_GET['hname'];
                        }

                        $hname = isset($_SESSION['hname']) ? $_SESSION['hname'] : '';

                        if ($hname != '') {
                            // Prepare query with room type and availability filtering
                            $room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
                            $availability = isset($_GET['availability']) ? $_GET['availability'] : '';

                            $query = "SELECT * FROM rooms WHERE hname = '$hname'";

                            // Filter by room type if selected
                            if (!empty($room_type)) {
                                $query .= " AND room_type = '$room_type'";
                            }

                            // Filter by availability if selected
                            if (!empty($availability)) {
                                $query .= " AND status = '$availability'";
                            }

                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {  // Check if there are any results
                                while ($fetch = mysqli_fetch_assoc($result)) {
                                    $id = $fetch['id'];
                                    $hname = $fetch['hname'];
                                    $status = $fetch['status'];
                                    $datein = $fetch['datein'];
                                    $roomno = $fetch['room_no'];
                            ?>
                                <div class="card">
                                    <img src="<?php echo $fetch['image']?>" width="20%" class="card-img-top" alt="Room Image">
                                    <div class="card-content">
                                        <h5>Room No: <?php echo $fetch['room_no']?></h5>
                                        <p>Room Type: <?php echo $fetch['room_type']?></p>
                                        <p>Capacity: <?php echo $fetch['capacity']?></p>
                                        <p>Price: <?php echo $fetch['price']?></p>
                                        <p>Amenities: <?php echo $fetch['amenities']?></p>
                                        <p>Status: <?php echo $fetch['status']?></p>
                                        <div class="room-btn">
                                            <?php if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION["role"] == "landlord"): ?>
                                            <a href='php/addroom.php?rupdate=<?php echo $id;?>' class='btn btn-warning'>Update</a>
                                            <a href='php/function.php?rdelete=<?php echo $id;?>' class='btn btn-danger'>Delete</a>
                                            <?php else: ?>
                                            <?php if ($status == 'available'){ ?>
                                                <a href='book-in.php?roomno=<?php echo $roomno;?>' class='btn btn-warning'>Book Now!</a>
                                            <?php } ?>
                                            <?php endif; ?>
                                        </div>
                                    </div> 
                                </div>     
                                <?php 
                                            }
                                        }
                                    }
                                } 
                                ?>

                        
                
                
                <?php 
                if (!empty($_SESSION["uname"]) && $_SESSION['role'] == 'user' || empty($_SESSION["uname"])){
                    if (isset($_GET['hname'])) {
                        $_SESSION['hname'] = $_GET['hname'];
                    }

                    $hname = isset($_SESSION['hname']) ? $_SESSION['hname'] : '';

                    if ($hname != '') {
                        // Prepare query with room type and availability filtering
                        $room_type = isset($_GET['room_type']) ? $_GET['room_type'] : '';
                        $availability = isset($_GET['availability']) ? $_GET['availability'] : '';

                        $query = "SELECT * FROM rooms WHERE hname = '$hname'";

                        // Filter by room type if selected
                        if (!empty($room_type)) {
                            $query .= " AND room_type = '$room_type'";
                        }

                        // Filter by availability if selected
                        if (!empty($availability)) {
                            $query .= " AND status = '$availability'";
                        }

                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {  // Check if there are any results
                            while ($fetch = mysqli_fetch_assoc($result)) {
                                $id = $fetch['id'];
                                $hname = $fetch['hname'];
                                $status = $fetch['status'];
                                $datein = $fetch['datein'];
                                $roomno = $fetch['room_no'];
                        ?>
                                <div class="card">
                                    <img src="<?php echo $fetch['image']?>" class="card-img-top" alt="Room Image">
                                    <div class="card-content">
                                        <h5 class="card-title">Room No: <?php echo $fetch['room_no']?></h5>
                                        <p class="card-text">Room Type: <?php echo $fetch['room_type']?></p>
                                        <p class="card-text">Price: <?php echo $fetch['price']?></p>
                                        <p class="card-text">Amenities: <?php echo $fetch['amenities']?></p>
                                        <p class="card-text">Status: <?php echo $fetch['status']?></p>
                                        <div class="room-btn">
                                            <?php if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION["role"] == "landlord"): ?>
                                                <a href='php/addroom.php?rupdate=<?php echo $id;?>' class='btn btn-warning'>Update</a>
                                                <a href='php/function.php?rdelete=<?php echo $id;?>' class='btn btn-danger'>Delete</a>
                                            <?php else: ?>
                                                <?php if ($status == 'available'){ ?>
                                                    <a href='book-in.php?roomno=<?php echo $roomno;?>' class='btn btn-warning'>Book Now!</a>
                                                <?php } ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                        
                        <?php 
                                    }
                                }
                            }
                        } 
                        ?>
                </div>
                           
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Wrap chart logic in a function
        function renderCharts() {
            var roomTypes = <?php echo json_encode($roomTypes); ?>;
            var tenantCounts = <?php echo json_encode($tenantCounts); ?>;

            var ctx = document.getElementById('tenantChart').getContext('2d');
            var tenantChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: roomTypes,
                    datasets: [{
                        label: 'Number of Tenants',
                        data: tenantCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var roomNumbers = <?php echo json_encode($roomNumbers); ?>;
            var tenantCountsStatus = <?php echo json_encode($tenantCountsStatus); ?>;

            var ctx3 = document.getElementById('tenantOccupancyChart').getContext('2d');
            var tenantOccupancyChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: roomNumbers,
                    datasets: [{
                        label: 'Number of Tenants (Occupied)',
                        data: tenantCountsStatus,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var totalTenants = <?php echo json_encode($totalTenants); ?>;

            var ctxTotal = document.getElementById('totalTenantsChart').getContext('2d');
            var totalTenantsChart = new Chart(ctxTotal, {
                type: 'bar',
                data: {
                    labels: ['Total Tenants'],
                    datasets: [{
                        label: 'Number of Tenants',
                        data: [totalTenants],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var months = <?php echo json_encode($months); ?>;
            var tenantCountsByMonth = <?php echo json_encode($tenantCountsByMonth); ?>;

            var ctx = document.getElementById('tenantsByMonthChart').getContext('2d');
            var tenantsByMonthChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months.map(function(month) {
                        // Convert month number to month name
                        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        return monthNames[month - 1];
                    }),
                    datasets: [{
                        label: 'Number of Tenants',
                        data: tenantCountsByMonth,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });



        }

        // Call the function when the data is updated or after the page load
        renderCharts();

    </script>
</body>
</html>
