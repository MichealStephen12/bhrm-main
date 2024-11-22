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
    </style>
<body>
    <?php include 'navigationbar.php'; ?>

    <div class="section2">
        <div class="button">
            <a href='php/roomfunction.php' class='btn'>Add Rooms</a>
        </div>
    </div>
        
    <div class="section3">            
        <?php 
            $hname = $_SESSION['hname'];

            $query = "SELECT * FROM rooms WHERE hname = '$hname' order by room_no";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {  // Check if there are any results
                while ($fetch = mysqli_fetch_assoc($result)) {
                    $id = $fetch['id'];
                    $hname = $fetch['hname'];
                    $tenantcount = $fetch['current_tenant'];
                    $roomno = $fetch['room_no'];
                    $capacity = $fetch['capacity'];
            ?>
            <div class="card">
                <img src="<?php echo $fetch['image']?>" width="20%" class="card-img-top" alt="Room Image">
                <div class="card-content">
                    <h5>Room No: <?php echo $fetch['room_no']?></h5>
                    <p>Capacity: <?php echo $fetch['capacity']?></p>
                    <p>Price: <?php echo $fetch['price']?></p>
                    <p>Amenities: <?php echo $fetch['amenities']?></p>
                    <p>Tenant Type:  <?php echo $fetch['tenant_type']?> Only </p>
                    <p>Current Tenant: <?php echo $fetch['current_tenant']; ?> / <?php echo $fetch['capacity']?> </p>
                    <p>Room Floor:  <?php echo $fetch['room_floor']?> </p>
                    <p>Status: <?php echo $fetch['status']?></p>
                    <style>
                        .card{
                            width: 360px;
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
                            height: 50%;
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

                    </style>
                    <div class="room-btn"> 
                        <a href='php/roomfunction.php?rupdate=<?php echo $id;?>' class='btn btn-warning'>Update</a>
                        <a href='php/roomfunction.php?rdelete=<?php echo $id;?>' class='btn btn-danger'>Delete</a>  
                        <a href='managebeds.php?roomno=<?php echo $roomno;?>' class='btn btn-warning'>Manage Beds</a>
                        <?php 
                        if ($tenantcount == $capacity){ 
                            $query = "UPDATE rooms SET status = 'Full' WHERE room_no = $roomno";
                            mysqli_query($conn, $query);

                            $query = "UPDATE reservation SET status = 'Full' WHERE room_no = $roomno";
                            mysqli_query($conn, $query);
                        ?>
                            
                        <?php }
                        else if ($tenantcount <= $capacity){
                            $query = "UPDATE rooms SET status = 'available' WHERE room_no = $roomno";
                            mysqli_query($conn, $query);

                            $query = "UPDATE reservation SET status = 'available' WHERE room_no = $roomno";
                            mysqli_query($conn, $query);
                        ?>  
                         <?php }?>
                    </div>
                </div> 
            </div>     
        <?php } } ?>

    </div>
                           
</body>
</html>
