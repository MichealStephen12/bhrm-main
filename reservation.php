<?php require 'php/connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
} else {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESERVATION</title>
</head>
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
            font-family: Arial, sans-serif;
            margin-left: 220px; /* Offset for the navbar */
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
            min-height: auto;  /* Ensure the section is at least the height of the viewport */
        }

        button {
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
            transition: background-color 0.3s;
        }

        button:disabled {
            background-color: #ccc; /* Light gray background */
            color: #666; /* Darker gray text */
            border: 1px solid #999; /* Gray border */
            cursor: not-allowed; /* Change cursor to indicate it's not clickable */
            opacity: 0.6; /* Slightly transparent */
        }

        button:hover {
            background-color: #0056b3;
        }

        button.login {
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
        }

        /* Reject button style */
        button.reject {
            background-color: #dc3545; /* Bootstrap danger color */
        }

        button.reject:hover {
            background-color: #c82333; /* Darker shade on hover */
        }

        img {
            width: 150px; /* Adjust the size of the images */
            height: auto;
        }


    </style>

<body>
    <?php include 'navbar.php'; ?>
    
    

    <?php if(!empty($_SESSION['role']) && $_SESSION['role'] == 'landlord'): ?>
        
    <?php else: ?>
        <style>

            .back{
                height: 100px;
                display: flex;
                justify-content: right;
                align-items: center;
                margin-right: 300px;
            }.back a{
                height: auto;
            }
        
            @media (max-width: 479px){
                .back{
                    height: 100px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin-right: 0;
                }.back a{
                    height: auto;
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
        </style>
        <div class="back">
            <div>
                <?php 
                    if(empty($_SESSION['uname'])){
                        echo "<a class='btn' href='index.php'>Back</a>";
                    }else{
                        echo "<a class='btn' href='index.php'>Back</a>";
                    }
                ?>
            </div>     
        </div>
    <?php endif; ?>


    <div class="container">    
    <?php 
        if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'user' && !empty($_SESSION['hname'])) {
            $uname = $_SESSION['uname'];
            $hname = $_SESSION['hname'];
            $query = "SELECT * FROM reservation WHERE email = '$uname' AND hname = '$hname' order by id desc";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)) {
        ?>
        <div class="card">
            <div class="card-footer">
                <img src="<?php echo $fetch['image']; ?>">
            </div>
            <div class="card-header">
                <h5>Reservation #<?php echo $fetch['id']; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                        <p><strong>Guest Information:</strong></p>
                        <p>Name: <?php echo $fetch['fname'] . ' ' . $fetch['lname']; ?></p>
                        <p>Email: <?php echo $fetch['email']; ?></p>
                        <p>Gender: <?php echo $fetch['gender']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Room Information:</strong></p>
                        <p>Room No: <?php echo $fetch['room_no']; ?></p>
                        <p>Room Capacity: <?php echo $fetch['capacity']; ?></p>
                        <p>Room Status: <?php echo $fetch['status']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Bed Information:</strong></p>
                        <p>Bed Selected: <?php echo $fetch['bed_no'];?> </p>
                        <p>Bed Price: <?php echo $fetch['bed_price']; ?> / Month</p>
                        <p>Bed Status: <?php echo $fetch['bed_stat'];?> </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Reservation Details:</strong></p>
                        <p>Date In: <?php echo $fetch['date_in']; ?></p>
                        <p>Date Out: <?php echo $fetch['date_out']; ?></p>
                        <p>Reservation Status: <?php echo $fetch['res_stat']; ?></p>
                        <p>Reservation Duration: <?php echo $fetch['res_duration']; ?></p>
                        <p>Reservation Reason: <?php echo $fetch['res_reason']; ?></p>
                    </div>
                    <?php
                        $uname = $_SESSION['uname'];
                        $hname = $_SESSION['hname'];
                        $query = "SELECT * FROM payments WHERE email = '$uname' AND hname = '$hname' ORDER BY id DESC";
                        $result = mysqli_query($conn, $query);

                        // Check if there are any payments
                        if (mysqli_num_rows($result) > 0) {
                            // Fetch payment data
                            $fetch = mysqli_fetch_assoc($result);
                            $payment = $fetch['payment'];
                            $paydate = $fetch['pay_date'];
                            $paystat = $fetch['pay_stat'];
                    ?>
                        <div class="col-md-6">
                            <p><strong>Payment Details:</strong></p>
                            <p>Payment: <?php echo $payment . ' PHP'; ?></p>
                            <p>Payment Date: <?php echo $paydate; ?></p>
                            <p>Payment Status: <?php echo $paystat; ?></p>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-6">
                            <p><strong>No payments found for your account.</strong></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } } ?>


        <?php
            $uname = $_SESSION['uname'];
            $query = "SELECT * FROM boardinghouses order by id desc";
            $result = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($result);
            $hname = $fetch['hname'];

            $query = "SELECT * FROM reservation where email = '$uname' and hname = '$hname' order by id desc";
            $result = mysqli_query($conn, $query);
            $fetch = mysqli_fetch_assoc($result)
        ?>

        <?php 
        if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'user' && empty($_SESSION['hname'])) {
            $uname = $_SESSION['uname'];
            $query = "SELECT * FROM reservation WHERE email = '$uname' order by id desc";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)) {
                $hname = $fetch['hname'];
        ?>
        <div class="card">
            <div class="card-footer">
                <img src="<?php echo $fetch['image']; ?>">
            </div>
            <div class="card-header">
                <h5>Boarding House: <?php echo $fetch['hname']; ?></h5>
            </div>
            <div class="card-header">
                <h5>Reservation #<?php echo $fetch['id']; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Guest Information:</strong></p>
                        <p>Name: <?php echo $fetch['fname'] . ' ' . $fetch['lname']; ?></p>
                        <p>Email: <?php echo $fetch['email']; ?></p>
                        <p>Gender: <?php echo $fetch['gender']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Room Information:</strong></p>
                        <p>Room No: <?php echo $fetch['room_no']; ?></p>
                        <p>Room Capacity: <?php echo $fetch['capacity']; ?></p>
                        <p>Room Status: <?php echo $fetch['status']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Bed Information:</strong></p>
                        <p>Bed Selected: <?php echo $fetch['bed_no'];?> </p>
                        <p>Bed Price: <?php echo $fetch['bed_price']; ?> / Month</p>
                        <p>Bed Status: <?php echo $fetch['bed_stat'];?> </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Reservation Details:</strong></p>
                        <p>Date In: <?php echo $fetch['date_in']; ?></p>
                        <p>Date Out: <?php echo $fetch['date_out']; ?></p>
                        <p>Reservation Status: <?php echo $fetch['res_stat']; ?></p>
                        <p>Reservation Duration: <?php echo $fetch['res_duration']; ?></p>
                        <p>Reservation Reason: <?php echo $fetch['res_reason']; ?></p>
                    </div>
                    <?php
                        $uname = $_SESSION['uname'];
                        $query = "SELECT * FROM payments WHERE email = '$uname' AND hname = '$hname' ORDER BY id DESC";
                        $result = mysqli_query($conn, $query);

                        // Check if there are any payments
                        if (mysqli_num_rows($result) > 0) {
                            // Fetch payment data
                            $fetch = mysqli_fetch_assoc($result);
                            $payment = $fetch['payment'];
                            $paydate = $fetch['pay_date'];
                            $paystat = $fetch['pay_stat'];
                    ?>
                        <div class="col-md-6">
                            <p><strong>Payment Details:</strong></p>
                            <p>Payment: <?php echo $payment . ' PHP'; ?></p>
                            <p>Payment Date: <?php echo $paydate; ?></p>
                            <p>Payment Status: <?php echo $paystat; ?></p>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-6">
                            <p><strong>No payments found for your account.</strong></p>
                        </div>
                    <?php } ?>
                </div>
                
            </div>
        </div>
        <?php } } ?>
    </div>


    <style>
        .container{
            margin: 0 250px;
            width: auto;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr;
            overflow-y: scroll;
            overflow-x: scroll;
            height: auto;
        } h1{
            text-align: center;
        }
        .container::-webkit-scrollbar {
            display: none; /* For Chrome, Safari, and Opera */
        }.container.second-container{
            margin: 0 250px;
            width: auto;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr;
            overflow-y: scroll;
            overflow-x: scroll;
            height: auto;
        } 

        @media (max-width: 479px){
            .container{
                width: auto;
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                grid-template-rows: 1fr;
                overflow-y: scroll;
                overflow-x: scroll;
                height: auto;
            }
        }

        .card {
            margin: 20px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            width: 550px;
        }

        @media (max-width: 479px){
            .card {
                margin: 20px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                border: 1px solid #ccc;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
                width: 280px;
            }
        }

        .card-header {
            background-color: #f0f0f0;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .card-body {
            width: auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .col-md-6{
            padding: 2px;
        }.col-md-6 p{
            margin-bottom: 3px;
        }

        @media (max-width: 479px){
                .card-body {
                    width: auto;
                    padding: 20px;
                    display: flex;
                    flex-direction: column;
                    grid-template-columns: 0fr;
                }
            }

        .card-footer {
            padding: 10px;
            background-color: #f0f0f0;
            border-top: 1px solid #ccc;
        }

        .card-footer img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }

        .reject {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .reject:hover {
            background-color: #cc0000;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3e8e41;
        }

        .button-row{
            margin: auto;
            grid-column-start: 1;
            grid-column-end: 3;

        }
    </style>
  
</body>
</html>
