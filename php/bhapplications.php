<?php
include 'connection.php';

if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"])) {
    echo '';
}else{
    header('location: ./index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        h2 {
            color: #495057;
            font-weight: 700;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card .btn {
            font-size: 0.85rem;
        }

        .badge {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <?php include '../navadmin.php'; ?>

    <div class="container my-5">
        <!-- Pending Section -->
        <h2 class="text-center mb-4">Pending Applications</h2>
        <div class="row gy-4">
            <?php 
            $query = "SELECT DISTINCT bhapplication.hname, bhapplication.*, documents.*, description.*
                      FROM bhapplication 
                      INNER JOIN documents ON bhapplication.hname = documents.hname
                      INNER JOIN description ON bhapplication.hname = description.hname 
                      WHERE bhapplication.status = 'PENDING' 
                      ORDER BY bhapplication.id DESC";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)): 
            ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="../<?php echo $fetch['image']; ?>" class="card-img-top" alt="Boarding House">
                        <div class="card-body">
                            <h5 class="card-title">Boarding House: <?php echo $fetch['hname']; ?></h5>
                            <p class="card-text">Address: <?php echo $fetch['haddress']; ?></p>
                            <p class="card-text">Description: <?php echo $fetch['bh_description']; ?></p>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </div>
                        <?php if ($_SESSION["role"] == "admin"): ?>
                            <div class="card-footer text-center">
                                <a href="bhfunction.php?approve=<?php echo $fetch['hname']; ?>" class="btn btn-success">Approve</a>
                                <a href="bhfunction.php?reject=<?php echo $fetch['hname']; ?>" class="btn btn-danger">Reject</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Approved Section -->
        <h2 class="text-center my-4">Approved Applications</h2>
        <div class="row gy-4">
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
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="../<?php echo $fetch['image']; ?>" class="card-img-top" alt="Boarding House">
                        <div class="card-body">
                            <h5 class="card-title">Boarding House: <?php echo $fetch['hname']; ?></h5>
                            <p class="card-text">Address: <?php echo $fetch['haddress']; ?></p>
                            <p class="card-text">Description: <?php echo $fetch['bh_description']; ?></p>
                            <p class="card-text">Documents:</p>
                            <img src="../<?php echo $fetch['documents']; ?>" class="card-img-top" alt="Boarding House">
                            <span class="badge bg-success">Approved</span>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-secondary" disabled>Approved</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Rejected Section -->
        <h2 class="text-center my-4">Rejected Applications</h2>
        <div class="row gy-4">
            <?php 
            $query = "SELECT DISTINCT bhapplication.hname, bhapplication.*, documents.*, description.*
                      FROM bhapplication 
                      INNER JOIN documents ON bhapplication.hname = documents.hname
                      INNER JOIN description ON bhapplication.hname = description.hname 
                      WHERE bhapplication.status = 'REJECTED' 
                      ORDER BY bhapplication.id DESC";
            $result = mysqli_query($conn, $query);
            while ($fetch = mysqli_fetch_assoc($result)): 
            ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="../<?php echo $fetch['image']; ?>" class="card-img-top" alt="Boarding House">
                        <div class="card-body">
                            <h5 class="card-title">Boarding House: <?php echo $fetch['hname']; ?></h5>
                            <p class="card-text">Address: <?php echo $fetch['haddress']; ?></p>
                            <p class="card-text">Description: <?php echo $fetch['bh_description']; ?></p>
                            <span class="badge bg-danger">Rejected</span>
                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-secondary" disabled>Rejected</button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
