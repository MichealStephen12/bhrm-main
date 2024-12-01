<?php
require 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'landlord') {
    $uname = $_SESSION['uname'];
    $query = "select * from users where uname = '$uname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);
    $fname = $fetch['fname'];

} else {
    header("location: ../index.php");
}

if (isset($_POST['submit'])) {
    $owner = $_SESSION['uname'];
    $landlord = $_POST['landlord'];
    $hname = $_POST['name'];
    $haddress = $_POST['address'];
    $contactno = $_POST['contactno'];
    $description = $_POST['description'];

    $_FILES['image'];

    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileactualext = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileactualext, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000000) {
                $fileNameNew = $fileName;
                $fileDestination = '../images/' . $fileNameNew;
                if ($fileNameNew > 0) {
                    move_uploaded_file($fileTmpName, $fileDestination);
                }
            } else {
                echo "your file is too big.";
            }
        }
    } else {
        echo "you cannot upload this type of file";
    }

    $_FILES['image2'];

    $fileName = $_FILES['image2']['name'];
    $fileTmpName = $_FILES['image2']['tmp_name'];
    $fileSize = $_FILES['image2']['size'];
    $fileError = $_FILES['image2']['error'];
    $fileType = $_FILES['image2']['type'];

    $fileExt = explode('.', $fileName);
    $fileactualext = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileactualext, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000000000) {
                $fileNameNew2 = $fileName;
                $fileDestination = '../images/' . $fileNameNew2;
                if ($fileNameNew2 > 0) {
                    move_uploaded_file($fileTmpName, $fileDestination);
                }
            } else {
                echo "your file is too big.";
            }
        }
    } else {
        echo "you cannot upload this type of file";
    }

    $query = "INSERT INTO `bhapplication` (`id`, `owner`, `hname`, `haddress`, `contact_no`, `status`, `landlord`) VALUES ('', '$owner','$hname','$haddress', '$contactno', 'Pending', '$landlord')";
    mysqli_query($conn, $query);
    $query = "INSERT INTO `documents` (`id`, `documents`, `image`, `hname`) VALUES ('','images/$fileNameNew2', 'images/$fileNameNew', '$hname')";
    mysqli_query($conn, $query);
    $query = "INSERT INTO `description` (`id`, `bh_description`, `hname`) VALUES ('','$description', '$hname')";
    mysqli_query($conn, $query);
    echo "thank you for providing information, this will be proccessed";

}


if (isset($_GET['approve'])) {
    $hname = $_GET['approve'];
    
    // Fetch the data from the bhapplication table
    $query = "select * from bhapplication where hname = '$hname'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $fetch = mysqli_fetch_assoc($result);

        $owner = $fetch['owner'];
        $landlord = $fetch['landlord'];
        $hname = $fetch['hname'];
        $address = $fetch['haddress'];
        $contactno = $fetch['contact_no'];
        
        // Insert the data into the boardinghouses table
        $query_insert = "INSERT INTO boardinghouses (`id`, `owner`, `hname`, `haddress`, `contact_no`, `landlord`) VALUES ('', '$owner', '$hname', '$address', '$contactno', '$landlord')";
        
        if (mysqli_query($conn, $query_insert)) {
            // Update the status in the bhapplication table
            $query_update = "UPDATE bhapplication SET Status = 'Approved' WHERE hname = '$hname'";
            mysqli_query($conn, $query_update);

            $query_insert = "UPDATE documents SET hname = '$hname', owner = '$owner' where hname = '$hname'";
            mysqli_query($conn, $query_insert);

            $query_insert = "UPDATE description SET hname = '$hname', owner = '$owner' where hname = '$hname'";
            mysqli_query($conn, $query_insert);

            $query_insert = "UPDATE users SET hname = '$hname' where uname = '$owner'";
            mysqli_query($conn, $query_insert);
            
            header('Location: ../index.php');
        } else {
            echo "Error: " . $query_insert . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

if (isset($_GET['reject'])) {
    $hname = $_GET['reject'];
    
    // Update the status in the bhapplication table
    $query_update = "UPDATE bhapplication SET Status = 'Rejected' WHERE hname = '$hname'";
    
    if (mysqli_query($conn, $query_update)) {


        $query_insert = "UPDATE users SET hname = '' where uname = '$landlord'";
        mysqli_query($conn, $query_insert);

        $query_update = "UPDATE documents SET hname = '' where uname = '$landlord'";
        mysqli_query($conn, $query_update);

        $query_update = "UPDATE description SET hname = '' where uname = '$landlord'";
        mysqli_query($conn, $query_update);
        
        header('Location: ../index.php');
    } else {
        echo "Error: " . $query_update . "<br>" . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Boarding House</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f7f7f7;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        nav {
            background-color: #343a40;
            padding: 5px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .navbar-brand img {
            width: 80px;
            height: 80px;
        }

        nav .nav-links {
            display: flex;
            gap: 20px;
        }

        nav .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        nav .login a {
            background-color: #ffc107;
            padding: 10px 15px;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        nav .login a:hover {
            background-color: #d68918;
        }

        .section0 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1200px;
            margin: 40px auto;
            gap: 30px;
        }

        .section1, .section2 {
            background-color: #b5afaf;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .thank-you-message {
            background-color: #eafaf1;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            color: black;
            margin-bottom: 20px;
        }

        .thank-you-message h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .thank-you-message p {
            font-size: 16px;
            margin: 5px 0;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        .form-group button {
            padding: 12px 18px;
            background-color: #ffc107;
            color: white;
            border: none;
            font-weight: bold;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #d68918;
        }

        .form-group a {
            text-align: center;
            color: #333;
            font-size: 16px;
            text-decoration: none;
        }

        .form-group a:hover {
            text-decoration: underline;
        }

        .logo {
            display: block;
            margin: 0 auto 30px;
            width: 120px;
            height: 120px;
        }

        .title {
            font-size: 28px;
            font-weight: 500;
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        @media (max-width: 768px) {
            .section0 {
                grid-template-columns: 1fr;
                margin: 20px;
            }

            nav .nav-links {
                flex-direction: column;
                align-items: center;
            }

            .form-container {
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <nav>
        <a class="navbar-brand" href="#">
            <img src="../images/logo.png" alt="Logo">
        </a>
        <div class="nav-links">
            <a href="php/bhfunction.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="contact.php">Contact</a>
            <a href="/bhrm-main/bhapplication.php">My Applications</a>
            </div>
                <div class="login">
            <?php
                if (!empty($_SESSION['uname'])) {
                    echo '<a href="php/logout.php" class="logout">Logout</a>';
                } else {
                    echo '<a href="php/login.php">Login</a>';
                }
            ?>

        </div>
    </nav>

    <div class="section0">
        <div class="section1">
            <div class="thank-you-message">
                <h2>Thank You for Registering as a Landlord!</h2>
                <p>Dear <?php echo $fetch['fname']; ?>,</p>
                <p>We appreciate your interest in becoming a landlord with us. Your application is under review, and we will notify you via email once it's processed.</p>
                <p>At [Website/Platform Name], we are committed to providing a platform that benefits both landlords and tenants. If you have any questions in the meantime, feel free to reach out to us.</p>
                <p>Thank you for choosing us to showcase your property. We look forward to working with you!</p>
                <p>Best regards,<br>The [Website/Platform Name] Team</p>
            </div>
        </div>

        <div class="section2">
            <img src="../images/logo.png" class="logo" alt="Logo">
            <div class="title">Add Boarding House</div>
            <form method="post" enctype="multipart/form-data" class="form-container">
                <div class="form-group">
                    <label for="landlord">Landlord Name</label>
                    <input type="text" id="landlord" name="landlord" placeholder="Enter here.." required>
                </div>
                <div class="form-group">
                    <label for="name">House Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter here.." required>
                </div>
                <div class="form-group">
                    <label for="address">House Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter here.." required>
                </div>
                <div class="form-group">
                    <label for="contactno">Contact Number</label>
                    <input type="text" id="contactno" name="contactno" placeholder="Enter here.." required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="Enter here.." required>
                </div>
                <div class="form-group">
                    <label for="image">Provide Image of Boarding House</label>
                    <input type="file" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="image2">Provide Required Documents for BH Verification</label>
                    <input type="file" id="image2" name="image2" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit">Submit</button>
                </div>
                <div class="form-group">
                    <?php 
                        if ($_SESSION['role'] != 'landlord'){
                            echo '<a href="../index.php">Back</a>';
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
