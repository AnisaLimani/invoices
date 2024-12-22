<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9ecef; 
            font-family: 'Arial', sans-serif;
            color: #333; 
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 50px auto;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-10px);
            opacity: 0.95;
        }

        .form-container h2 {
            text-align: center;
            font-size: 1.5rem;
            color:rgb(16, 19, 22); 
            margin-bottom: 30px;
        }

        .form-container label {
            font-weight: 600;
            font-size: 1rem;
            color: #555;
        }

        .form-container input,
        .form-container select {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 1rem;
            width: 100%;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #28a745; 
            outline: none;
            box-shadow: 0 0 6px rgba(40, 167, 69, 0.5);
        }

        
        .form-container .btn-primary {
            background-color:rgb(132, 182, 206); 
            border-color:rgb(177, 197, 201);
            padding: 8px 14px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
            border-radius: 8px;
            width: 100%;
        }

       
        .form-container .btn-primary:hover {
            background-color:rgb(137, 188, 196);
            border-color:rgb(177, 197, 201);
        }

       
        .form-container .btn-secondary {
            background-color:rgb(150, 180, 194); 
            border-color:rgb(177, 197, 201);
            padding: 8px 14px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
            border-radius: 8px;
            color: #fff;
        }

       
        .form-container .btn-secondary:hover {
            background-color:rgb(169, 190, 196);
            border-color:rgb(177, 197, 201);
        }

        .btn-row {
            display: flex;
            justify-content: center; 
            gap: 10px; 
            margin-top: 20px;
        }

        .alert-success {
            font-size: 1.1rem;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            margin-top: 20px;
            display: none;
            animation: fadeIn 2s;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: start;
            margin-bottom: 20px;
            margin-left: -100px; 
        }

        .logo-container img {
            max-width: 125px;
            margin-right: 20px; 
        }

        .logo-container h1 {
            color: #007bff;
            font-size: 1.8rem;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="images/a.jpg" alt="Logo">
        </div>

        <div class="form-container">
            <h2>Create Invoice</h2>
            <form action="create.php" method="post">
                <div class="form-group">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter Client Name" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" class="form-control" id="due_date" name="due_date" required>
                </div>

                <button type="submit" class="btn btn-primary" name="create">Create Invoice</button>

                <div class="btn-row">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='read.php'">View Invoices</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='dashboard.php'">Go to Dashboard</button>
                </div>
            </form>

            <div id="successMessage" class="alert-success">Invoice Created Successfully</div>
        </div>
    </div>

    <?php
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'invoice_db'; 
    $table = 'invoices';  

    if (isset($_POST['create'])) {
        $client_name = $_POST['client_name'];
        $amount = $_POST['amount'];
        $status = $_POST['status'];
        $due_date = $_POST['due_date'];

        if (empty($client_name) || empty($amount) || empty($status) || empty($due_date)) {
            echo "<div class='alert-error'>Please fill all the inputs</div>";
        } else {
            try {
                $dsn = "mysql:host=$host; dbname=$dbname";
                $conn = new PDO($dsn, $username, $password);
                $sql = "INSERT INTO $table (client_name, amount, status, due_date) 
                        VALUES (:client_name, :amount, :status, :due_date)" ;

                $stmt = $conn->prepare($sql);
                $stmt->execute([ 
                    ':client_name' => $client_name,
                    ':amount' => $amount,
                    ':status' => $status,
                    ':due_date' => $due_date
                ]);
                
                echo "<script>
                    document.getElementById('successMessage').style.display = 'block';
                    setTimeout(function() {
                        document.getElementById('successMessage').style.display = 'none';
                    }, 3000);
                </script>";

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    ?>
</body>
</html>



