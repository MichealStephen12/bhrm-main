<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        <h1> Approved Reservations </h1>
        <div class="container table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Guest Name</th>
                        <th>Room No</th>
                        <th>Date In</th>
                        <th>Date Out</th>
                        <th>Reservation Status</th>
                        <th>Payment</th>
                        <th>Payment Status</th>
                        <th>Payment Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    while ($fetch = mysqli_fetch_assoc($result)) {
                        $uname = $fetch['email'];

                        // Fetch payment details for the current reservation email
                        $paymentQuery = "SELECT * FROM payments WHERE hname = '$hname' AND email = '$uname' ORDER BY id DESC LIMIT 1";
                        $paymentResult = mysqli_query($conn, $paymentQuery);
                        $paymentData = mysqli_fetch_assoc($paymentResult);

                        $payment = $paymentData['payment'] ?? 'No Payment Data';
                        $paystat = $paymentData['pay_stat'] ?? 'No Payment Status';
                        $paydate = $paymentData['pay_date'] ?? 'No Payment Date';
                    ?>
                    <tr>
                        <td><?php echo $fetch['id']; ?></td>
                        <td><?php echo $fetch['fname'] . ' ' . $fetch['lname']; ?></td>
                        <td><?php echo $fetch['room_no']; ?></td>
                        <td><?php echo $fetch['date_in']; ?></td>
                        <td><?php echo $fetch['date_out']; ?></td>
                        <td><?php echo $fetch['res_stat']; ?></td>
                        <td><?php echo $payment; ?></td>
                        <td><?php echo $paystat; ?></td>
                        <td><?php echo $paydate; ?></td>
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
                                <a href="php/function.php?end=<?php echo $fetch['id']; ?>" class="btn btn-warning btn-sm">End Reservation</a>
                            <?php elseif ($fetch['res_stat'] == 'Ended'): ?>
                                <button class="btn btn-secondary btn-sm" disabled>End Reservation</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
</body>
</html>