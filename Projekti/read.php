<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoices</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; 
            height: 100vh;
            text-align: center;
        }
        .container {
            width: 80%;
            max-width: 1200px;
            background-color: #ffffff;
            padding: 30px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 0; 
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #ff5722;
            color: white;
            font-weight: bold;
        }
        td {
            background-color: #fff3e0;
            color: #333;
        }
        tbody tr:nth-child(even) {
            background-color: #ffe0b2;
        }
        tbody tr:hover {
            background-color: #ffcc80;
            cursor: pointer;
        }
        .action-button {
            padding: 8px 15px;
            margin: 5px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }
        .action-button.print {
            background-color: #28a745;
        }
        .action-button.delete {
            background-color:rgb(252, 7, 31); 
        }
        .action-button.delete:hover {
            background-color: #c82333;
        }
        .action-button:hover {
            opacity: 0.8;
        }
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: start;
            margin-bottom: 5px;
            margin-left: -150px; 
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
    <a href="dashboard.php">
        <img src="images/a.jpg" alt="Logo" class="logo"> 
    </a>
</div>
        <h2>Invoices List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $host = 'localhost';
                $username = 'root';
                $password = '';
                $dbname = 'invoice_db';
                $table = 'invoices';

                try {
                    $dsn = "mysql:host=$host;dbname=$dbname";
                    $conn = new PDO($dsn, $username, $password);

                    $sql = "SELECT * FROM $table";
                    $stmt = $conn->query($sql);

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['client_name'] . "</td>";
                        echo "<td>" . $row['amount'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['due_date'] . "</td>";
                        echo "<td>
                                <button class='action-button print' onclick='printInvoice(" . json_encode($row) . ")'>Print</button>
                                <a href='update.php?id=" . $row['id'] . "' class='action-button'>Update</a> 
                                <a href='delete.php?id=" . $row['id'] . "' class='action-button delete'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "ERROR: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function printInvoice(invoice) {
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Invoice</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 0;
                            color: #333;
                            background-color: #f9f9f9;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                        }
                        .invoice-container {
                            width: 100%;
                            max-width: 600px;
                            padding: 20px;
                            background-color: #fff;
                            border: 1px solid #ddd;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                            text-align: center; 
                            margin-bottom: 350px;
                        }
                        .invoice-header {
                            border-bottom: 2px solid #ff5722;
                            margin-bottom: 20px;
                            padding-bottom: 10px;
                        }
                        .invoice-header h1 {
                            margin: 0;
                            color: #ff5722;
                        }
                        .invoice-details {
                            margin: 20px 0;
                            text-align: center; 
                        }
                        .invoice-details p {
                            margin: 5px 0;
                            font-size: 16px;
                        }
                        .invoice-footer {
                            margin-top: 20px;
                            font-size: 14px;
                            color: #888;
                        }
                        .button-print {
                            display: inline-block;
                            margin: 20px auto;
                            padding: 10px 20px;
                            background-color: #ff5722;
                            color: white;
                            font-size: 16px;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                        }
                        .button-print:hover {
                            background-color: #e64a19;
                        }
                    </style>
                </head>
                <body>
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <h1>Invoice Details</h1>
                            <p>Invoice ID: <strong>${invoice.id}</strong></p>
                        </div>
                        <div class="invoice-details">
                            <p><strong>Client Name:</strong> ${invoice.client_name}</p>
                            <p><strong>Amount:</strong> $${invoice.amount}</p>
                            <p><strong>Status:</strong> ${invoice.status}</p>
                            <p><strong>Due Date:</strong> ${invoice.due_date}</p>
                        </div>
                        <button class="button-print" onclick="window.print()">Print</button>
                        <div class="invoice-footer">
                            <p>Thank you for your business!</p>
                            <p>Visit us again!</p>
                        </div>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
</body>
</html>
