<?php
require 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
} else {
    header("location: ../index.php");
}

if (isset($_POST['submit'])) {
    $roomno = $_POST['roomno'];
    $amenities = $_POST['amenities'];
    $price = $_POST['price'];
    $status = $_POST['status'];

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
            if ($fileSize < 1000000) {
                $fileNameNew = $fileName;
                $fileDestination = '../images/' . $fileNameNew;
                if ($fileNameNew > 0) {
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("location: ../boardinghouse.php");
                }
            } else {
                echo "your file is too big.";
            }
        }
    } else {
        echo "you cannot upload this type of file";
    }

    $hname = $_SESSION['hname'];
    $query = "INSERT INTO `rooms`(`id`, `room-no`, `amenities`, `price`, `image`, `status`, `hname`) VALUES ('','$roomno','$amenities','$price','images/$fileNameNew', '$status', '$hname')";
    mysqli_query($conn, $query);

    header("location: ../boardinghouse.php");
}

$data = ['id' => '', 'room-no' => '', 'amenities' => '', 'price' => '', 'image' => '', 'status'=>''];

if(isset($_GET['rupdate'])){
    $id = $_GET['rupdate'];

    $query = "SELECT * FROM `rooms` WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])){
    $id = $_GET['rupdate'];
    $roomno = $_POST['roomno'];
    $amenities = $_POST['amenities'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    $file = $_FILES['image'];
    
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileType = $_FILES['image']['type'];

    $fileExt = explode('.', $fileName);
    $fileactualext = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if(in_array($fileactualext, $allowed)){
        if($fileError === 0){
            if($fileSize < 1000000){
                $fileNameNew = $fileName;
                $fileDestination = '../images/'.$fileNameNew;
                if($fileNameNew > 0){
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("location: ../boardinghouse.php");
                }
                
            }else{
                echo 'your file is too big.';
            }
        }
    }else{
        echo "you cannot upload this type of file";
    }

    $query = "UPDATE `rooms` SET `id`= $id,`room-no`='$roomno',`amenities`='$amenities', `price`='$price', `image`='images/$fileNameNew', `status`='$status' WHERE id = $id";
    mysqli_query($conn, $query);

    header("location: ../boardinghouse.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADDROOM</title>
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
                        <span style="font-weight: 100; font-size: 17px;">Add Rooms</span>
                    </div>
                    <div class="col-md-12">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Room No:</label>
                                    <input type="text" name="roomno" value="<?php echo $data['room-no']; ?>"  placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Amenities:</label>
                                    <input type="text" name="amenities" value="<?php echo $data['amenities']; ?>"  placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Price:</label>
                                    <input type="text" name="price" value="<?php echo $data['price']; ?>"  placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Image:</label>
                                    <input type="file" name="image" placeholder="Enter here.." class="form-control" >
                                </div>
                                <?php if($data['id'] != '') :  ?>
                                <div class="col-md-12" style="padding: 10px 20px 10px 20px;">
                                    <img src="../<?php echo $data['image'];?>" value="<?php echo $data['image'];?>" height="100" width="100" alt="">
                                </div>
                                <?php endif; ?>
                                <div class="col-md-12" style="text-align: left; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <label>Status:</label>
                                    <input type="text" name="status" value="<?php echo $data['status']; ?>" placeholder="Enter here.." class="form-control" required>
                                </div>
                                <div class="col-md-12" style="text-align: center; font-size: 14px; font-weight: 200; padding: 10px 20px 10px 20px;">
                                    <?php if($data['id'] != '') :  ?>
                                    <input type="submit" name="update" value="Update" class="btn btn-warning">
                                    <?php else: ?>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-warning">
                                    <?php endif; ?>
                                    <a href="../boardinghouse.php" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
