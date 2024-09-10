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
    <title>RESERVATION</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #a9a9a9;
            border-spacing: 10%;
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
        }

        .nav-link {
            color: #fff !important;
        }

        .content {
            padding-top: 100px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>


    <section> 
        <div class="content">
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>landlord</th>
                        <th>Boarding House</th>
                        <th>Address</th>
                        <th>Description</th>
                        <th>Images</th>
                        <th>Documents</th>
                        <th>Status</th>
                        <?php  
                            if (!empty($_SESSION["uname"]) && !empty($_SESSION["role"]) && $_SESSION['role'] == 'admin'){
                                echo '<th>Actions</th>'; 
                            }else{
                                echo '';
                            }
                        ?>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "select * from bhapplication inner join documents inner join description on bhapplication.hname = documents.hname And bhapplication.hname = description.hname";
                        $result = mysqli_query($conn, $query);
                        while ($fetch = mysqli_fetch_assoc($result)) {
                        $id = $fetch['id'];
                        $hname = $fetch['hname'];
                        ?>          
                        <tr>
                            <td><?php echo $fetch['id'] ?></td>
                            <td><?php echo $fetch['owner'] ?></td>
                            <td><?php echo $fetch['hname'] ?></td>
                            <td><?php echo $fetch['haddress'] ?></td>
                            <td><?php echo $fetch['bh_description'] ?></td>
                            <td><img src="../<?php echo $fetch['image'] ?>" width='200px'></td>
                            <td><img src="../<?php echo $fetch['documents'] ?>" width='200px'></td>
                            <td><?php echo $fetch['status'] ?></td>
                                
                            
                            <td>
                                <a href="bhfunction.php?approve=<?php echo $hname;?>"><button class="btn btn-warning">Approve</button></a>
                                <a href="bhfunction.php?reject=<?php echo $hname;?>"><button class="btn btn-danger">Reject</button></a>
                            </td>
                            <?php } ?>
                        </tr>
                </tbody>
            </table>
        </div>

    </section>

    <style>
        .content {
            padding-top: 100px;
            padding-left: 10%;
            padding-right: 10%;
            display: flex;
            justify-content: center;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>