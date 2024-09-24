<?php
include 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
}else{
    header('location: ./index.php');
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
            margin: 20px 200px 0px 200px;
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
</head>

<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="../images/logo.png" alt="">
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
            <a  class="nav-link" href="../index.php">Back</a>
        </div>
    </nav>


    <section> 
        <div class="content">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>landlord</th>
                        <th>Boarding House</th>
                        <th>Address</th>
                        <th>Description</th>
                        <th>Images</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <?php  
                            if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'admin'){
                                echo '<th>Actions</th>'; 
                            }else{
                                echo '';
                            }
                        ?>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "select * 
                        from bhapplication 
                        inner join documents on bhapplication.hname = documents.hname
                        inner join description on bhapplication.hname = description.hname";
                        $result = mysqli_query($conn, $query);
                        while ($fetch = mysqli_fetch_assoc($result)) {
                        $id = $fetch['id'];
                        $hname = $fetch['hname'];
                        ?>          
                        <tr>
                            <td><?php echo $fetch['id'] ?></td>
                            <td><?php echo $fetch['owner'] ?></td>
                            <td><?php echo $fetch['hname'] ?></td>
                            <td><?php echo $fetch['haddress'] ?></td>
                            <td><?php echo $fetch['bh_description'] ?></td>
                            <td><img src="../<?php echo $fetch['image'] ?>" width='200px'></td>
                            <td><img src="../<?php echo $fetch['documents'] ?>" width='200px'></td>
                            <td><?php echo $fetch['status'] ?></td>
                                
                            
                            <td>
                                <a href="bhfunction.php?approve=<?php echo $hname;?>"><button class="btn btn-warning">Approve</button></a>
                                <a href="bhfunction.php?reject=<?php echo $hname;?>"><button class="btn btn-danger">Reject</button></a>
                            </td>
                            <?php } ?>
                        </tr>
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