<?php

require 'php/connection.php';
if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"] == 'user')) {
    unset($_SESSION['hname']);
}

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    $uname = $_SESSION["uname"];
    $role = $_SESSION["role"];
    $result = mysqli_query($conn, "select * from users where uname = '$uname'");
    $fetch = mysqli_fetch_assoc($result);
    
    echo "
    <script src='jquery.min.js'></script>
    <link rel='stylesheet' href='toastr.min.css'/>
    <script src='toastr.min.js'></script>
    <script>
        $(document).ready(function() {
            // Check if the login message should be displayed
            " . (isset($_SESSION['login_message_displayed']) ? "toastr.success('Logged in Successfully');" : "") . "
        });
    </script>
    ";

    // Unset the session variable to avoid repeated notifications
    if (isset($_SESSION['login_message_displayed'])) {
        unset($_SESSION['login_message_displayed']);
    }
}


if (!empty($_SESSION["uname"]) && $_SESSION["role"] == 'landlord') {
    header('location: boardinghouse.php');
}

if (isset($_SESSION['login_warning']) && $_SESSION['login_warning'] == true) {
    echo "
    <script src='jquery.min.js'></script>
    <link rel='stylesheet' href='toastr.min.css'/>
    <script src='toastr.min.js'></script>
    <script>
        $(document).ready(function() {
            toastr.error('Please log in to proceed further.');
        });
    </script>";
    unset($_SESSION['login_warning']); // Clear the session variable after use
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
/* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    background-color: none; /* White background */
    color: #343a40; /* Dark text color */
    margin: 0;
    overflow-x: hidden; /* Prevent horizontal scrolling only */
}

/* Animated Background */
@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.background {
    background: linear-gradient(45deg, #343a40, #aeb5bb, #343a40, #ffffff);
    background-size: 400% 400%;
    animation: gradientAnimation 15s ease infinite;
    min-height: 100vh;
    background-repeat: no-repeat;
    background-position: center;
    position: relative;
    padding-bottom: 80px; /* Ensure footer space */
}

/* Content Background */
.content-background {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 0px auto; /* Adds space around the content */
    max-width: 1100px;
}

/* Section for admin charts */
.chart-section {
    text-align: center;
    margin-bottom: 30px;
}

canvas {
    max-width: 100%;
    height: auto;
}

/* Card Styles */
.card {
    border: none;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-content {
    padding: 15px;
}

.card-content h5 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.card-content p {
    font-size: 0.9rem;
    margin-bottom: 8px;
}

/* General Button Styles */
.button {
    background-color: #ffc107; /* Default color for buttons */
    color: white; /* Text color */
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background-color 0.2s ease, color 0.2s ease; /* Ensure smooth transitions */
}
a.button {
    text-decoration: none; /* Removes the underline */
}

a.button:hover {
    text-decoration: none; /* Ensures no underline on hover */
}


.button:hover {
    background-color: #e0a800; /* Slightly darker yellow */
    color: white; /* Text color remains white */
}

/* Specific styles for Delete button */
.button.delete {
    background-color: #dc3545; /* Default red for delete button */
    color: white; /* Ensure text is white */
}

.button.delete:hover {
    background-color: #c82333; /* Darker red on hover */
    color: white; /* Text color remains white */
}

/* Specific styles for Update button */
.button.update {
    background-color: #28a745; /* Default green for update button */
    color: white; /* Ensure text is white */
}

.button.update:hover {
    background-color: #218838; /* Darker green on hover */
    color: white; /* Text color remains white */
}


/* Footer */
.footer {
    background-color: #343a40;
    color: white;
    padding: 20px 0;
    text-align: center;
   
}

.footer a {
    color: #ffc107;
}

.footer a:hover {
    color: white;
}


    </style>
</head>

<body>
    <div class="background">
        
        <?php 
            if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'admin'){
                include 'navadmin.php'; 
            }else{
                include 'navbar.php';
            }   
        ?>

        <div class="content-background">

            <div class="text-center py-4">
                <h1>Welcome to Maranding Boarding House Center</h1>
                <p>Discover the best boarding houses around Maranding. Choose your preferred place and enjoy your stay.</p>
            </div>

            <!-- Cards Section -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $query = "SELECT * FROM boardinghouses INNER JOIN documents ON boardinghouses.hname = documents.hname";
                $result = mysqli_query($conn, $query);
                while ($fetch = mysqli_fetch_assoc($result)) :
                    $hname = $fetch['hname'];
                ?>
                    <div class="col">
                        <div class="card">
                            <img src="<?php echo $fetch['image']; ?>" alt="Boarding House">
                            <div class="card-content">
                                <h5><?php echo $fetch['hname']; ?></h5>
                                <p><strong>Owner:</strong> <?php echo $fetch['landlord']; ?></p>
                                <p><strong>Address:</strong> <?php echo $fetch['haddress']; ?></p>
                                <p><strong>Contact:</strong> <?php echo $fetch['contact_no']; ?></p>
                                <div>
                                    <?php if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'admin') : ?>
                                        <a href="php/function.php?edit=<?php echo $fetch['id']; ?>" class="button update">Update</a>
                                        <a href="#" class="button delete" data-href="php/function.php?delete=<?php echo $fetch['id']; ?>" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</a>
                                    <?php else : ?>
                                        <a href="boardinghouse.php?hname=<?php echo $hname; ?>" class="button details">More Details</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    
 <!-- Confirmation Modal -->
 <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this landlord's boarding house?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButtons = document.querySelectorAll('.button.delete');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const deleteUrl = this.getAttribute('data-href');
                    confirmDeleteBtn.setAttribute('href', deleteUrl);
                });
            });
        });
    </script>

    <div class="container mt-5">
        <!-- Reservation Section -->
        <section id="reservation-easy" class="section mb-5">
            <h2 class="display-4">Reservation Made Easy</h2>
            <p>At <strong>Maranding Boarding House Center</strong>, reserving a room has never been easier! With just a few clicks, you can browse through various boarding houses, check availability, and book a room that suits your needs. Our user-friendly platform ensures that the entire process is seamless, from start to finish. No more complicated forms or long procedures—everything is at your fingertips!</p>
        </section>

        <!-- What is Boarding House Section -->
        <section id="what-is-boarding-house" class="section mb-5">
            <h2 class="display-4">What is a Boarding House?</h2>
            <p>A boarding house is a place that offers rooms for rent, typically with shared facilities such as bathrooms, kitchens, and lounges. Boarding houses are often an affordable living option for students, workers, or anyone in need of temporary accommodation. Whether you're looking for a short-term stay or long-term housing, a boarding house can be a perfect solution!</p>
        </section>

        <!-- How Reservation Works Section -->
        <section id="how-it-works" class="section mb-5">
            <h2 class="display-4">Reservations</h2>
            <p>Our reservation system is designed to be quick and convenient. Here's how it works:</p>
            <ol class="fs-4">
                <li><strong>Browse Boarding Houses:</strong> Explore a variety of boarding houses available in Maranding, each offering different amenities and features.</li>
                <li><strong>Check Availability:</strong> Quickly check the availability of rooms based on your desired check-in and check-out dates.</li>
                <li><strong>Make a Reservation:</strong> Once you’ve found the perfect room, submit your booking details, and we’ll handle the rest.</li>
                <li><strong>Confirmation:</strong> You’ll receive an instant confirmation once your reservation is approved. Simple and stress-free!</li>
            </ol>
        </section>

        <!-- About Maranding Boarding House Center Section -->
        <section id="about" class="section mb-5">
            <h2 class="display-4">About Maranding Boarding House Center</h2>
            <p>Welcome to <strong>Maranding Boarding House Center</strong>, your trusted platform for finding the best boarding houses in Maranding. We aim to make accommodation accessible, affordable, and hassle-free for everyone. Whether you're a student, worker, or traveler, our platform helps you find a place to stay that meets your needs. Our goal is to provide a seamless experience from browsing to booking and everything in between.</p>
        </section>
    </div>



    <footer class="footer">
        <p>© 2024 Your Company Name. All Rights Reserved.</p>
        <p>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
        </p>
    </footer>

    <?php include 'chat.php'?>
</body> 

</html>
