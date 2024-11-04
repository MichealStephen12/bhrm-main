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
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
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
                if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'admin'){
                    echo '<a  class="nav-link" href="reservation.php">View Reservation</a>';
                }
            ?>
            <?php if (!empty($_SESSION['hname'])): ?>
                <a  class="nav-link" href="./index.php">Back</a>
            <?php else: ?>
            <?php endif; ?>
        </div>
        <div class="login">
                <?php
                    if (empty($_SESSION['uname'])) {
                        echo '<a href="login.php">Login</a>';
                        
                    } else {
                        echo '<a href="logout.php">Logout</a>';
                    }
                ?>
            </div>
    </nav>


    <h1> Pending </h1>
    <div class="container">
        <?php 
        if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'admin') {
            $query = "select * 
                        from bhapplication 
                        inner join documents on bhapplication.hname = documents.hname
                        inner join description on bhapplication.hname = description.hname where bhapplication.status = 'PENDING' order by bhapplication.id desc";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)) {
                $hname = $fetch['hname'];
        ?>
        <div class="card">
            <div class="card-footer">
                <img src="../<?php echo $fetch['image']; ?>">
            </div>
            <div class="card-header">
                <h5>Boarding House No: <?php echo $fetch['id']; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Boarding House Information:</strong></p>
                        <p>Name: <?php echo $fetch['hname'] ?></p>
                        <p>Boarding House Address: <?php echo $fetch['haddress'] ?></p>
                        <p>Boarding House Description: <?php echo $fetch['bh_description']; ?></p>
                        <p>Boarding House Status: <?php echo $fetch['status']; ?></p>
                    </div>
                </div>
                <div>
                    <div class="col-md-6">
                        <p><strong>Landlord Information:</strong></p>
                        <p>Name: <?php echo $fetch['landlord']; ?></p>
                        <p>Documents:</p>
                        <img src="../<?php echo $fetch['documents'] ?>" width='200px'>
                    </div>
                </div>
               
                <?php if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'admin'){ ?>
                <div class="button-row">
                    <div class="button-col">
                        <?php if($fetch['status'] == 'Pending'): ?>
                            <a href="bhfunction.php?approve=<?php echo $hname;?>"><button >Approve</button></a>
                            <a href="bhfunction.php?reject=<?php echo $hname;?>"><button class="reject">Reject</button></a> 
                        <?php else: ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php 
            }
        } 
        ?>
    </div>


    <h1> Approved </h1>
    <div class="container">
        <?php 
        if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'admin') {
            $query = "select * 
                        from bhapplication 
                        inner join documents on bhapplication.hname = documents.hname
                        inner join description on bhapplication.hname = description.hname where bhapplication.status = 'Approved' order by bhapplication.id desc";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)) {
                $hname = $fetch['hname'];
        ?>
        <div class="card">
            <div class="card-footer">
                <img src="../<?php echo $fetch['image']; ?>">
            </div>
            <div class="card-header">
                <h5>Boarding House No: <?php echo $fetch['id']; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Boarding House Information:</strong></p>
                        <p>Name: <?php echo $fetch['hname'] ?></p>
                        <p>Boarding House Address: <?php echo $fetch['haddress'] ?></p>
                        <p>Boarding House Description: <?php echo $fetch['bh_description']; ?></p>
                        <p>Boarding House Status: <?php echo $fetch['status']; ?></p>
                    </div>
                </div>
                <div>
                    <div class="col-md-6">
                        <p><strong>Landlord Information:</strong></p>
                        <p>Name: <?php echo $fetch['landlord']; ?></p>
                        <p>Documents:</p>
                        <img src="../<?php echo $fetch['documents'] ?>" width='200px'>
                    </div>
                </div>
               
                <?php if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'admin'){ ?>
                <div class="button-row">
                    <div class="button-col">
                        <?php if($fetch['status'] == 'Approved'): ?>
                            <a href="bhfunction.php?approve=<?php echo $hname;?>"><button disabled>Approve</button></a>
                            <a href="bhfunction.php?reject=<?php echo $hname;?>"><button class="reject" disabled>Reject</button></a>
                        <?php else: ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php 
            }
        } 
        ?>
    </div>


    <h1> Rejected </h1>
    <div class="container">
        <?php 
        if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'admin') {
            $query = "select * 
                        from bhapplication 
                        inner join documents on bhapplication.hname = documents.hname
                        inner join description on bhapplication.hname = description.hname where bhapplication.status = 'Rejected' order by bhapplication.id desc";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)) {
                $hname = $fetch['hname'];
        ?>
        <div class="card">
            <div class="card-footer">
                <img src="../<?php echo $fetch['image']; ?>">
            </div>
            <div class="card-header">
                <h5>Boarding House No: <?php echo $fetch['id']; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Boarding House Information:</strong></p>
                        <p>Name: <?php echo $fetch['hname'] ?></p>
                        <p>Boarding House Address: <?php echo $fetch['haddress'] ?></p>
                        <p>Boarding House Description: <?php echo $fetch['bh_description']; ?></p>
                        <p>Boarding House Status: <?php echo $fetch['status']; ?></p>
                    </div>
                </div>
                <div>
                    <div class="col-md-6">
                        <p><strong>Landlord Information:</strong></p>
                        <p>Name: <?php echo $fetch['landlord']; ?></p>
                        <p>Documents:</p>
                        <img src="../<?php echo $fetch['documents'] ?>" width='200px'>
                    </div>
                </div>
               
                <?php if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'admin'){ ?>
                <div class="button-row">
                    <div class="button-col">
                        <?php if($fetch['status'] == 'Rejected'): ?>
                            <a href="php/function.php?approve=<?php echo $fetch['id'];?>"><button disabled>Approve</button></a>
                            <a href="php/function.php?reject=<?php echo $fetch['id'];?>"><button class="reject" disabled>Reject</button></a> 
                        <?php else: ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php 
            }
        } 
        ?>
    </div>


    <style>

        .container{
            width: auto;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr;
            overflow-y: scroll;
            height: 750px;
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
            width: auto;
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

        
        button:disabled {
            background-color: #ccc; /* Light gray background */
            color: #666; /* Darker gray text */
            border: 1px solid #999; /* Gray border */
            cursor: not-allowed; /* Change cursor to indicate it's not clickable */
            opacity: 0.6; /* Slightly transparent */
        }

        button:hover {
            background-color: #4CAF50;
        }


        .button-row{
            margin: auto;
            grid-column-start: 1;
            grid-column-end: 3;

        }
    </style>
</body>

</html>