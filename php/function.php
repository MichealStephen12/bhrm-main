<?php
require 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
} else {
    header("location: ../index.php");
}

if (isset($_GET['approve'])) {
    $id = $_GET['approve'];

    // Fetch reservation details including the beds column
    $query = "SELECT * FROM reservation WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);

    $roomno = $fetch['room_no'];
    $tenantcount = $fetch['current_tenant'];
    $beds = $fetch['beds']; // This will now be a single integer value (e.g., '2' for 2 beds)

    // Fetch the room's capacity
    $roomQuery = "SELECT capacity FROM rooms WHERE room_no = '$roomno'";
    $roomResult = mysqli_query($conn, $roomQuery);
    $roomData = mysqli_fetch_assoc($roomResult);
    $roomCapacity = $roomData['capacity'];

    // Determine how many beds are occupied
    if (strtolower($beds) === 'whole bed') {
        // If the whole room is reserved, use the room's capacity
        $bedCount = $roomCapacity;
    } else {
        // Otherwise, just use the number of beds directly (as it's now a single number)
        $bedCount = (int)$beds; // Convert beds to an integer in case it's a string
    }

    // Update the reservation status
    $query = "UPDATE reservation 
              SET res_stat = 'Approved', 
                  res_duration = '', 
                  status = 'reserved', 
                  res_reason = 'Process Completed' 
              WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Update the current tenant count based on the number of beds or full room reservation
    $query = "UPDATE rooms 
              SET current_tenant = current_tenant + $bedCount 
              WHERE room_no = '$roomno'";
    $result = mysqli_query($conn, $query);

    // Redirect after the update
    header('Location: ../reservation.php');
}



if (isset($_GET['reject'])) {
    $id = $_GET['reject'];

    // Fetch the reservation details, including the room number and beds booked
    $query = "SELECT * FROM reservation WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);
    $roomno = $fetch['room_no'];
    $beds = $fetch['beds']; // Assuming this contains the number of beds booked

    // If 'Whole bed' is stored for full room booking, use the room capacity, otherwise the number of beds
    if ($beds === 'Whole bed') {
        // Fetch room capacity for whole room booking
        $roomQuery = "SELECT capacity FROM rooms WHERE room_no = '$roomno'";
        $roomResult = mysqli_query($conn, $roomQuery);
        $roomData = mysqli_fetch_assoc($roomResult);
        $bedCount = $roomData['capacity']; // Use the full room capacity
    } else {
        // Subtract the number of beds specified
        $bedCount = (int)$beds; // Convert the string value of beds to an integer
    }

    // Update the reservation status to 'Rejected'
    $query = "UPDATE `reservation` SET `res_stat` = 'Rejected', `res_duration` = '', `status` = 'available', `res_reason` = 'No valid information / No Tenant Came' WHERE id = $id";
    mysqli_query($conn, $query);

    // Subtract the number of beds from the current tenant count
    $query = "UPDATE `rooms` SET current_tenant = current_tenant - $bedCount WHERE room_no = '$roomno'";
    mysqli_query($conn, $query);

    // Redirect back to the reservation page
    header('Location: ../reservation.php');
}



$data = ['id' => '', 'owner' => '', 'hname' => '', 'haddress' => '', 'image' => '', 'price' => '', 'status' => '', 'amenities' => '', 'description' => ''];


if (isset($_GET['edit'])) {
    $house = $_GET['edit'];

    $query = "SELECT * FROM `boardinghouses` WHERE hname = '$house'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $house = $_GET['edit'];
    $landlord = $_POST['landlord'];
    $hname = $_POST['hname'];
    $haddress = $_POST['haddress'];
    $contactno = $_POST['contactno'];

    $file = $_FILES['image'];

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
            if ($fileSize < 1000000) {
                $fileNameNew = $fileName;
                $fileDestination = '../images/' . $fileNameNew;
                if ($fileNameNew > 0) {
                    move_uploaded_file($fileTmpName, $fileDestination);
                }

            } else {
                echo 'your file is too big.';
            }
        }
    } else {
        echo "you cannot upload this type of file";
    }

    $query = "select * from boardinghouses where hname = '$house'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);
    $hname = $fetch['hname'];
    $owner = $fetch['owner'];

    $query = "UPDATE `boardinghouses` SET `owner`='$owner', `hname`='$hname', `haddress`='$haddress', `contact_no`='$contactno', `landlord`='$landlord'  WHERE hname = '$house'";
    mysqli_query($conn, $query);


    $query = "UPDATE `documents` SET `image`= 'images/$fileNameNew' where hname = '$hname'";
    mysqli_query($conn, $query);

    header("location: ../index.php");


if (isset($_GET['delete'])) {
    $hname = $_GET['delete'];

    $query = "select * from boardinghouses where hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);
    $hname = $fetch['hname'];

    $query = "DELETE FROM `boardinghouses` WHERE hname = '$hname'";
    $result = mysqli_query($conn, $query);
    if($result){
        $query = "DELETE FROM `documents` WHERE hname = '$hname'";
        $result = mysqli_query($conn, $query);
    
        $query = "DELETE FROM `description` WHERE hname = '$hname'";
        $result = mysqli_query($conn, $query);

        $query = "UPDATE `users` SET hname = '' WHERE hname = '$hname'";
        $result = mysqli_query($conn, $query);
    }
    
    header("location: ../index.php");
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
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
                        <span style="font-weight: 100; font-size: 17px;">Update Boarding House</span>
                    </div>
                    <div class="col-md-12">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Landlord Name</label>
                                    <input type="text" name="landlord" placeholder="Enter here.." class="form-control" value="<?php echo $data['landlord']; ?>" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>House Name</label>
                                    <input type="text" name="hname" placeholder="Enter here.." class="form-control" value="<?php echo $data['hname']; ?>" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>House Address</label>
                                    <input type="text" name="haddress" placeholder="Enter here.." class="form-control" value="<?php echo $data['haddress']; ?>" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Contact Number:</label>
                                    <input type="text" name="contactno" placeholder="Enter here.." class="form-control" value="<?php echo $data['contact_no']; ?>" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Image</label>
                                    <input type="file" name="image" placeholder="Enter here.." class="form-control" required>
                                </div>

                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <button type="submit" name="update" class="btn btn-warning">Submit</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>

</html>
