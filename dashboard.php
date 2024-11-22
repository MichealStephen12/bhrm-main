<?php 
require 'php/connection.php';

if(!empty($_SESSION["uname"]) && $_SESSION["role"] == 'landlord'){
    $uname = $_SESSION['uname'];
    $query = "select * from boardinghouses inner join documents on boardinghouses.hname = documents.hname where boardinghouses.owner = '$uname'";
    $result = mysqli_query($conn, $query);
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
}else{
    header('location: index.php');
}

?>

<?php
    if (isset($_SESSION['already_booked']) && $_SESSION['already_booked'] === true) {
        echo "
        <script src='jquery.min.js'></script>
        <link rel='stylesheet' href='toastr.min.css' />
        <script src='toastr.min.js'></script>
        <script>
            $(document).ready(function() {
                toastr.warning('You have already booked a room.');
            });
        </script>";
        unset($_SESSION['already_booked']); 
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>

</head>
<!-- Bootstrap CSS -->
    <style>
        /* Custom CSS */
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        
        a{
            text-decoration: none;
            color: black;
            
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            margin-left: 220px; /* Offset for the navbar */
        }

        .content-background{
            background-color: white;
            margin: 60px 200px 90px 200px;
            border-radius: 10px;
        }

      
        
    </style>
<body>
    <?php include 'navigationbar.php'; ?>

    <div class="content-background">
        <?php if(!empty($_SESSION['role']) && $_SESSION['role'] == 'landlord'): ?>
        <?php else: ?>
        <div class="back">
            <div>
                <?php 
                    if(empty($_SESSION['uname'])){
                        echo '<a class="btn" href="index.php">Back</a>';
                    }else{
                        echo '<a class="btn" href="index.php">Back</a>';
                    }
                ?>
            </div>     
        </div>
        <?php endif; ?>

        <div class="section1">
            <style>
                .section1{
                    background-color: white;
                    height: auto;
                    font-weight: 20;
                    display: grid;
                    justify-content: center;
                    grid-template-columns: 1fr 1fr;
                    grid-template-rows: 1fr;
                    border-radius: 10px;
                    padding: 30px;
                    padding-top: 30px;
                    gap: 10px;
                }

                canvas{
                    width: 200px;
                    padding: 10px;
                    justify-content: center;
                    border: solid black 1px;
                    border-radius: 10px;
                }

                .chart {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                .chart h3{
                    text-align: center;
                    padding: 5px;
                }

                @media (max-width: 1000px){
                    canvas{
                        width: 450px;
                        padding: 10px;
                        justify-content: center;
                    }

                    .section1{
                        display: flex;
                        flex-wrap: wrap;
                        
                    }
                }
            </style>
            <div class="chart">
                <h3>Number of tenants per Room Numer</h3>
                <div class="chart-container">
                    <canvas id="tenantOccupancyChart"></canvas>
                </div>
            </div>
            <div class="chart">
                <h3>Total Tenants</h3>
                <div class="chart-container">
                    <canvas id="totalTenantsChart"></canvas>
                </div>
            </div>
            <div class="chart">
                <h3>Total Tenants by Month</h3>
                <div class="chart-container">
                    <canvas id="tenantsByMonthChart"></canvas>
                </div>
            </div>


            <?php
                $tenantCountsStatus = [];
                $roomNumbers = [];
                
                if(!empty($_SESSION['hname'])){ 
                    $hname = $_SESSION['hname']; 
                }  
                else {  
                    $hname = $_GET['hname']; 
                } // Get the boarding house name from the session
                
                // Query to get the number of tenants in each occupied room (based on capacity)
                $query_tenants_status = "
                    SELECT room_no, capacity 
                    FROM rooms 
                    WHERE hname = '$hname' 
                    AND status = 'occupied'";
                    
                $result_tenants_status = mysqli_query($conn, $query_tenants_status);
                
                while ($row = mysqli_fetch_assoc($result_tenants_status)) {
                    $roomNumbers[] = $row['room_no'];
                    $tenantCountsStatus[] = $row['capacity'];  // Assuming capacity means the number of tenants
                }
            ?>

            <?php
                $totalTenants = 0;

                if(!empty($_SESSION['hname'])){ 
                    $hname = $_SESSION['hname']; 
                }  
                else {  
                    $hname = $_GET['hname']; 
                } // Get the boarding house name from session
                
                // Query to get the total number of tenants based on room availability and capacity
                $query_total_tenants = "
                    SELECT SUM(capacity) AS total_tenants
                    FROM rooms 
                    WHERE hname = '$hname' 
                    AND status = 'occupied'";
                    
                $result_total_tenants = mysqli_query($conn, $query_total_tenants);
                
                if ($row = mysqli_fetch_assoc($result_total_tenants)) {
                    $totalTenants = $row['total_tenants']; // This will hold the total number of tenants
                }
            ?>

            <?php
                if (!empty($_SESSION['hname'])){
                    $hname = $_SESSION['hname'];
                }else{
                    $hname = $_GET['hname'];
                }
                $query = "
                SELECT 
                    MONTH(date_in) AS month, 
                    SUM(bed_no) AS total_tenants
                FROM 
                    reservation
                WHERE 
                    res_stat = 'Approved' AND hname = '$hname'
                GROUP BY 
                    MONTH(date_in)
                UNION ALL
                SELECT 
                    month, 
                    0 AS total_tenants
                FROM 
                    (SELECT 1 AS month UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12) AS months
                WHERE 
                    month NOT IN (SELECT MONTH(date_in) FROM reservation WHERE status = 'occupied' AND hname = '$hname')
                ORDER BY 
                    month;
                ";
                
                $result = mysqli_query($conn, $query);                                       
                $months = [];
                $tenantCountsByMonth = [];

                while ($row = mysqli_fetch_assoc($result)) {
                    $months[] = $row['month'];
                    $tenantCountsByMonth[] = $row['total_tenants'];
                }

                // Ensure months are ordered correctly
                $data = array_combine($months, $tenantCountsByMonth);
                ksort($data); // Sort data by month
                $months = array_keys($data);
                $tenantCountsByMonth = array_values($data);
    
            ?>

        </div>                  
    </div>

    <script src="chart.min.js"></script>

    <script>
        // Wrap chart logic in a function
        function renderCharts() {
            var roomNumbers = <?php echo json_encode($roomNumbers); ?>;
            var tenantCountsStatus = <?php echo json_encode($tenantCountsStatus); ?>;

            var ctx3 = document.getElementById('tenantOccupancyChart').getContext('2d');
            var tenantOccupancyChart = new Chart(ctx3, {
                type: 'bar',
                data: {
                    labels: roomNumbers,
                    datasets: [{
                        label: 'Number of Tenants (Occupied)',
                        data: tenantCountsStatus,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var totalTenants = <?php echo json_encode($totalTenants); ?>;

            var ctxTotal = document.getElementById('totalTenantsChart').getContext('2d');
            var totalTenantsChart = new Chart(ctxTotal, {
                type: 'bar',
                data: {
                    labels: ['Total Tenants'],
                    datasets: [{
                        label: 'Number of Tenants',
                        data: [totalTenants],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });


            var months = <?php echo json_encode($months); ?>;
            var tenantCountsByMonth = <?php echo json_encode($tenantCountsByMonth); ?>;

            var ctx = document.getElementById('tenantsByMonthChart').getContext('2d');
            var tenantsByMonthChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months.map(function(month) {
                        // Convert month number to month name
                        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        return monthNames[month - 1];
                    }),
                    datasets: [{
                        label: 'Number of Tenants',
                        data: tenantCountsByMonth,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });



        }

        // Call the function when the data is updated or after the page load
        renderCharts();

    </script>
    
</body>
</html>
