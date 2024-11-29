<?php
include('db_connection.php');

// Fetch sales data from the database
$sales = mysqli_query($conn, "SELECT * FROM sales");

echo "<div class='report-container'>";
echo "<h2>Sales Report</h2>";

if (mysqli_num_rows($sales) > 0) {
    while ($sale = mysqli_fetch_assoc($sales)) {
        echo "<div class='sale-entry'>";
        echo "<strong>Sale Date:</strong> " . $sale['sale_date'] . "<br>";
        echo "<strong>Total:</strong> ₱" . number_format($sale['total'], 2) . "<br>";
        echo "</div>";
    }
} else {
    echo "<p>No sales data available.</p>";
}

echo "</div>";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .report-container {
        width: 80%;
        max-width: 900px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: left;
    }

    .report-container h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .sale-entry {
        padding: 15px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fafafa;
    }

    .sale-entry strong {
        color: #007bff;
    }

    .sale-entry:last-child {
        margin-bottom: 0;
    }

    p {
        font-size: 16px;
        color: #555;
    }
</style>
