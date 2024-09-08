<?php

require 'php/connection.php';

if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"])){
        $roomno = $_GET['roomno'];
        $query = "select * from rooms where room_no = '$roomno'";
        $result = mysqli_query($conn, $query);
        $fetch = mysqli_fetch_assoc($result);   
    
}else{
    header('location: index.php');
}

if(isset($_POST['submit'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $datein = $_POST['datein'];
    $addons = $_POST['addons'];
    $roomno = $fetch['room_no'];
    $amenities = $fetch['amenities'];
    $image = $fetch['image'];
    $price = $fetch['price'];
    $status = $fetch['status'];
    $hname = $_SESSION['hname'];
   
    $query = "INSERT INTO `reservation` (`id`, `fname`, `lname`, `email`, `date_in`, `addons`, `room_no`, `amenities`, `price`, `image`, `status`, `res_stat`, `hname`) VALUES 
                                        ('','$fname','$lname','$email','$datein','$addons','$roomno','$amenities','$price','$image','$status', 'Pending', '$hname')";
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e6e6e6; /* Background color */
        }
    </style>

</head>
<body>
    
<section class="section1">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/logo.png" width="80" height="80" alt="">
            </a>
            <a class="btn btn-warning" href="boardinghouse.php?hname=<?php echo $_SESSION['hname'];?>">Back</a>
        </div>
    </nav>

    <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card" style="background-color: #a9a9a9;">
            <div class="card-body">
                <h5 class="card-title">Selected Room: <?php echo $fetch['room_no']; ?></h5>
                <img src="<?php echo $fetch['image'];?>" class="img-fluid mb-3" alt="">
                <p class="card-text">Price: <?php echo $fetch['price']?></p>
                <p class="card-text">Amenities: <?php echo $fetch['amenities']?></p>
            </div>
        </div>
    </div>
</div>


<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <form method="post">
            <div class="mb-3" >
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname">
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="datein" class="form-label">Date</label>
                <input type="date" class="form-control" id="datein" name="datein">
            </div>
            <div class="mb-3">
                <label for="addons" class="form-label">Additional Requests</label>
                <input type="text" class="form-control" id="addons" name="addons">
            </div>
            <button type="submit" class="btn btn-warning" name="submit">Submit</button>
        </form>
    </div>
</div>

    </div>
    
   

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
