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
            height: 70px;
            margin: 0 200px;
            background-color: white;
            border-radius: 5px;
            border: inset black 1px;
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

        .section0{
            margin: 40px 200px 90px 200px;
            display: grid;
            grid-template-columns: 600px 600px;
            justify-content: center;
            box-shadow: 0px 30px 50px rgba(0, 0, 0, 0.1);
        }

        .section1 {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            
            display: flex;
            align-items: center;
        }

        .thank-you-message {
            background-color: #f7f7f7;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            max-width: 600px;
            margin: 30px auto;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .thank-you-message h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4CAF50;
        }

        .thank-you-message p {
            font-size: 16px;
            margin: 10px 0;
        }

        .thank-you-message p:last-child {
            font-weight: bold;
            margin-top: 20px;
        }

        .section2 {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 30px 40px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            height: 100px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            padding: 10px 15px;
            background-color: #007bff;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #ec971f;
        }

        .form-group a {
            text-align: center;
            color: #333;
            text-decoration: none;
            margin-top: 10px;
            display: block;
        }

        .form-group a:hover {
            text-decoration: underline;
        }

        .button{
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
        }

    </style>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="../images/logo.png" alt="Logo" width="80" height="80">
        </a>
        <div class="nav-links">
            <a class="nav-link" href="about.php">About Us</a>
            <a class="nav-link" href="contact.php">Contact</a>
        </div>
        <div class="login">
            <?php
                if (!empty($_SESSION['uname'])) {
                    echo '<a class="button" href="logout.php">Logout</a>';
                } else {
                    echo '<a class="button" href="login.php">Login</a>';
                }
            ?>
        </div>
    </nav>


    <div class="section0">
        <div class="section1">
            <div class="thank-you-message">
                <h2>Thank You for Registering as a Landlord!</h2>
                <p>Dear <?php echo $fetch['fname']?>,</p>
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
                    <label for="name">Landlord Name</label>
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
                    <label for="address">Contact Number</label>
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
                    <label for="image2">Provide Required Documents for BH verification</label>
                    <input type="file" id="image2" name="image2" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit">Submit</button>
                </div>
                <div class="form-group">
                    <?php 
                        if ($_SESSION['role'] == 'landlord'){
                            echo '';
                        }else{
                            echo '<a href="../index.php">Back</a>';
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
    

</body>
</html>
