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
            padding: 0;
            overflow-x: hidden;
            color: black;
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

        .login {
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

        table {
            border-collapse: collapse;
        
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
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

        button:hover {
            background-color: #0056b3;
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
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" alt="">
        </a>
        <div class="nav-links">
            <a  class="nav-link" href="index.php">Home</a>
            <a  class="nav-link" href="about.php">About</a>
            <a  class="nav-link" href="contact.php">Contact</a>
            <?php  
                if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                    echo '<a  class="nav-link" href="reservation.php">View Reservation</a>';
                }
            ?>
            <a  class="nav-link" href="boardinghouse.php?hname=<?php echo $_SESSION['hname'];?>">Back</a>
        </div>
    </nav>



    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Date in</th>
                <th>Add ons</th>
                <th>Room Number</th>
                <th>Booked Beds</th>
                <th>Room Capacity</th>
                <th>Amenities</th>
                <th>Price</th>
                <th>Image</th>
                <th>Status</th>
                <th>Reservation Status</th>
                <th>Reservation Duration</th>
                <th>Reservation Reason</th>
                <?php  
                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                        echo '<th>Actions</th>'; 
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($_SESSION) && $_SESSION['role'] == 'landlord') {
                $hname = $_SESSION['hname'];
                $query = "SELECT * FROM reservation WHERE hname = '$hname'";
                $result = mysqli_query($conn, $query);
                while ($fetch = mysqli_fetch_assoc($result)) {
                    $id = $fetch['id'];
                    $roomno = $fetch['room_no'];
            ?>
                    <tr>
                        <td><?php echo $fetch['id'] ?></td>
                        <td><?php echo $fetch['fname'] ?></td>
                        <td><?php echo $fetch['lname'] ?></td>
                        <td><?php echo $fetch['email'] ?></td>
                        <td><?php echo $fetch['gender'] ?></td>
                        <td><?php echo $fetch['date_in'] ?></td>
                        <td><?php echo $fetch['addons'] ?></td>
                        <td><?php echo $fetch['room_no'] ?></td>
                        <td><?php echo $fetch['beds'] ?></td>
                        <td><?php echo $fetch['capacity'] ?></td>
                        <td><?php echo $fetch['amenities'] ?></td>
                        <td><?php echo $fetch['price'] ?></td>
                        <td><img src="<?php echo $fetch['image'] ?>"></td>
                        <td><?php echo $fetch['status'] ?></td>
                        <td><?php echo $fetch['res_stat'] ?></td>
                        <td><?php echo $fetch['res_duration'] ?></td>
                        <td><?php echo $fetch['res_reason'] ?></td>
                        
                        <?php  
                            if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                        ?>
                        <td>
                            <a href="php/function.php?approve=<?php echo $id;?>"><button>Approve</button></a>
                            <a href="php/function.php?reject=<?php echo $id;?>"><button  class="reject">Reject</button></a>
                        </td>
                        <?php } ?>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>

        <tbody>
            <?php
            if (!empty($_SESSION) && $_SESSION['role'] == 'user') {
                $uname = $_SESSION['uname'];
                $hname = $_SESSION['hname'];
                $query = "SELECT * FROM reservation WHERE email = '$uname' AND hname = '$hname'";
                $result = mysqli_query($conn, $query);
                while ($fetch = mysqli_fetch_assoc($result)) { 
            ?>
                <tr>
                    <td><?php echo $fetch['id'] ?></td>
                    <td><?php echo $fetch['fname'] ?></td>
                    <td><?php echo $fetch['lname'] ?></td>
                    <td><?php echo $fetch['email'] ?></td>
                    <td><?php echo $fetch['gender'] ?></td>
                    <td><?php echo $fetch['date_in'] ?></td>
                    <td><?php echo $fetch['addons'] ?></td>
                    <td><?php echo $fetch['room_no'] ?></td>
                    <td><?php echo $fetch['beds'] ?></td>
                    <td><?php echo $fetch['capacity'] ?></td>
                    <td><?php echo $fetch['amenities'] ?></td>
                    <td><?php echo $fetch['price'] ?></td>
                    <td><img src="<?php echo $fetch['image'] ?>"></td>
                    <td><?php echo $fetch['status'] ?></td>
                    <td><?php echo $fetch['res_stat'] ?></td>
                    <td><?php echo $fetch['res_duration'] ?></td>
                    <td><?php echo $fetch['res_reason'] ?></td>
                </tr>
            <?php }} ?>
        </tbody>
    </table>
  
</body>
</html>
