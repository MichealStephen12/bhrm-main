<?php
include('php/connection.php'); // Database connection file

$hname = $_SESSION['hname'];

// Fetch total tenants per `hname`, counting unique emails
$totalTenantsQuery = "
    SELECT COUNT(DISTINCT email) AS total_tenants 
    FROM reservation 
    WHERE hname = '$hname'";
$totalTenantsResult = mysqli_query($conn, $totalTenantsQuery);
$totalTenants = mysqli_fetch_assoc($totalTenantsResult)['total_tenants'];

// Fetch total male and female tenants per `hname`, counting unique emails
$genderCountQuery = "
    SELECT 
        COUNT(DISTINCT CASE WHEN gender = 'Male' THEN email END) AS male_count, 
        COUNT(DISTINCT CASE WHEN gender = 'Female' THEN email END) AS female_count 
    FROM reservation 
    WHERE hname = '$hname'";
$genderCountResult = mysqli_query($conn, $genderCountQuery);
$genderCount = mysqli_fetch_assoc($genderCountResult);

$maleCount = $genderCount['male_count'];
$femaleCount = $genderCount['female_count'];

// Fetch tenant details for table (unique emails only)
$tenantDetailsQuery = "
    SELECT DISTINCT email, fname, lname, gender, tenant_status, school, image 
    FROM reservation 
    WHERE hname = '$hname'
    ORDER BY id DESC";
$tenantDetailsResult = mysqli_query($conn, $tenantDetailsQuery);

// Fetch the total number of students and the total number of students from CKCM
$countQuery = "
    SELECT 
        COUNT(DISTINCT CASE WHEN tenant_status = 'Student' THEN email END) AS total_students,
        COUNT(DISTINCT CASE WHEN tenant_status = 'Student' AND school = 'CKCM' THEN email END) AS total_ckcm_students
    FROM reservation 
    WHERE hname = '$hname'";
$countResult = mysqli_query($conn, $countQuery);
$countFetch = mysqli_fetch_assoc($countResult);

$totalStudents = $countFetch['total_students'];
$totalCkcmStudents = $countFetch['total_ckcm_students'];


$tenantDetailsQuery = "
    SELECT email, 
           MAX(fname) AS fname, 
           MAX(lname) AS lname, 
           MAX(gender) AS gender, 
           MAX(tenant_status) AS tenant_status, 
           MAX(school) AS school, 
           MAX(image) AS image 
    FROM reservation 
    WHERE hname = '$hname'
    GROUP BY email
    ORDER BY MAX(id) DESC";
$tenantDetailsResult = mysqli_query($conn, $tenantDetailsQuery);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenants Report - <?php echo $hname; ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .card h5 {
            color: #333;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #c19206;
        }
        table.dataTable {
            width: 100%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'navigationbar.php'; ?>

    <div class="container my-4">
        <h1 class="text-center mb-4">Tenant Reports for <?php echo $hname; ?></h1>

        <!-- Summary Section -->
        <div class="summary">
            <div class="card">
                <h5>Total Tenants</h5>
                <p><?php echo $totalTenants; ?></p>
            </div>
            <div class="card">
                <h5>Total Male Tenants</h5>
                <p><?php echo $maleCount; ?></p>
            </div>
            <div class="card">
                <h5>Total Female Tenants</h5>
                <p><?php echo $femaleCount; ?></p>
            </div>
            <div class="card">
                <h5>Total Students</h5>
                <p><?php echo $totalStudents; ?></p>
            </div>
            <div class="card">
                <h5>Students from CKCM</h5>
                <p><?php echo $totalCkcmStudents; ?></p>
            </div>
        </div>

        <!-- DataTable Section -->
        <div class="mt-5">
            <h2 class="mb-3">Tenant Details</h2>
            <div class="table-responsive">
                <table id="tenantTable" class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>School</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($tenant = mysqli_fetch_assoc($tenantDetailsResult)) { ?>
                            <tr>
                                <td>
                                    <img src="/bhrm-main/<?php echo $tenant['image'] ?? 'default.png'; ?>" 
                                        width="50" height="50" 
                                        class="rounded-circle" 
                                        alt="Profile Picture">
                                </td>
                                <td><?php echo htmlspecialchars($tenant['fname']); ?></td>
                                <td><?php echo htmlspecialchars($tenant['lname']); ?></td>
                                <td><?php echo htmlspecialchars($tenant['gender']); ?></td>
                                <td><?php echo htmlspecialchars($tenant['email']); ?></td>
                                <td><?php echo htmlspecialchars($tenant['tenant_status'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($tenant['school'] ?? 'N/A'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tenantTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true
            });
        });
    </script>
</body>
</html>
