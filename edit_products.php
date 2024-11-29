<?php
include('db_connection.php');

// Fetch product ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Query to fetch product details
    $product_query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $product_query);
    
    // Check if the product exists
    if (mysqli_num_rows($result) == 0) {
        echo "Product not found.";
        exit;
    }
    
    // Get the product details
    $product = mysqli_fetch_assoc($result);
    
    // Default values from the database
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $quantity = $product['quantity'];
} else {
    echo "Product ID is missing or invalid.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    
    // Update product query
    $update_query = "UPDATE products SET name='$name', description='$description', price='$price', quantity='$quantity' WHERE id=$product_id";
    
    if (mysqli_query($conn, $update_query)) {
        // Redirect to manage products page after update
        header('Location: manage_products.php');
        exit;
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="POST" action="edit_products.php?id=<?php echo $product_id; ?>">
            <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            <textarea name="description" required><?php echo htmlspecialchars($description); ?></textarea>
            <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($price); ?>" required>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>
            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
