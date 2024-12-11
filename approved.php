<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Reservations</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .table-responsive {
            margin-top: 20px;
            overflow-x: auto; /* Allow horizontal scrolling */
        }
        .dataTable thead {
            background-color: #212529;
            color: white;
        }

        /* Keep search bar and pagination fixed */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_paginate {
            position: sticky;
            top: 10px; /* Adjust to your needs */
            background-color: white;
            z-index: 10; /* Ensure it's above the table */
        }

        /* Remove background color for pagination container */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: transparent; /* No background color */
            color: #212529; /* Default text color */
            border: none; /* Remove border */
            padding: 0; /* Remove padding */
        }
        /* Remove padding on the "Next" and "Previous" buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {
            padding: 0; /* Remove padding */
        }
        /* Remove padding from individual page number buttons */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0; /* Remove padding */
        }
        /* Highlight on hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #212529; /* Dark background */
            color: white; /* White text */
            border-radius: 5px; /* Optional: rounded corners */
        }
        /* Highlight current page */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #212529; /* Dark background */
            color: white; /* White text */
            border-radius: 5px; /* Optional: rounded corners */
        }

        /* Fix the header so it stays on top */
        .dataTables_wrapper .dataTables_scrollHead {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .dataTables_wrapper .dataTables_scrollBody {
            overflow-x: auto; /* Ensure horizontal scroll on body only */
        }

        .dataTables_wrapper .dataTables_scroll {
            overflow-x: hidden; /* Prevent horizontal scroll on the whole table */
        }

    </style>
</head>
<body>
    <?php include 'navigationbar.php'; ?>

    <?php 
        if (!empty($_SESSION) && $_SESSION['role'] == 'landlord') {
            $hname = $_SESSION['hname'];
        
            // Fetch all reservations with 'Confirmed' or 'Approved' status
            $query = "SELECT * FROM reservation WHERE hname = '$hname' AND res_stat IN ('Confirmed', 'Approved') ORDER BY id DESC";
            $result = mysqli_query($conn, $query);
        }
    ?>

    <h1 class="text-center">Approved and Confirmed reservations</h1>

    <div class="container table-responsive">
        <table id="reservationsTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Reservation No</th>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Tenant Status</th>
                    <th>Room No</th>
                    <th>Room Rent</th>
                    <th>Selected Room Slot</th> 
                    <th>Date In</th>
                    <th>Date Out</th>
                    <th>Requests</th>
                    <th>Duration</th>
                    <th>Reason</th>
                    <th>Reservation Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($fetch = mysqli_fetch_assoc($result)) {
                    $id = $fetch['id'];
                    $uname = $fetch['email'];

                    // Fetch payment details for the current reservation email
                    $paymentQuery = "SELECT * FROM payments WHERE hname = '$hname' AND email = '$uname' and res_id = '$id' ORDER BY id DESC LIMIT 1";
                    $paymentResult = mysqli_query($conn, $paymentQuery);
                    $paymentData = mysqli_fetch_assoc($paymentResult);

                    $payment = $paymentData['payment'] ?? 'No Payment Data';
                    $paystat = $paymentData['pay_stat'] ?? 'No Payment Status';
                    $paydate = $paymentData['pay_date'] ?? 'No Payment Date';
                ?>
                <tr id="reservation-<?php echo $fetch['id']; ?>">
                    <td><?php echo $fetch['id']; ?></td>
                    <td><?php echo $fetch['fname'] . ' ' . $fetch['lname']; ?></td>
                    <td><?php echo $fetch['email']; ?></td>
                    <td><?php echo $fetch['gender']; ?></td>
                    <td><?php echo $fetch['tenant_status']; ?></td>
                    <td><?php echo $fetch['room_no']; ?></td>
                    <td><?php echo $fetch['price']; ?></td>
                    <td><?php echo $fetch['room_slot']; ?></td>
                    <td><?php echo $fetch['date_in']; ?></td>
                    <td><?php echo $fetch['date_out']; ?></td>
                    <td><?php echo $fetch['addons']; ?></td>
                    <td><?php echo $fetch['res_duration']; ?></td>
                    <td><?php echo $fetch['res_reason']; ?></td>
                    <td><?php echo $fetch['res_stat']; ?></td>
                    <td>
                        <!-- Action Buttons -->
                        <?php if ($fetch['res_stat'] == 'Pending'): ?>
                            <a href="php/function.php?approve=<?php echo $fetch['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                            <a href="php/function.php?reject=<?php echo $fetch['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                        <?php elseif ($fetch['res_stat'] == 'Rejected'): ?>
                            <button class="btn btn-secondary btn-sm" disabled>Approve</button>
                            <button class="btn btn-secondary btn-sm" disabled>Reject</button>
                        <?php endif; ?>

                        <?php if ($fetch['res_stat'] == 'Approved'): ?>
                            <a href="php/function.php?confirm=<?php echo $fetch['id']; ?>" class="btn btn-success btn-sm">Confirm</a>
                            <a href="php/function.php?cancel=<?php echo $fetch['id']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                        <?php elseif ($fetch['res_stat'] == 'Confirmed'): ?>
                            <!-- Dynamically check payment status for "End Reservation" button -->
                            <a href="php/function.php?end=<?php echo $fetch['id']; ?>" 
                                id="end-reservation-<?php echo $fetch['id']; ?>" 
                                class="btn btn-warning btn-sm">End Reservation</a>
                            <?php elseif ($fetch['res_stat'] == 'Ended'): ?>
                            <button class="btn btn-secondary btn-sm" disabled>End Reservation</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to check payment status for each reservation
            function checkPaymentStatus(reservationId) {
                $.ajax({
                    url: '',  // Stay within the current file
                    type: 'POST',
                    data: {
                        reservation_id: reservationId
                    },
                    success: function(response) {
                        // Get the payment status from the response
                        let payStatus = response.trim();  // Assuming the response is just the payment status

                        // Get the End Reservation button for this reservation
                        let endButton = $('#end-reservation-' + reservationId);

                        // If payment status is "Not Paid Yet", disable the button
                        if (payStatus === 'Not Paid Yet') {
                            endButton.addClass('disabled').prop('disabled', true);
                        } else {
                            endButton.removeClass('disabled').prop('disabled', false);
                        }
                    }
                });
            }

            // Loop through each reservation to check payment status
            <?php 
            while ($fetch = mysqli_fetch_assoc($result)) {
                echo 'checkPaymentStatus(' . $fetch['id'] . ');';
            }
            ?>

            // Optional: Set an interval to check the payment status every 30 seconds
            setInterval(function() {
                <?php 
                // Recheck for all reservations
                while ($fetch = mysqli_fetch_assoc($result)) {
                    echo 'checkPaymentStatus(' . $fetch['id'] . ');';
                }
                ?>
            }, 30000); // Check every 30 seconds
        });
        </script>

    <script>
    // Initialize DataTable
    $(document).ready(function () {
        $('#reservationsTable').DataTable({
            paging: true,       // Enable pagination
            searching: true,    // Enable search bar
            ordering: true,     // Enable column ordering
            info: true,         // Show info (e.g., "Showing 1 to 10 of 100 entries")
            responsive: false,  // Disable auto-stacking for small screens
            scrollX: true       // Enable horizontal scrolling
        });
    });
    </script>
</body>
</html>
