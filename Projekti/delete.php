<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Invoice</title>
</head>
<body>
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

            $sql = "DELETE FROM $table WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);

           
            header("Location: read.php?delete=success");
            exit;
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
