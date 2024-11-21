<?php

include('php/connection.php'); // Database connection file



$hname = $_SESSION['hname'];

// Fetch total sum of payments from the reports table (based on payment)
$totalPaymentsQuery = "SELECT SUM(payment) AS total_payments 
                       FROM reports 
                       WHERE hname = '$hname' AND pay_date IS NOT NULL";
$totalPaymentsResult = mysqli_query($conn, $totalPaymentsQuery);
$totalPayments = mysqli_fetch_assoc($totalPaymentsResult)['total_payments'];

// Fetch total number of tenants (counting reports entries)
$totalTenantsQuery = "SELECT COUNT(*) AS total_tenants 
                      FROM reports 
                      WHERE hname = '$hname'";
$totalTenantsResult = mysqli_query($conn, $totalTenantsQuery);
$totalTenants = mysqli_fetch_assoc($totalTenantsResult)['total_tenants'];

// Fetch detailed report data for the landlord's boarding house
$reportQuery = "SELECT * FROM reports WHERE hname = '$hname' ORDER BY date_in DESC";
$reportResult = mysqli_query($conn, $reportQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - <?php echo $hname; ?></title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
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

        
        .btn{
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
            <img src="images/logo.png" alt="Logo">
        </a>
        <ul class="nav-links">
            <li><a class="nav-link" href="dashboard.php">Dashboard</a></li>
            <li><a class="nav-link" href="manageroom.php">Manage Rooms</a></li>
            <li><a class="nav-link" href="managereservation.php">Reservations</a></li>
            <li><a class="nav-link" href="payment.php">Payments</a></li>
            <li><a class="nav-link" href="reports.php">Reports</a></li>
        </ul>
        <div class="login">
            <a class="btn" href="php/logout.php">Logout</a>
        </div>
    </nav>


    <style>
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2.5em;
            color: #333;
        }

        .summary {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 30%;
            transition: transform 0.3s ease-in-out;
        }

        /* Add hover effect to the summary cards */
        .card:hover {
            transform: scale(1.05); /* Slightly enlarge on hover */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Add more shadow */
        }

        /* Highlighting the Total Payments and Total Tenants cards */
        .card h3 {
            font-size: 1.8em;
            color: #333;
            font-weight: bold;
        }

        .card .total-amount {
            font-size: 2em;
            font-weight: bold;
            color: #fff;
            background-color: #2ecc71; /* Green background for emphasis */
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Make the text bold for total tenants as well */
        .card p {
            font-size: 1.2em;
            font-weight: bold;
            color: #2ecc71;
        }

        .card .total-amount,
        .card p {
            font-size: 1.5em; /* Make total text slightly larger */
            font-weight: bold;
            color: #fff;
            background-color: #2ecc71; /* A matching color for consistency */
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out; /* Add a smooth animation */
        }

        .card .total-amount {
            background-color: #27ae60; /* Different shade for distinction */
        }

        /* Adding an extra shadow to make it pop more */
        .card:hover .total-amount {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Optional: Add animations to make totals appear more dynamically */
        .card .total-amount,
        .card p {
            opacity: 0;
            transform: translateY(20px); /* Start from below */
            animation: fadeInUp 0.8s forwards; /* Animation when loaded */
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .report-table th, .report-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .report-table th {
            background-color: #2ecc71;
            color: #fff;
        }

        .report-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .report-table tr:hover {
            background-color: #f1f1f1;
        }

        .report-table td {
            font-size: 1em;
        }
    </style>
    <div class="container">
        <h1>Reports for <?php echo $hname; ?></h1>

        <!-- Display Total Payments -->
        <div class="summary">
            <div class="card">
                <h3>Total Payments</h3>
                <p class="total-amount"><?php echo number_format($totalPayments, 2); ?> PHP</p>
            </div>
            <div class="card">
                <h3>Total Tenants</h3>
                <p><?php echo $totalTenants; ?> Tenants</p>
            </div>
        </div>

        <!-- Detailed Reports Table -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>Tenant Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Room No</th>
                    <th>Bed No</th>
                    <th>Payment</th>
                    <th>Payment Date</th>
                    <th>Date In</th>
                    <th>Date Out</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($report = mysqli_fetch_assoc($reportResult)) { ?>
                    <tr>
                        <td><?php echo $report['fname'] . ' ' . $report['lname']; ?></td>
                        <td><?php echo $report['gender']; ?></td>
                        <td><?php echo $report['email']; ?></td>
                        <td><?php echo $report['room_no']; ?></td>
                        <td><?php echo $report['bed_no']; ?></td>
                        <td><?php echo number_format($report['payment'], 2); ?> PHP</td>
                        <td><?php echo $report['pay_date'] ?: 'N/A'; ?></td>
                        <td><?php echo $report['date_in']; ?></td>
                        <td><?php echo $report['date_out'] ?: 'N/A'; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
