<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
 
    <div style="text-align: center; margin: 20px 0;">
        <a href="login.php">
            <img src="images/a.jpg" alt="Logo" style="max-width: 200px; height: auto;">
        </a>
    </div>

    
    <div class="container" style="max-width: 900px; margin-top: 50px;">
        <div class="dashboard-card">
            <h3>Welcome to the Invoice Dashboard, <?php echo htmlspecialchars($username); ?></h3>
          

           
            <div class="company-info" style="margin-bottom: 30px;">
                <h5>About Our Company</h5>
                <p>
                AL is an innovative company that offers simple and efficient solutions for invoice management. We provide an easy-to-use platform that helps businesses create, manage,
                and monitor invoices with ease. Our focus is on efficiency and transparency, ensuring that every client has a quick and seamless process in managing their finances.


                </p>
            </div>
            <p>Manage your invoices easily. Choose an action below:</p>

            <a href="create.php" class="btn btn-success">Create Invoice</a>
            <a href="read.php" class="btn btn-primary">Read Invoices</a>
        </div>
    </div>
</body>
</html>


