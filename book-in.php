<?php

require 'php/connection.php';

if (!empty($_SESSION["hname"])) {
    $roomno = $_SESSION['roomno'];
    $uname = $_SESSION['uname'];
    
    // Fetch the latest reservation for the user
    $query = "SELECT * FROM reservation WHERE email = '$uname' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);
        
        if (!empty($fetch['res_stat']) && ($fetch['res_stat'] == 'Pending' || $fetch['res_stat'] == 'Approved')) {
            // Block users with 'Pending' or 'Approved' status in their latest reservation
            $_SESSION['already_booked'] = true;
            header("location: beds.php?roomno=$roomno");
            exit();
        } else if ($fetch['res_stat'] == 'Rejected') {
            // Allow users with 'Rejected' status to proceed
            unset($_SESSION['already_booked']);
        } else if ($fetch['res_stat'] == 'Cancelled') {
            // Allow users with 'Rejected' status to proceed
            unset($_SESSION['already_booked']);
        }
    } else {
        // Handle no results case
        echo '';
    }
}





if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"])){
    $bed = $_GET['bed'];
    $query = "select * from beds where bed_no = '$bed'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);   
    $bedno = $fetch['bed_no']; 
    $bedimg = $fetch['bed_img'];
    $bedstat = $fetch['bed_stat'];
    if($result){
        $uname = $_SESSION['uname'];
        $query = "select * from users where uname = '$uname'";
        $result = mysqli_query($conn, $query);
        $fetch = mysqli_fetch_assoc($result);
        $fname = $fetch['fname'];
        $lname = $fetch['lname'];
    }if($result){
        $hname = $_SESSION['hname'];
        $query = "select * from rooms where hname = '$hname'";
        $result = mysqli_query($conn, $query);
        $fetch = mysqli_fetch_assoc($result);
    }
}else{
    $_SESSION['login_warning'] = true;
    header('location: index.php');
    exit(); // Prevent further script execution
}


if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $datein = $_POST['datein'];
    $dateout = $_POST['dateout'];
    $tenantstatus = $_POST['tenant_status'];
    $addons = $_POST['addons'];
    $roomno = $_SESSION['roomno'];
    $bedno = $_GET['bed']; 
    $capacity = $fetch['capacity'];
    $amenities = $fetch['amenities'];
    $image = $fetch['image'];
    $price = $fetch['price'];
    $status = $fetch['status'];
    $hname = $_SESSION['hname'];

    $query = "INSERT INTO `reservation` (`id`, `fname`, `lname`, `email`, `gender`, `date_in`, `date_out`, `tenant_status`, `addons`, `room_no`, `bed_no`, `bed_stat`, `capacity`, `amenities`, `price`, `image`, `status`, `res_stat`, `res_duration`, `res_reason`, `hname`) 
              VALUES ('', '$fname', '$lname', '$email', '$gender', '$datein', '$dateout', '$tenantstatus', '$addons', '$roomno', '$bedno', 'Available', '$capacity', '$amenities', '$price', '$image', '$status', 'Pending', '1 day', '', '$hname')";

    mysqli_query($conn, $query);

    header("location: thankyou.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- External CSS -->
</head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .background{
            padding: 20px;
            max-width: 1000px;
            margin: auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            margin: 0 100px;
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
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }.login a{
            color: white;
            text-decoration: none;
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

        .btn{
            color: rgb(255, 255, 255);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
        }

        button {
            grid-column: span 2;
            background-color: #007bff;
            border: none;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            color: white;
        }

        button:hover {
            background-color: #ffaa00;
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
                <?php  
                    $hname = $_SESSION['hname'];
                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                        echo '<a class="nav-link" href="reservation.php">View Reservation</a>';
                    } 

                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'user'){
                        echo '<a class="nav-link" href="reservation.php?">View Reservation</a>';
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

    <div class="section1">
        <div class="sec-content">
                <h5>Selected Room: <?php echo $_SESSION['roomno'] ?></h5>
                <img src="<?php echo  $fetch['image'] ?>" alt="">
                <p>Room Capacity: <?php echo $fetch['capacity'] ?></p>
                <p>Room Amenities: <?php echo $fetch['amenities'] ?></p>
                <p>Bed Price: <?php echo $fetch['price'] ?></p>
                <p>Room Status: <?php echo $fetch['status'] ?></p>
        </div>
        <div class="sec-content">
                <h5>Selected Bed: <?php echo $bedno ?></h5>
                <img src="<?php echo $bedimg?>" alt="">
                <h5>Bed Status: <?php echo $bedstat ?></h5>
        </div>
    </div>

    <style>
        .section1{
            width: auto;
            place-content: center;  
            display: flex;
            align-items: center;
        }
        
        .section1 h5 {
            font-size: 22px;
        }

        .setction1 p {
            
        }

        .sec-content{
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 1px solid black;
            border-radius: 10px;
            margin: 20px;
            width: auto;
            padding: 20px;
        }.sec-content img{
            width: 100%;
        }
    </style>

    <div class="form">
        <form method="post">
            <div class="form-col">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" value="<?php echo $fname ?>">
            </div>
            <div class="form-col">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" value="<?php echo $lname ?>">
            </div>
            <div class="form-col">
                <label>Status</label>
                <select id="fruits" name="realifestatus">
                    <option value="">Select Status</option>
                    <option value="Student">Student</option>
                    <option value="Worker">Worker</option>
                </select>
            </div>
            <div class="form-col">
                <label>Gender</label>
                <select id="fruits" name="gender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-col">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['uname']; ?>" readonly>
            </div>
            <div class="form-col">
                <label for="datein">Date in</label>
                <input type="date" id="datein" name="datein" min="<?php echo date('Y-m-d'); ?>" oninput="this.min = new Date().toISOString().split('T')[0]">
            </div>
            <div class="form-col">
                <label for="dateout">Date out</label>
                <input type="date" id="dateout" name="dateout" readonly>
            </div>
            <div class="form-col">
                <label for="addons">Additional Requests</label>
                <input type="text" id="addons" name="addons">
            </div>
            
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <style>
        .form{
            border: 1px solid black;
            width: auto;
            display: flex;
            justify-content: center;
        }

                
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
            width: 600px;
        }

        .form-col{
            display: flex;
            flex-direction: column;
        }
        .form-col:last-child{
            grid-column-start: 1;
            grid-column-end: 3;

            display: flex;
            flex-direction: row;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

</div>

    <script>
        document.getElementById('datein').addEventListener('change', function() {
            calculateDateOut();
        });

        function calculateDateOut() {
            const dateInInput = document.getElementById('datein');
            const dateOutInput = document.getElementById('dateout');

            // Get the selected date from the "Date in" field
            let dateInValue = new Date(dateInInput.value);

            // Check if a valid date is selected
            if (isNaN(dateInValue)) return;

            // Add 30 days to the "Date in" value
            dateInValue.setDate(dateInValue.getDate() + 30);

            // Convert the new date to the correct format (YYYY-MM-DD)
            const dateOutValue = dateInValue.toISOString().split('T')[0];

            // Set the "Date out" field with the calculated date
            dateOutInput.value = dateOutValue;
        }
    </script>

    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="bed[]"]');
        const capacity = <?php echo $fetch['capacity']; ?>; // Room capacity fetched from PHP

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('input[type="checkbox"][name="bed[]"]:checked').length;
                if (checkedCount > capacity) {
                    this.checked = false;
                    alert(`You can only book up to ${capacity} beds.`);
                }
            });
        });
    </script>

    
    <script>
        // Select all checkboxes with the class 'bed-checkbox'
        const bedCheckboxes = document.querySelectorAll('.bed-checkbox');

        // Add an event listener to each checkbox
        bedCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Uncheck all other checkboxes
                    bedCheckboxes.forEach((cb) => {
                        if (cb !== this) {
                            cb.checked = false;
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
