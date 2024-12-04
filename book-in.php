<?php

require 'php/connection.php';

if (!empty($_SESSION["hname"])) {
    if (!empty($_SESSION["roomno"])){
        $roomno = $_SESSION['roomno'];
    }else{
        $roomno = $_GET['roomno'];
    }
    $uname = $_SESSION['uname'];
    $hname = $_SESSION['hname'];
    
    // Fetch the latest reservation for the user
    $query = "SELECT * FROM reservation WHERE email = '$uname' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $fetch = mysqli_fetch_assoc($result);
        
        if (!empty($fetch['res_stat']) && ($fetch['res_stat'] == 'Pending' || $fetch['res_stat'] == 'Approved' || $fetch['res_stat'] == 'Confirmed') ) {
            // Block users with 'Pending' or 'Approved' status in their latest reservation
            $_SESSION['already_booked'] = true;
            header("location: boardinghouse.php?hname=$hname");
            exit();
        } else if ($fetch['res_stat'] == 'Rejected') {
            // Allow users with 'Rejected' status to proceed
            unset($_SESSION['already_booked']);
        } else if ($fetch['res_stat'] == 'Cancelled') {
            // Allow users with 'Rejected' status to proceed
            unset($_SESSION['already_booked']);
        }   else if ($fetch['res_stat'] == 'Ended') {
            // Allow users with 'Rejected' status to proceed
            unset($_SESSION['already_booked']);
        }
    } else {
        // Handle no results case
        echo '';
    }
}


if(!empty($_SESSION["uname"]) && !empty($_SESSION["role"])){
    $hname = $_SESSION['hname'];
    if (!empty($_SESSION["roomno"])){
        $roomno = $_SESSION['roomno'];
    }else{
        $roomno = $_GET['roomno'];
    }
    $query = "select * from rooms where room_no = '$roomno' and hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);   
    $roomno = $fetch['room_no']; 
    $roomimg = $fetch['image'];
    $roomcapacity = $fetch['capacity'];
    $amenities = $fetch['amenities'];
    $roomprice = $fetch['price'];
    $roomstat = $fetch['status'];
    if($result){
        $uname = $_SESSION['uname'];
        $query = "select * from users where uname = '$uname'";
        $result = mysqli_query($conn, $query);
        $fetch = mysqli_fetch_assoc($result);
        $fname = $fetch['fname'];
        $lname = $fetch['lname'];
        $gender = $fetch['gender'];
    }if($result){
        $hname = $_SESSION['hname'];
        $query = "select * from rooms where hname = '$hname'";
        $result = mysqli_query($conn, $query);
        $fetch = mysqli_fetch_assoc($result);
    }
}else{
    $_SESSION['login_warning'] = true;
    header('location: index.php');
    exit(); // Prevent further script execution
}


if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $datein = $_POST['datein'];
    $dateout = $_POST['dateout'];
    $tenantstatus = $_POST['tenant_status'];
    $addons = $_POST['addons'];
    $roomno = $_GET['roomno'];
    $capacity = $roomcapacity;
    $amenities = $fetch['amenities'];
    $image = $fetch['image'];
    $roomfloor = $fetch['room_floor'];
    $price = $fetch['price']; // Assuming this is now the room price, you can rename for clarity
    $status = $fetch['status'];
    $hname = $_SESSION['hname'];

    // Fetch boarding house details
    $query = "SELECT * FROM boardinghouses WHERE hname = '$hname'";
    $result = mysqli_query($conn, $query);
    $fetch = mysqli_fetch_assoc($result);
    $owner = $fetch['owner'];

    // Insert the reservation without any bed-related fields
    $query = "INSERT INTO `reservation` 
              (`id`, `fname`, `lname`, `email`, `gender`, `date_in`, `date_out`, `tenant_status`, `addons`, `room_no`, `capacity`, `amenities`, `room_floor`, `price`, `image`, `status`, `res_stat`, `res_duration`, `res_reason`, `hname`, `owner`) 
              VALUES 
              ('', '$fname', '$lname', '$email', '$gender', '$datein', '$dateout', '$tenantstatus', '$addons', '$roomno', '$capacity', '$amenities', '$roomfloor', '$price', '$image', '$status', 'Pending', '1 day', '', '$hname', '$owner')";

    mysqli_query($conn, $query);

    // Redirect to thank-you page after submission
    header("location: thankyou.php");
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- External CSS -->
</head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .background{
            padding: 20px;
            width: 1000px;
            margin: 50px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .btn{
            color: rgb(255, 255, 255);
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #007bff;
        }

        button {
            grid-column: span 2;
            background-color: #ffaa00;
            border: none;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            color: white;
        }

        button:hover {
            background-color: #bb7d01;
        }
    </style>
<body>
<?php include 'navbar.php'; ?>

<div class="background">
       

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            max-width: 600px;
            max-height: 80%;
            width: 90%;
            overflow-y: auto; /* Enables scrolling inside the modal */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky; /* Keeps header visible while scrolling */
            top: 0;
            background-color: white;
            z-index: 10;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .modal-header h2 {
            margin: 0;
        }

        .close {
            font-size: 1.5rem;
            font-weight: bold;
            color: black;
            border: none;
            background: none;
            cursor: pointer;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .room-details {
            text-align: center;
            margin-bottom: 20px;
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .bed-details {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
            width: 100%;
        }

        .bed-card {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        .bed-card img {
            max-width: 100%;
            border-radius: 4px;
        }

        .preview-btn {
            padding: 10px 20px;
            background-color: #ffaa00;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .preview-btn:hover {
            background-color: #bb7d01;
        }

        .centering {
            display: flex;
            justify-content: center;
            margin: 20px;
        }
    </style>



    <div class="centering">
        <button id="previewButton" class="preview-btn">Preview</button>
    </div>

    <div id="infoModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Room Details</h2>
                <button class="close" id="closeModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="room-details">
                    <h5>Selected Room: <?php echo $roomno ?></h5>
                    <img src="<?php echo $roomimg ?>" alt="Room Image">
                    <p>Room Capacity: <?php echo $roomcapacity ?></p>
                    <p>Room Amenities: <?php echo $amenities ?></p>
                    <p>Room Price: <?php echo $roomprice ?></p>
                    <p>Room Status: <?php echo $roomstat ?></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('previewButton').addEventListener('click', function () {
            document.getElementById('infoModal').style.display = 'flex';
        });

        document.getElementById('closeModal').addEventListener('click', function () {
            document.getElementById('infoModal').style.display = 'none';
        });

        window.onclick = function (event) {
            const modal = document.getElementById('infoModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        };
    </script>





    

    <div class="form">
        <form method="post">
            <div class="form-col">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="fname" value="<?php echo $fname ?>">
            </div>
            <div class="form-col">
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="lname" value="<?php echo $lname ?>">
            </div>
            <div class="form-col">
                <label>Status</label>
                <select id="fruits" name="tenant_status">
                    <option value="">Select Status</option>
                    <option value="Student">Student</option>
                    <option value="Worker">Worker</option>
                </select>
            </div>
            <div class="form-col">
                <label for="lname">Gender</label>
                <input type="text" id="lname" name="gender" value="<?php echo $gender ?>" readonly>
            </div>
            <div class="form-col">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $_SESSION['uname']; ?>" readonly>
            </div>
            <div class="form-col">
                <label for="datein">Date in</label>
                <input type="date" id="datein" name="datein" min="<?php echo date('Y-m-d'); ?>" oninput="this.min = new Date().toISOString().split('T')[0]">
            </div>
            <div class="form-col">
                <label for="dateout">Date out</label>
                <input type="date" id="dateout" name="dateout">
            </div>
            <div class="form-col">
                <label for="addons">Additional Requests</label>
                <input type="text" id="addons" name="addons">
            </div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <style>
        .form{
            border: 1px solid black;
            width: auto;
            display: flex;
            justify-content: center;
        }

                
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            padding: 20px;
            width: 600px;
        }

        .form-col{
            display: flex;
            flex-direction: column;
        }
        .form-col:last-child{
            grid-column-start: 1;
            grid-column-end: 3;

            display: flex;
            flex-direction: row;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

</div>

    <script>
        document.getElementById('datein').addEventListener('change', function() {
            calculateDateOut();
        });

        function calculateDateOut() {
            const dateInInput = document.getElementById('datein');
            const dateOutInput = document.getElementById('dateout');

            // Get the selected date from the "Date in" field
            let dateInValue = new Date(dateInInput.value);

            // Check if a valid date is selected
            if (isNaN(dateInValue)) return;

            // Add 30 days to the "Date in" value
            dateInValue.setDate(dateInValue.getDate() + 30);

            // Convert the new date to the correct format (YYYY-MM-DD)
            const dateOutValue = dateInValue.toISOString().split('T')[0];

            // Set the "Date out" field with the calculated date
            dateOutInput.value = dateOutValue;
        }
    </script>

    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="bed[]"]');
        const capacity = <?php echo $fetch['capacity']; ?>; // Room capacity fetched from PHP

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('input[type="checkbox"][name="bed[]"]:checked').length;
                if (checkedCount > capacity) {
                    this.checked = false;
                    alert(`You can only book up to ${capacity} beds.`);
                }
            });
        });
    </script>
    
    <script>
        function updateBedCounter(checkbox) {
        const checkboxes = document.querySelectorAll('.bed-checkbox');
        const counter = document.getElementById('bed-counter');

        // Uncheck all other checkboxes
        checkboxes.forEach(box => {
            if (box !== checkbox) {
                box.checked = false;
            }
        });

        // Update counter text based on the selected checkbox
        counter.textContent = checkbox.checked ? '1 bed selected' : 'No bed selected';
    }
    </script>


</body>
</html>
