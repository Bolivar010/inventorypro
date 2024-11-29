<?php
session_start();
include('db_connection.php');

// Check if user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

   
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .welcome-message h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .dashboard-links {
            margin-top: 30px;
        }

        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .logout {
            background-color: #e74c3c;
        }

        .logout:hover {
            background-color: #c0392b;
        }

        @media (max-width: 600px) {
            .welcome-message h1 {
                font-size: 24px;
            }

            .btn {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="welcome-message">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
        </div>

        <div class="dashboard-links">
            <?php if ($user['role'] == 'manager') { ?>
                <a href="manage_products.php" class="btn">Manage Products</a>
                <a href="generate_reports.php" class="btn">Generate Reports</a>
            <?php } ?>

            <a href="manage_sales.php" class="btn">Manage Sales</a>
            <a href="logout.php" class="btn logout">Logout</a>
        </div>
    </div>

</body>
</html>
