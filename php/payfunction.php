<?php
// Include database connection
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM payments WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $payment = mysqli_fetch_assoc($result);
    $email = $payment['email'];
    $hname = $payment['hname'];
    $price = floatval($payment['price']); // Fetch the room price

    if (!$payment) {
        echo "Payment not found.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_amount = floatval($_POST['payment']);
    $pay_stat = $_POST['pay_stat'];
    $pay_date = !empty($_POST['pay_date']) ? $_POST['pay_date'] : date('Y-m-d H:i:s'); // Automatically set current date/time
    $price = floatval($payment['price']);

    // Calculate the payment status if it's not manually selected
    if ($pay_stat === 'Fully Paid' || $pay_stat === 'Partially Paid') {
        // Validate user override
        if ($pay_stat === 'Fully Paid' && $payment_amount < $price) {
            $pay_stat = 'Partially Paid';
        }
    } else {
        // Automatically calculate pay_stat based on amount
        $pay_stat = $payment_amount >= $price ? 'Fully Paid' : 'Partially Paid';
    }

    // Update the payment record
    $updateQuery = "UPDATE payments SET 
                    payment = $payment_amount, 
                    pay_stat = '$pay_stat', 
                    pay_date = '$pay_date' 
                    WHERE id = $id and email = '$email' and hname = '$hname'";

    if (mysqli_query($conn, $updateQuery)) {
        header('Location: ../payment.php');
        exit;
    } else {
        echo "Error updating payment: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
            padding: 10px;
        }

        .btn-primary {
            background-color: #ffc107;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #bf9310;
            transform: scale(1.05);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Payment</h1>
    <form method="POST">
        <!-- Payment Amount -->
        <div class="mb-3">
            <label for="payment" class="form-label">Payment Amount:</label>
            <input 
                type="number" 
                class="form-control" 
                id="payment" 
                name="payment" 
                step="0.01" 
                max="<?php echo $price; ?>" 
                value="<?php echo $payment['payment']; ?>" 
                required
                oninput="updatePaymentStatus()">
        </div>

        <!-- Payment Status -->
        <div class="mb-3">
            <label for="pay_stat" class="form-label">Payment Status:</label>
            <input 
                type="text" 
                class="form-control" 
                id="pay_stat" 
                name="pay_stat" 
                value="<?php echo $payment['pay_stat']; ?>" 
                readonly>
        </div>

        <!-- Payment Date -->
        <div class="mb-3">
            <label for="pay_date" class="form-label">Payment Date:</label>
            <input 
                type="datetime-local" 
                class="form-control" 
                id="pay_date" 
                name="pay_date" 
                value="" readonly>
        </div>

        <script>
            const roomPrice = <?php echo $price; ?>; // Get the room price from PHP

            function updatePaymentStatus() {
                const paymentInput = document.getElementById('payment');
                const statusInput = document.getElementById('pay_stat');

                let payment = parseFloat(paymentInput.value);

                // Ensure payment does not exceed the room price
                if (payment > roomPrice) {
                    paymentInput.value = roomPrice;
                    payment = roomPrice;
                }

                // Update payment status based on the input amount
                if (payment === 0) {
                    statusInput.value = 'Not Paid Yet';
                } else if (payment > 0 && payment < roomPrice) {
                    statusInput.value = 'Partially Paid';
                } else if (payment === roomPrice) {
                    statusInput.value = 'Fully Paid';
                }
            }
        </script>

        <script>
            function setPhilippinesDateTime() {
                // Get the current date and time in Asia/Manila time zone
                const now = new Date();
                const options = { timeZone: 'Asia/Manila', hour12: false, year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
                const formatter = new Intl.DateTimeFormat('en-US', options);

                const parts = formatter.formatToParts(now);

                // Reconstruct the date-time in "YYYY-MM-DDTHH:MM" format
                const year = parts.find((part) => part.type === 'year').value;
                const month = parts.find((part) => part.type === 'month').value;
                const day = parts.find((part) => part.type === 'day').value;
                const hour = parts.find((part) => part.type === 'hour').value;
                const minute = parts.find((part) => part.type === 'minute').value;

                const formattedDateTime = `${year}-${month}-${day}T${hour}:${minute}`;

                // Set the value of the input field
                document.getElementById('pay_date').value = formattedDateTime;
            }

            // Call the function when the page loads
            window.onload = setPhilippinesDateTime;
        </script>


        <!-- Buttons -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
            <a href="../payment.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
