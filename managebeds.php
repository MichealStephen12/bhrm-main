<?php 
require 'php/connection.php';

if(!empty($_SESSION["uname"]) && $_SESSION["role"] == 'landlord'){
    $uname = $_SESSION['uname'];
    $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname where boardinghouses.owner = '$uname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);   
    echo "
    <script src='jquery.min.js'></script>
    <link rel='stylesheet' href='toastr.min.css'/>
    <script src='toastr.min.js'></script>
    <script>
        $(document).ready(function() {
            // Check if the login message should be displayed
            " . (isset($_SESSION['login_message_displayed']) ? "toastr.success('Logged in Successfully');" : "") . "
        });
    </script>
    ";

    // Unset the session variable to avoid repeated notifications
    if (isset($_SESSION['login_message_displayed'])) {
        unset($_SESSION['login_message_displayed']);
    }
}else{
    header('location: index.php');
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
            font-family: Arial, sans-serif;
            margin-left: 220px; /* Offset for the navbar */
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background-color: white;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar-brand {
            text-align: center;
            margin-bottom: 30px;
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
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: left;
            flex-grow: 1;
        }

        .nav-links li {
            margin-bottom: 15px;
        }

        .nav-link {
            color: black;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link:hover {
            background-color: #f0f0f0;
            color: #007bff;
        }

        .login {
            text-align: center;
            margin-top: -10px; /* Adjusting to move the logout button up */
        }

        .login .btn {
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .login .btn:hover {
            background-color: #0056b3;
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

        .content-background{
            background-color: white;
            margin: 60px 200px 90px 200px;
            border-radius: 10px;
        }

        .back{
            height: 100px;
            display: flex;
            justify-content: right;
            align-items: center;
            margin-right: 50px;
        }.back a{
           height: auto;
        }

        .section2{
            height: 100px;
            display: flex;
            justify-content: left;
            align-items: center;
            margin: 0px 100px;
        }

        @media (max-width: 1000px){
            .section2{
                width: 100%;
                margin: 0px auto 0 auto;
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

        .section3{
            height: auto;
            display: flex;
            border-radius: 10px;
            flex-wrap: wrap;
            justify-content: center;
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
            width: 320px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 10px 20px #aaaaaa;
            margin: 20px;
            display: flex;
            flex-direction: column; /* Ensure the flex direction is column */
            justify-content: space-between; /* Align items to the bottom */
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

    </style>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="Logo">
        </a>
        <ul class="nav-links">
            <li><a class="nav-link" href="dashboard.php">Dashboard</a></li>
            <li><a class="nav-link" href="manageroom.php">Manage Rooms</a></li>
            <li><a class="nav-link" href="managereservation.php">Reservations</a></li>
            <li><a class="nav-link" href="payment.php">Payments</a></li>
            <li><a class="nav-link" href="reports.php">Reports</a></li>
        </ul>
        <div class="login">
            <a class="btn" href="php/logout.php">Logout</a>
        </div>
    </nav>


    <div class="section2">
        <div class="button">
            <a href='php/bedfunction.php' class='btn'>Add Rooms</a>
        </div>
    </div>
            
    <div class="section3">            
        <?php 
            $hname = $_SESSION['hname'];
            $roomno = $_GET['roomno'];
            $_SESSION['roomno'] = $roomno;

            $query = "SELECT * FROM beds WHERE hname = '$hname' and roomno = '$roomno' order by roomno ";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {  // Check if there are any results
                while ($fetch = mysqli_fetch_assoc($result)) {
                    $id = $fetch['id'];
        ?>
            <div class="card">
                <img src="<?php echo $fetch['bed_img']?>" width="20%" class="card-img-top" alt="Room Image">
                <div class="card-content">
                    <h5>Bed No: <?php echo $fetch['bed_no']?></h5>
                    <p>Bed Status: <?php echo $fetch['bed_stat']?></p>
                    <div class="room-btn"> 
                        <a href='php/bedfunction.php?bupdate=<?php echo $id;?>' class='btn btn-warning'>Update</a>
                        <a href='php/bedfunction.php?bdelete=<?php echo $id;?>' class='btn btn-danger'>Delete</a>      
                    </div>
                </div> 
            </div>     
        <?php } } ?>
    </div>
                           
     

</body>
</html>
