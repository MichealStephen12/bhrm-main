<?php
include 'php/connection.php';

if (empty($_SESSION["uname"]) || empty($_SESSION["role"])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include 'navadmin.php'; ?>

    
    <!-- Approved Section (Similar to Pending Section) -->
    <h2 class="text-center my-4">Approved Applications</h2>
    <table id="approvedApplicationsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Boarding House Name</th>
                <th>Address</th>
                <th>Description</th>
                <th>Documents</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $query = "SELECT DISTINCT bhapplication.hname, bhapplication.*, documents.*, description.* 
                        FROM bhapplication 
                        INNER JOIN documents ON bhapplication.hname = documents.hname
                        INNER JOIN description ON bhapplication.hname = description.hname 
                        WHERE bhapplication.status = 'APPROVED' 
                        ORDER BY bhapplication.id DESC";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)): 
            ?>
                <tr>
                    <td><?php echo $fetch['hname']; ?></td>
                    <td><?php echo $fetch['haddress']; ?></td>
                    <td><?php echo $fetch['bh_description']; ?></td>
                    <td>
                        <a href="../<?php echo $fetch['bar_clear']; ?>" class="btn btn-link" target="_blank">Bar Clearance</a><br>
                        <a href="../<?php echo $fetch['bus_per']; ?>" class="btn btn-link" target="_blank">Business Permit</a>
                    </td>
                    <td><span class="badge bg-success">Approved</span></td>
                    <td><button class="btn btn-secondary" disabled>Approved</button></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>