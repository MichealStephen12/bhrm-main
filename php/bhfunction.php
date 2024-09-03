<?php
require 'connection.php';

if (isset($_POST['submit'])) {
    $landlord = $_POST['landlord'];
    $hname = $_POST['name'];
    $haddress = $_POST['address'];
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

    $query = "INSERT INTO `bhapplication` (`id`, `owner`, `hname`, `haddress`, `Status`) VALUES ('','$landlord','$hname','$haddress', 'PENDING')";
    mysqli_query($conn, $query);
    $query = "INSERT INTO `documents` (`id`, `documents`, `image`, `hname`) VALUES ('','images/$fileNameNew2', 'images/$fileNameNew', '$hname')";
    mysqli_query($conn, $query);
    $query = "INSERT INTO `description` (`id`, `bh_description`, `hname`) VALUES ('','$description', '$hname')";
    mysqli_query($conn, $query);
    echo "thank you for providing information, this will be proccessed";

}


if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    
    // Fetch the data from the bhapplication table
    $query = "select * from bhapplication where id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $fetch = mysqli_fetch_assoc($result);
        
        $landlord = $fetch['owner'];
        $name = $fetch['hname'];
        $address = $fetch['haddress'];
        
        // Insert the data into the boardinghouses table
        $query_insert = "INSERT INTO boardinghouses (`id`, `owner`, `hname`, `haddress`) VALUES ('', '$landlord', '$name', '$address')";
        
        if (mysqli_query($conn, $query_insert)) {
            // Update the status in the bhapplication table
            $query_update = "UPDATE bhapplication SET Status = 'approved' WHERE id = $id";
            mysqli_query($conn, $query_update);

            $query_update = "Delete From bhapplication WHERE id = $id";
            mysqli_query($conn, $query_update);
            
            header('Location: ../index.php');
        } else {
            echo "Error: " . $query_insert . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    
    // Update the status in the bhapplication table
    $query_update = "UPDATE bhapplication SET Status = 'rejected' WHERE id = $id";
    
    if (mysqli_query($conn, $query_update)) {

        $query_update = "Delete From bhapplication WHERE id = $id";
        mysqli_query($conn, $query_update);

        $query_update = "Delete From documents WHERE id = $id";
        mysqli_query($conn, $query_update);

        $query_update = "Delete From description WHERE id = $id";
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
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6; /* Background color */
        }
    </style>

</head>
<body>
    <div class="container-fluid">
        <div class="row" style="padding-top: 5%;">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center; background-color: #a9a9a9; border-radius: 20px; padding: 10px;">
                <div class="row">
                    <div class="col-md-12" style="padding-bottom: 15px;">
                        <img src="../images/logo.png" height="100px">
                    </div>
                    <div class="col-md-12">
                        <span style="font-weight: 100; font-size: 17px;">Add Boarding House</span>
                    </div>
                    <div class="col-md-12">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Landlord</label>
                                    <input type="text" name="landlord" placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>House Name</label>
                                    <input type="text" name="name" placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>House Address</label>
                                    <input type="text" name="address" placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Description</label>
                                    <input type="text" name="description" placeholder="Enter here.." class="form-control" required>
                                </div>

                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Provide Image of Boarding House</label>
                                    <input type="file" name="image" placeholder="Enter here.." class="form-control" required>
                                </div>

                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Provide Required Documents for the BH verification</label>
                                    <input type="file" name="image2" placeholder="Enter here.." class="form-control" required>
                                </div>
                                
                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <button type="submit" name="submit" class="btn btn-warning">Submit</button>
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 13px; font-weight: 100;">
                                    <a href="../index.php" style="text-decoration: none; color: black;">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>