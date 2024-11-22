<?php
require 'connection.php';

// Ensure the session is active and the user is authenticated
if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
} else {
    header("location: ../index.php");
}

// Handle room addition
if (isset($_POST['submit'])) {
    $roomno = $_POST['roomno'];
    $roomtype = $_POST['roomtype'];
    $capacity = $_POST['capacity'];
    
    // Get the selected amenities as an array
    $amenities = isset($_POST['amenities']) ? implode(', ', $_POST['amenities']) : '';
    
    $tenanttype = $_POST['tenanttype'];
    $roomfloor = $_POST['roomfloor'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Handle image upload
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
                $fileNameNew = uniqid('', true) . '.' . $fileactualext;
                $fileDestination = '../images/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
            } else {
                echo "Your file is too big.";
            }
        }
    } else {
        echo "You cannot upload this type of file.";
    }

    // Get the house name from the session
    $hname = $_SESSION['hname'];

    // Insert the room data into the database
    $query = "INSERT INTO `rooms`(`id`, `room_no`, `capacity`, `amenities`, `tenant_type`, `room_floor`, `price`, `image`, `status`, `hname`) VALUES 
                ('', '$roomno', '$capacity', '$amenities', '$tenanttype', '$roomfloor', '$price', 'images/$fileNameNew', '$status', '$hname')";

    mysqli_query($conn, $query);

    header("location: ../manageroom.php");
}

// Initialize data array for room details
$data = ['id' => '', 'room_no' => '', 'room_type' => '', 'capacity' => '', 'amenities' => '', 'price' => '', 'image' => '', 'status'=>''];
$amenitiesSelected = []; // Default to an empty array

// Handle room update
if (isset($_GET['rupdate'])) {
    $id = $_GET['rupdate'];

    $query = "SELECT * FROM `rooms` WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    // Extract amenities as an array
    $amenitiesSelected = isset($data['amenities']) ? explode(', ', $data['amenities']) : [];
}

// Handle room deletion
if (isset($_GET['rdelete'])) {
    $id = $_GET['rdelete'];
    $query = "DELETE FROM rooms WHERE id = $id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        header('Location: ../boardinghouse.php');
    }
}

// Handle room update form submission
if (isset($_POST['update'])) {
    $id = $_GET['rupdate'];
    $roomno = $_POST['roomno'];
    $roomtype = $_POST['roomtype'];
    $capacity = $_POST['capacity'];
    
    // Convert selected amenities to a string
    $amenities = isset($_POST['amenities']) ? implode(', ', $_POST['amenities']) : '';
    
    $tenanttype = $_POST['tenanttype'];
    $roomfloor = $_POST['roomfloor'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Handle image upload
    $fileNameNew = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
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
                    $fileNameNew = uniqid('', true) . "." . $fileactualext;
                    $fileDestination = '../images/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                }
            }
        }
    }

    // If a new image was uploaded, update the image in the query
    $imageQuery = $fileNameNew ? ", `image` = 'images/$fileNameNew'" : "";

    // Update the room details in the database
    $query = "UPDATE `rooms` SET `room_no`='$roomno', `capacity`='$capacity', `amenities`='$amenities', 
              `tenant_type`='$tenanttype', `room_floor`='$roomfloor', `price`='$price', `status`='$status' 
              $imageQuery WHERE `id` = $id";
    
    mysqli_query($conn, $query);

    header("location: ../manageroom.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <style>
         *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        a{
            text-decoration: none;
            
        }


        body {
            margin: 0;
            font-family: Arial, sans-serif;
            margin-left: 220px; /* Offset for the navbar */
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 220px;
            background-color: white;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .navbar-brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #f4f4f4;
            transition: transform 0.3s ease;
        }

        .navbar-brand img:hover {
            transform: scale(1.1);
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin: auto;
            display: flex;
            flex-direction: column;
            align-items: left;
            flex-grow: 1;
        }

        .nav-links li {
            margin-bottom: 15px;
        }

        .nav-link {
            color: black;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-link:hover {
            background-color: #f0f0f0;
            color: #007bff;
        }

        .login {
            text-align: center;
            margin-top: -10px; /* Adjusting to move the logout button up */
        }

        .login .btn {
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .login .btn:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .navbar {
                width: 180px;
                padding: 15px 10px;
            }

            .navbar-brand img {
                width: 60px;
                height: 60px;
            }

            .nav-link {
                font-size: 14px;
            }

            body {
                margin-left: 180px;
            }
        }

        .btnn{
            color: rgb(255, 255, 255);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
        }

        
    </style>
</head>
<body>
    <nav class="navbar">
        <a class="navbar-brand" href="#">
            <img src="/bhrm-main/images/logo.png" alt="Logo">
        </a>
        <ul class="nav-links">
            <li><a class="nav-link" href="../dashboard.php">Dashboard</a></li>
            <li><a class="nav-link" href="../manageroom.php">Manage Rooms</a></li>
            <li><a class="nav-link" href="../managereservation.php">Reservations</a></li>
            <li><a class="nav-link" href="../payment.php">Payments</a></li>
            <li><a class="nav-link" href="../reports.php">Reports</a></li>
        </ul>
        <div class="login">
            <a class="btnn" href="php/logout.php">Logout</a>
        </div>
    </nav>


    <style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        background-color: #f4f4f4;
    }

    .form-container {
        background-color: #a9a9a9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 500px; /* Increased width to fit the two columns */
    }

    .form-container img {
        display: block;
        margin: 0 auto 15px;
    }

    h1 {
        text-align: center;
        font-size: 22px;
        color: #333;
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-size: 14px;
        color: #fff;
        margin-bottom: 5px;
    }

    input, select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        font-size: 14px;
        box-sizing: border-box;
    }

    input[type="file"] {
        padding: 5px;
    }

    input[type="checkbox"] {
        margin: 0px;
    }

    /* Align radio buttons horizontally and wrap them when necessary */
    #amenities-container {
        display: flex;
        flex-wrap: wrap; /* Ensure the radio buttons wrap */
        gap: 20px; /* Space between radio buttons */
        margin-bottom: 10px;
    }

    #amenities-container label{
        margin: 0px;
    }

    #amenities-container div {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    #add-amenity-btn {
        background-color: #007bff;
        color: #fff;
        padding: 8px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
        margin-bottom: 10px;
        display: block;
        width: 100%;
        text-align: center;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 20px;
    }

    /* Make both submit and back buttons equally tall */
    .button-container input, .button-container a {
        background-color: #f0ad4e;
        color: #fff;
        font-size: 16px;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 50px; /* Set a fixed height to make buttons equal height */
    }

    a.btn-secondary {
        background-color: #6c757d;
    }

    .button-container input[type="submit"]:hover, a.btn-secondary:hover {
        opacity: 0.9;
    }

    .img-preview {
        text-align: center;
        margin-bottom: 15px;
    }

    .img-preview img {
        width: 70%;
        height: auto;
        border-radius: 5px;
    }

    #new-amenity, #save-amenity-btn {
        display: none;
        margin-top: 10px;
    }

    #new-amenity {
        width: calc(100% - 80px);
        display: inline-block;
    }

    #save-amenity-btn {
        width: 70px;
        padding: 8px;
        display: inline-block;
        background-color: #28a745;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #save-amenity-btn:hover {
        opacity: 0.9;
    }

    .status {
        background-color: #d3d3d3;
        color: #666;
    }
</style>

<div class="container">
    <div class="form-container">
        <img src="../images/logo.png" alt="Logo" height="100">
        <h1>Add Room</h1>
        <form action="" method="post" enctype="multipart/form-data">


        <label>Room No:</label>
        <input type="text" name="roomno" value="<?php echo $data['room_no']; ?>" placeholder="Enter here..." required>

        <label>Capacity:</label>
        <input type="text" name="capacity" value="<?php echo $data['capacity']; ?>" placeholder="Enter here..." required>



            <!-- Amenities section below Room No and Capacity -->



            <label>Amenities:</label>
            <div id="amenities-container">
                <div>
                    <input type="checkbox" name="amenities[]" value="wifi" id="wifi" 
                        <?php echo in_array('wifi', $amenitiesSelected) ? 'checked' : ''; ?>>
                    <label for="wifi">WiFi</label>
                </div>
                <div>
                    <input type="checkbox" name="amenities[]" value="bedsheets" id="bedsheets" 
                        <?php echo in_array('bedsheets', $amenitiesSelected) ? 'checked' : ''; ?>>
                    <label for="bedsheets">Bedsheets</label>
                </div>
                <div>
                    <input type="checkbox" name="amenities[]" value="tv" id="tv" 
                        <?php echo in_array('tv', $amenitiesSelected) ? 'checked' : ''; ?>>
                    <label for="tv">TV</label>
                </div>
                <div>
                    <input type="checkbox" name="amenities[]" value="bathroom" id="bathroom" 
                        <?php echo in_array('bathroom', $amenitiesSelected) ? 'checked' : ''; ?>>
                    <label for="bathroom">Bathroom</label>
                </div>
            </div>
            <button type="button" id="add-amenity-btn">Add New Amenity</button>
            <input type="text" id="new-amenity" placeholder="Enter new amenity" style="display:none;">
            <button type="button" id="save-amenity-btn" style="display:none;">Save</button>



        <label>Tenant Type:</label>
        <select name="tenanttype" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label>Room Floor:</label>
        <select name="roomfloor" required>
            <option value="ground floor">Ground Floor</option>
            <option value="1st floor">1st Floor</option>
            <option value="2nd floor">2nd Floor</option>
        </select>

        <label>Rent / Month:</label>
        <input type="text" name="price" value="<?php echo $data['price']; ?>" placeholder="Enter here..." required>

        <label>Image:</label>
        <input type="file" name="image" value="<?php echo $data['image']; ?>">

        <?php if ($data['id'] != '') : ?>
            <div class="img-preview">
                <img src="../<?php echo $data['image']; ?>" alt="Room Image">
            </div>
        <?php endif; ?>

        <label>Status:</label>
        <input type="text" name="status" value="available" class="status" readonly>


        <div class="button-container">
            <?php if ($data['id'] != '') : ?>
                <input type="submit" name="update" value="Update">
            <?php else: ?>
                <input type="submit" name="submit" value="Submit">
            <?php endif; ?>
            <a href="../manageroom.php" class="btn-secondary">Back</a>
        </div>
 

        </form>
    </div>
</div>


<script>
    const addAmenityBtn = document.getElementById('add-amenity-btn');
    const newAmenityInput = document.getElementById('new-amenity');
    const saveAmenityBtn = document.getElementById('save-amenity-btn');
    const amenitiesContainer = document.getElementById('amenities-container');

    // Show the new amenity input field and save button when "Add New Amenity" is clicked
    addAmenityBtn.addEventListener('click', () => {
        newAmenityInput.style.display = 'inline-block';  // Show input
        saveAmenityBtn.style.display = 'inline-block';  // Show Save button
    });

    // Save the new amenity when the save button is clicked
    saveAmenityBtn.addEventListener('click', () => {
        const newAmenityValue = newAmenityInput.value.trim();
        if (newAmenityValue) {
            // Create a new div for the new amenity
            const newAmenityDiv = document.createElement('div');
            const newAmenityCheckbox = document.createElement('input');
            newAmenityCheckbox.type = 'checkbox';
            newAmenityCheckbox.name = 'amenities[]';  // Name it as an array to handle multiple values
            newAmenityCheckbox.value = newAmenityValue;

            const newAmenityLabel = document.createElement('label');
            newAmenityLabel.textContent = newAmenityValue;

            // Append the checkbox and label to the new div
            newAmenityDiv.appendChild(newAmenityCheckbox);
            newAmenityDiv.appendChild(newAmenityLabel);

            // Add the new amenity to the container
            amenitiesContainer.appendChild(newAmenityDiv);

            // Clear the input field and hide the save button again
            newAmenityInput.value = '';
            newAmenityInput.style.display = 'none';
            saveAmenityBtn.style.display = 'none';
        }
    });
</script>








</body>

</html>
