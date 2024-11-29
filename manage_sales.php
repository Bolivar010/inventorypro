<?php
include('db_connection.php');

// Handle sale submission
if (isset($_POST['add_sale'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customer_name = $_POST['customer_name'];

    // Get product details
    $product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id"));
    $total = $product['price'] * $quantity;

    // Insert sale record
    mysqli_query($conn, "INSERT INTO sales (product_id, quantity, total, customer_name) VALUES ($product_id, $quantity, $total, '$customer_name')");

    // Update product quantity
    mysqli_query($conn, "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id");
}

// Fetch products for the dropdown
$products = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        select, input {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: #ff4d4d;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Manage Sales</h2>

        <?php if (isset($_POST['add_sale']) && mysqli_affected_rows($conn) > 0): ?>
            <p class="success">Sale recorded successfully!</p>
        <?php endif; ?>

        <!-- Sale Record Form -->
        <form method="POST" action="manage_sales.php">
            <select name="product_id" required>
                <option value="">Select Product</option>
                <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                    <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                <?php } ?>
            </select>
            <input type="number" name="quantity" placeholder="Quantity" required min="1">
            <input type="text" name="customer_name" placeholder="Customer Name">
            <button type="submit" name="add_sale">Record Sale</button>
        </form>
    </div>

</body>
</html>
