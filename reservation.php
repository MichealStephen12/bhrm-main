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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #a9a9a9;
            border-spacing: 10%;
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
        }

        .nav-link {
            color: #fff !important;
        }

        .content {
            padding-top: 100px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" width="80" height="80" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <?php  
                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                        echo '<li class="nav-item"><a class="nav-link" href="reservation.php">View Reservation</a></li>';
                    }
                ?>
                <li class="nav-item">
                    <a class="btn btn-warning" href="boardinghouse.php?hname=<?php echo $_SESSION['hname'];?>">Back</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


    <section> 
        <div class="content">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Date in</th>
                        <th>Add ons</th>
                        <th>Room Number</th>
                        <th>Amenities</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Reservation Status</th>
                        <?php  
                            if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                                echo '<th>Actions</th>'; 
                            }else{
                                echo '';
                            }
                        ?>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION) && $_SESSION['role'] == 'landlord') {
                        $hname = $_SESSION['hname'];
                        $query = "select * from reservation where hname = '$hname'";
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
                                <td><?php echo $fetch['date_in'] ?></td>
                                <td><?php echo $fetch['addons'] ?></td>
                                <td><?php echo $fetch['room_no'] ?></td>
                                <td><?php echo $fetch['amenities'] ?></td>
                                <td><?php echo $fetch['price'] ?></td>
                                <td><img src="<?php echo $fetch['image'] ?>"></td>
                                <td><?php echo $fetch['status'] ?></td>
                                <td><?php echo $fetch['res_stat'] ?></td>
                                 
                                <?php  
                                    if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord'){
                                ?>
                                <td>
                                    <a href="php/function.php?approve=<?php echo $roomno;?>"><button class="btn btn-warning">Approve</button></a>
                                    <a href="php/function.php?reject=<?php echo $roomno;?>"><button class="btn btn-danger">Reject</button></a>
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
                        $query = "select * from reservation where email = '$uname' AND hname = '$hname'";
                        $result = mysqli_query($conn, $query);
                        while ($fetch = mysqli_fetch_assoc($result)) {
                            $id = $fetch['id'];  
                    ?>
                        <tr>
                            <td><?php echo $fetch['id'] ?></td>
                            <td><?php echo $fetch['fname'] ?></td>
                            <td><?php echo $fetch['lname'] ?></td>
                            <td><?php echo $fetch['email'] ?></td>
                            <td><?php echo $fetch['date_in'] ?></td>
                            <td><?php echo $fetch['addons'] ?></td>
                            <td><?php echo $fetch['room_no'] ?></td>
                            <td><?php echo $fetch['amenities'] ?></td>
                            <td><?php echo $fetch['price'] ?></td>
                            <td><img src="<?php echo $fetch['image'] ?>"></td>
                            <td><?php echo $fetch['status'] ?></td>
                            <td><?php echo $fetch['res_stat'] ?></td>
                        </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>

    </section>

    <style>
        .content {
            padding-top: 100px;
            padding-left: 10%;
            padding-right: 10%;
            display: flex;
            justify-content: center;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
