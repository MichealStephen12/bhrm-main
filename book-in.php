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
    $capacity = $fetch['capacity'];
    $amenities = $fetch['amenities'];
    $image = $fetch['image'];
    $price = $fetch['price'];
    $status = $fetch['status'];
    $hname = $_SESSION['hname'];
   
    $query = "INSERT INTO `reservation` (`id`, `fname`, `lname`, `email`, `date_in`, `addons`, `room_no`, `capacity`, `amenities`, `price`, `image`, `status`, `res_stat`, `hname`) VALUES 
                                        ('','$fname','$lname','$email','$datein','$addons','$roomno', '$capacity','$amenities','$price','$image','$status', 'Pending', '$hname')";
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
    <link rel="stylesheet" href="styles.css">
</head>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    section.section1 {
        padding: 20px;
        max-width: 1000px;
        margin: auto;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    nav {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 10px 0;
    }

    nav img {
        height: 20%;
        width: 20%;
    }

    nav a:last-child {
        background-color: #007bff;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    h5 {
        font-size: 22px;
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 8px;
    }

    form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
    }

    form div {
        display: flex;
        flex-direction: column;
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
    
<section class="section1">
    <nav>
        <a href="#">
            <img src="images/logo.png">
        </a>
        <a href="boardinghouse.php?hname=<?php echo $_SESSION['hname'];?>">Back</a>
    </nav>

    <div>
        <div>
            <div>
                <h5>Selected Room: <?php echo $fetch['room_no']; ?></h5>
                <img src="<?php echo $fetch['image'];?>" alt="">
                <p>Capacity: <?php echo $fetch['capacity']?></p>
                <p>Price: <?php echo $fetch['price']?></p>
                <p>Amenities: <?php echo $fetch['amenities']?></p>
            </div>
        </div>
    </div>

    <div>
        <div>
            <form method="post">
                <div>
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname">
                </div>
                <div>
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname">
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div>
                    <label for="datein">Date</label>
                    <input type="date" id="datein" name="datein">
                </div>
                <div>
                    <label for="addons">Additional Requests</label>
                    <input type="text" id="addons" name="addons">
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
</section>

</body>
</html>
