<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
        .success {
            color: green;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update Invoice</h2>
        <?php
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'invoice_db';
        $table = 'invoices';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $dsn = "mysql:host=$host;dbname=$dbname";
                $conn = new PDO($dsn, $username, $password);

                $sql = "SELECT * FROM $table WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([':id' => $id]);

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $client_name = $row['client_name'];
                $amount = $row['amount'];
                $status = $row['status'];
                $due_date = $row['due_date'];
            } catch (PDOException $e) {
                echo "<p class='error'>ERROR: " . $e->getMessage() . "</p>";
            }
        }

        if (isset($_POST['update'])) {
            $client_name = htmlspecialchars(trim($_POST['client_name']));
            $amount = htmlspecialchars(trim($_POST['amount']));
            $status = htmlspecialchars(trim($_POST['status']));
            $due_date = htmlspecialchars(trim($_POST['due_date']));

            if (empty($client_name) || empty($amount) || empty($status) || empty($due_date)) {
                echo "<p class='error'>All fields are required.</p>";
            } else {
                try {
                    $dsn = "mysql:host=$host;dbname=$dbname";
                    $conn = new PDO($dsn, $username, $password);

                    $sql = "UPDATE $table SET client_name = :client_name, amount = :amount, status = :status, due_date = :due_date WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([':client_name' => $client_name, ':amount' => $amount, ':status' => $status, ':due_date' => $due_date, ':id' => $id]);

                    echo "<p class='success'>Invoice updated successfully!</p>";
                    header("refresh:2;url=read.php"); 
                    exit;
                } catch (PDOException $e) {
                    echo "<p class='error'>ERROR: " . $e->getMessage() . "</p>";
                }
            }
        }
        ?>

        <form action="" method="post">
            <label for="client_name">Client Name</label>
            <input type="text" id="client_name" name="client_name" value="<?php echo htmlspecialchars($client_name); ?>" required>

            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" required>

            <label for="status">Status</label>
            <select name="status" required>
                <option value="paid" <?php echo ($status == 'paid' ? 'selected' : ''); ?>>Paid</option>
                <option value="unpaid" <?php echo ($status == 'unpaid' ? 'selected' : ''); ?>>Unpaid</option>
            </select>

            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($due_date); ?>" required>

            <input type="submit" name="update" value="Update Invoice">
        </form>
    </div>
</body>
</html>
