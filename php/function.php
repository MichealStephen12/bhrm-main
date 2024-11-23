<?php
require 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
} else {
    header("location: ../index.php");
}

if (isset($_GET['approve'])) {
    $hname = $_SESSION['hname'];
    $id = $_GET['approve'];

    // Fetch reservation details
    $query = "SELECT * FROM reservation WHERE id = $id and hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);

    $roomno = $fetch['room_no'];
    $bedno = $fetch['bed_no']; // Contains either "1" or "2 Bed(s)" for example.

    // Check if bed_no contains "Bed(s)" (indicating multiple beds)
    if (strpos($bedno, 'Bed(s)') !== false) {
        // Extract the number of beds
        preg_match('/\d+/', $bedno, $matches);
        $total_beds = intval($matches[0]);

        // Fetch available beds for the room
        $bedQuery = "SELECT * FROM beds WHERE roomno = '$roomno' AND bed_stat = 'Available' AND hname = '$hname' LIMIT $total_beds";
        $bedResult = mysqli_query($conn, $bedQuery);

        // Update the status of each selected bed
        $updatedBeds = 0;
        while ($bed = mysqli_fetch_assoc($bedResult)) {
            $bed_id = $bed['id']; // Assuming there's an ID column for beds
            $updateBedQuery = "UPDATE beds SET bed_stat = 'Reserved' WHERE id = $bed_id AND hname = '$hname'";
            mysqli_query($conn, $updateBedQuery);
            $updatedBeds++;
        }

        // Verify that all requested beds were updated
        if ($updatedBeds == $total_beds) {
            // Update the reservation status
            $updateReservationQuery = "UPDATE reservation 
                                        SET res_stat = 'Approved', 
                                            bed_stat = 'Reserved',
                                            res_reason = 'Process Completed' 
                                        WHERE id = $id AND hname = '$hname'";
            mysqli_query($conn, $updateReservationQuery);
        } else {
            // Handle case where not enough beds are available
            // Example: Redirect back with an error message
            header('Location: ../reservation.php?error=Not enough beds available.');
            exit;
        }
    } else {
        // Handle single bed approval
        $updateBedQuery = "UPDATE beds 
                           SET bed_stat = 'Reserved' 
                           WHERE bed_no = '$bedno' AND roomno = '$roomno' AND hname = '$hname'";
        mysqli_query($conn, $updateBedQuery);

        // Update the reservation status
        $updateReservationQuery = "UPDATE reservation 
                                    SET res_stat = 'Approved', 
                                        bed_stat = 'Reserved',
                                        res_reason = 'Process Completed' 
                                    WHERE id = $id AND hname = '$hname'";
        mysqli_query($conn, $updateReservationQuery);
    }

    // Redirect after the update
    header('Location: ../managereservation.php');
    exit;
}

if (isset($_GET['reject'])) {
    $hname = $_SESSION['hname'];
    $id = $_GET['reject'];

    // Fetch the reservation details
    $query = "SELECT * FROM reservation WHERE id = $id AND hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);

    $roomno = $fetch['room_no'];
    $bedno = $fetch['bed_no']; // e.g., "2 Bed(s)" or single bed number

    // Handle multiple beds or single bed rejection
    if (strpos($bedno, 'Bed(s)') !== false) {
        // Extract the total number of beds
        preg_match('/\d+/', $bedno, $matches);
        $total_beds = intval($matches[0]);
    } else {
        $total_beds = 1; // Single bed case
    }

    // Update the reservation status to 'Rejected'
    $updateReservationQuery = "UPDATE reservation 
                               SET res_stat = 'Rejected', 
                                   res_reason = 'No valid information / No Tenant Came' 
                               WHERE id = $id AND hname = '$hname'";
    mysqli_query($conn, $updateReservationQuery);

    // Redirect back to the reservation page
    header('Location: ../managereservation.php?message=Reservation rejected successfully.');
    exit;
}




if (isset($_GET['confirm'])) {
    $hname = $_SESSION['hname'];
    $id = $_GET['confirm'];

    // Fetch reservation details
    $query = "SELECT * FROM reservation WHERE id = $id AND hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);

    $roomno = $fetch['room_no'];
    $bedno = $fetch['bed_no']; // Can contain "1 Bed(s)" or a single number
    $bedprice = $fetch['bed_price'];
    $uname = $fetch['email'];
    $fname = $fetch['fname'];
    $lname = $fetch['lname'];
    $gender = $fetch['gender'];
    $date_in = date('Y-m-d'); // Current date as the check-in date

    // Handle multiple beds or a single bed
    if (strpos($bedno, 'Bed(s)') !== false) {
        // Extract the number of beds
        preg_match('/\d+/', $bedno, $matches);
        $total_beds = intval($matches[0]);

        // Fetch available beds for the room
        $bedQuery = "SELECT * FROM beds WHERE roomno = '$roomno' AND bed_stat = 'Reserved' AND hname = '$hname' LIMIT $total_beds";
        $bedResult = mysqli_query($conn, $bedQuery);

        // Update the status of each bed
        $updatedBeds = 0;
        while ($bed = mysqli_fetch_assoc($bedResult)) {
            $bed_id = $bed['id'];
            $updateBedQuery = "UPDATE beds SET bed_stat = 'Occupied' WHERE id = $bed_id AND hname = '$hname'";
            mysqli_query($conn, $updateBedQuery);

            $updatedBeds++;
        }

        // Verify that all requested beds were updated
        if ($updatedBeds == $total_beds) {
            // Insert a single payment record for the whole reservation (not per bed)
            $insertPaymentQuery = "INSERT INTO `payments` (`id`, `email`, `room_no`, `bed_no`, `bed_price`, `pay_stat`, `hname`) 
                                   VALUES ('', '$uname', '$roomno', '$bedno', '$bedprice', 'Not Fully Paid', '$hname')";
            mysqli_query($conn, $insertPaymentQuery);

            // Insert a single report record for the reservation as a whole
            $insertReportQuery = "INSERT INTO `reports` (`id`, `fname`, `lname`, `gender`, `email`, `pay_date`, `date_in`, `date_out`, `room_no`, `bed_no`, `hname`) 
                                  VALUES ('', '$fname', '$lname', '$gender', '$uname', '', '$date_in', NULL, '$roomno', '$bedno', '$hname')";
            mysqli_query($conn, $insertReportQuery);

            // Update the reservation status
            $updateReservationQuery = "UPDATE reservation 
                                        SET res_stat = 'Confirmed', 
                                            res_duration = '', 
                                            res_reason = 'Tenant Arrived', 
                                            bed_stat = 'Occupied' 
                                        WHERE id = $id AND hname = '$hname'";
            mysqli_query($conn, $updateReservationQuery);

            // Increment the tenant count in the room
            $updateRoomQuery = "UPDATE rooms 
                                SET current_tenant = current_tenant + $total_beds 
                                WHERE room_no = '$roomno' AND hname = '$hname'";
            mysqli_query($conn, $updateRoomQuery);
        } else {
            // Handle case where not enough beds are reserved
            header('Location: ../managereservation.php?error=Not enough reserved beds for confirmation.');
            exit;
        }
    } else {
        // Handle single bed confirmation
        $updateBedQuery = "UPDATE beds 
                           SET bed_stat = 'Occupied' 
                           WHERE bed_no = '$bedno' AND roomno = '$roomno' AND hname = '$hname'";
        mysqli_query($conn, $updateBedQuery);

        // Insert payment record for the single bed
        $insertPaymentQuery = "INSERT INTO `payments` (`id`, `email`, `room_no`, `bed_no`, `bed_price`, `pay_stat`, `pay_date`, `hname`) 
                               VALUES ('', '$uname', '$roomno', '$bedno', '$bedprice', 'Not Fully Paid', '', '$hname')";
        mysqli_query($conn, $insertPaymentQuery);

        // Insert report record for the single bed
        $insertReportQuery = "INSERT INTO `reports` (`id`, `fname`, `lname`, `gender`, `email`, `pay_date`, `date_in`, `date_out`, `room_no`, `bed_no`, `hname`) 
                              VALUES ('', '$fname', '$lname', '$gender', '$uname', '', '$date_in', NULL, '$roomno', '$bedno', '$hname')";
        mysqli_query($conn, $insertReportQuery);

        // Update the reservation status
        $updateReservationQuery = "UPDATE reservation 
                                    SET res_stat = 'Confirmed', 
                                        res_reason = 'Tenant Arrived', 
                                        res_duration = '', 
                                        bed_stat = 'Occupied' 
                                    WHERE id = $id AND hname = '$hname'";
        mysqli_query($conn, $updateReservationQuery);

        // Increment the tenant count in the room
        $updateRoomQuery = "UPDATE rooms 
                            SET current_tenant = current_tenant + 1 
                            WHERE room_no = '$roomno' AND hname = '$hname'";
        mysqli_query($conn, $updateRoomQuery);
    }

    // Redirect after the update
    header('Location: ../managereservation.php');
    exit;
}





if (isset($_GET['cancel'])) {
    $hname = $_SESSION['hname'];
    $id = $_GET['cancel'];

    // Fetch reservation details
    $query = "SELECT * FROM reservation WHERE id = $id AND hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);

    $roomno = $fetch['room_no'];
    $bedno = $fetch['bed_no']; // Can contain multiple beds, e.g. "2 Bed(s)" or a single number
    $total_beds = 0;

    // Handle multiple beds or a single bed cancellation
    if (strpos($bedno, 'Bed(s)') !== false) {
        // Extract the total number of beds
        preg_match('/\d+/', $bedno, $matches);
        $total_beds = intval($matches[0]);
    } else {
        $total_beds = 1; // Single bed case
    }

    // Check that the reservation was confirmed (beds should be 'Reserved')
    $bedQuery = "SELECT * FROM beds WHERE roomno = '$roomno' AND bed_stat = 'Reserved' AND hname = '$hname' LIMIT $total_beds";
    $bedResult = mysqli_query($conn, $bedQuery);
    $reservedBeds = mysqli_num_rows($bedResult);

    // If the reserved beds count does not match the requested beds, something went wrong
    if ($reservedBeds != $total_beds) {
        header('Location: ../managereservation.php?error=Mismatch%20in%20reserved%20beds%20for%20cancellation.');
        exit;
    }

    // Update the reservation status to 'Cancelled'
    $updateReservationQuery = "UPDATE reservation 
                               SET res_stat = 'Cancelled', 
                                   bed_stat = 'Available',
                                   res_reason = 'Reservation Cancelled' 
                               WHERE id = $id AND hname = '$hname'";
    mysqli_query($conn, $updateReservationQuery);

    // Update the bed statuses to 'Available'
    while ($bed = mysqli_fetch_assoc($bedResult)) {
        $bed_id = $bed['id']; // Assuming there's an ID column for beds
        $updateBedQuery = "UPDATE beds 
                           SET bed_stat = 'Available' 
                           WHERE id = $bed_id AND hname = '$hname'";
        mysqli_query($conn, $updateBedQuery);
    }

    // Redirect after the update
    header('Location: ../managereservation.php?message=Reservation cancelled successfully.');
    exit;
}



if (isset($_GET['end'])) {
    $hname = $_SESSION['hname'];
    $id = $_GET['end'];

    // Fetch reservation details
    $query = "SELECT * FROM reservation WHERE id = $id AND hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);

    $roomno = $fetch['room_no'];
    $bedno = $fetch['bed_no'];
    $email = $fetch['email'];

    // Fetch the most recent payment for this reservation
    $paymentQuery = "SELECT * FROM payments 
                     WHERE email = '$email' AND room_no = '$roomno' AND hname = '$hname' 
                     ORDER BY id DESC LIMIT 1"; // Fetch the latest payment record
    $paymentResult = mysqli_query($conn, $paymentQuery);
    $paymentData = mysqli_fetch_assoc($paymentResult);

    $payment = $paymentData['payment']; // Get the final payment amount
    $pay_date = $paymentData['pay_date']; // Get the payment date
    $date_out = date('Y-m-d'); // Use the current date for the end of reservation

    // Handle multiple beds or a single bed
    if (strpos($bedno, 'Bed(s)') !== false) {
        // Extract the number of beds
        preg_match('/\d+/', $bedno, $matches);
        $total_beds = intval($matches[0]);

        // Fetch occupied beds for the room
        $bedQuery = "SELECT * FROM beds WHERE roomno = '$roomno' AND bed_stat = 'Occupied' AND hname = '$hname' LIMIT $total_beds";
        $bedResult = mysqli_query($conn, $bedQuery);

        $updatedBeds = 0;
        while ($bed = mysqli_fetch_assoc($bedResult)) {
            $bed_id = $bed['id'];
            $updateBedQuery = "UPDATE beds SET bed_stat = 'Available' WHERE id = $bed_id AND hname = '$hname'";
            mysqli_query($conn, $updateBedQuery);
            $updatedBeds++;
        }

        if ($updatedBeds == $total_beds) {
            // Update reservation status
            $updateReservationQuery = "UPDATE reservation 
                                        SET res_stat = 'Ended', 
                                            res_reason = 'Reservation Ended', 
                                            bed_stat = 'Available' 
                                        WHERE id = $id AND hname = '$hname'";
            mysqli_query($conn, $updateReservationQuery);

            // Decrement tenant count
            $updateRoomQuery = "UPDATE rooms 
                                SET current_tenant = current_tenant - $total_beds 
                                WHERE room_no = '$roomno' AND hname = '$hname'";
            mysqli_query($conn, $updateRoomQuery);
        } else {
            header('Location: ../managereservation.php?error=Not enough occupied beds to end the reservation.');
            exit;
        }
    } else {
        // Handle single bed
        $updateBedQuery = "UPDATE beds 
                           SET bed_stat = 'Available' 
                           WHERE bed_no = '$bedno' AND roomno = '$roomno' AND hname = '$hname'";
        mysqli_query($conn, $updateBedQuery);

        $updateReservationQuery = "UPDATE reservation 
                                    SET res_stat = 'Ended', 
                                        res_reason = 'Reservation Ended', 
                                        bed_stat = 'Available' 
                                    WHERE id = $id AND hname = '$hname'";
        mysqli_query($conn, $updateReservationQuery);

        $updateRoomQuery = "UPDATE rooms 
                            SET current_tenant = current_tenant - 1 
                            WHERE room_no = '$roomno' AND hname = '$hname'";
        mysqli_query($conn, $updateRoomQuery);
    }

    // Fetch the corresponding report ID using the email, room_no, and hname
    $reportQuery = "SELECT * FROM reports 
                    WHERE email = '$email' AND room_no = '$roomno' AND hname = '$hname' 
                    ORDER BY id DESC LIMIT 1"; // Get the latest report
    $reportResult = mysqli_query($conn, $reportQuery);
    $reportData = mysqli_fetch_assoc($reportResult);
    $report_id = $reportData['id']; // Get the ID of the latest report

    // Update the report using the report ID
    $updateReportQuery = "UPDATE reports 
                          SET payment = '$payment', 
                              pay_date = '$pay_date', 
                              date_out = '$date_out' 
                          WHERE id = $report_id AND hname = '$hname'";
    mysqli_query($conn, $updateReportQuery);

    // Delete the processed payment record
    $deletePaymentQuery = "DELETE FROM payments 
                           WHERE email = '$email' AND room_no = '$roomno' AND hname = '$hname'";
    mysqli_query($conn, $deletePaymentQuery);

    // Redirect after processing
    header('Location: ../managereservation.php');
    exit;
}








$data = ['id' => '', 'owner' => '', 'hname' => '', 'haddress' => '', 'image' => '', 'price' => '', 'status' => '', 'amenities' => '', 'description' => ''];


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $query = "SELECT * FROM `boardinghouses` WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $hname = $data['hname'];
    $owner = $data['owner'];
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
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

    $query = "UPDATE `boardinghouses` SET `owner`='$owner', `hname`='$hname', `haddress`='$haddress', `contact_no`='$contactno', `landlord`='$landlord' WHERE owner = '$owner'";
    $result = mysqli_query($conn, $query);
    if($result){
        $query = "UPDATE `documents` SET `hname`='$hname', `image`= 'images/$fileNameNew' where owner = '$owner'";
        mysqli_query($conn, $query);
    }

    $query = "UPDATE `users` SET `hname`='$hname' WHERE uname = '$owner'";
    mysqli_query($conn, $query);


 

    header("location: ../index.php");
}


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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $data['hname']; ?></title>
    <link rel="icon" type="image/x-icon" href="logo.png">
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #e6e6e6; /* Background color */
        }
    </style>

</head>
        <?php ?>
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
