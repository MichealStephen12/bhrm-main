<?php require 'php/connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
} else {
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- Include Bootstrap CSS (optional for styling) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Reservation List</h2>

        <!-- DataTable -->
        <table id="reservationTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Boarding House</th>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Room No</th>
                    <th>Room Rent</th>
                    <th>Payment</th>
                    <th>Payment Date</th>
                    <th>Payment Status</th>
                    <th>Date In</th>
                    <th>Date Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($_SESSION['uname']) && $_SESSION['role'] == 'user') {
                    $uname = $_SESSION['uname'];
                    $reservationQuery = "SELECT * FROM reservation WHERE email = '$uname' ORDER BY id desc";
                    $reservationResult = mysqli_query($conn, $reservationQuery);

                    while ($reservation = mysqli_fetch_assoc($reservationResult)) {
                        echo "<tr>
                            <td>{$reservation['id']}</td>
                            <td>{$reservation['hname']}</td>
                            <td>{$reservation['fname']} {$reservation['lname']}</td>
                            <td>{$reservation['email']}</td>
                            <td>{$reservation['room_no']}</td>
                            <td>{$reservation['price']} PHP</td>
                            <td>{$reservation['payment']}</td>
                            <td>{$reservation['pay_date']}</td>
                            <td>{$reservation['pay_stat']}</td>
                            <td>{$reservation['date_in']}</td>
                            <td>{$reservation['date_out']}</td>
                            <td>{$reservation['res_stat']}</td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <!-- Include Bootstrap Bundle JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function () {
            $('#reservationTable').DataTable({
                "pageLength": 10, // Number of rows per page
                "ordering": true, // Enable sorting
                "searching": true, // Enable searching
                "info": true, // Show info
                "lengthChange": true // Enable page length change
            });
        });
    </script>
</body>

</html>
