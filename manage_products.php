<?php
// manage_products.php
include('db_connection.php');

// Handle adding a product
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $query = "INSERT INTO products (name, description, price, quantity) VALUES ('$name', '$description', '$price', '$quantity')";
    mysqli_query($conn, $query);
}

// Fetch all products
$products = mysqli_query($conn, "SELECT * FROM products");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #444;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }
        form input, form textarea, form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        form button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        form button:hover {
            background-color: #4cae4c;
        }
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .product-item {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-item p {
            margin: 0;
        }
        .product-actions a {
            text-decoration: none;
            color: #007bff;
            margin-right: 10px;
            transition: color 0.3s ease;
        }
        .product-actions a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Products</h1>
        <!-- Product Form -->
        <form method="POST" action="manage_products.php">
            <input type="text" name="name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="number" name="quantity" placeholder="Quantity" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <h2>Products List</h2>
        <div class="product-list">
            <?php if (mysqli_num_rows($products) > 0) { ?>
                <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                    <div class="product-item">
                        <p>
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                            ₱<?php echo htmlspecialchars($product['price']); ?> - 
                            <?php echo htmlspecialchars($product['quantity']); ?> available
                        </p>
                        <div class="product-actions">
    <a href="edit_products.php?id=<?php echo $product['id']; ?>">Edit</a>
    <a href="delete_products.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
</div>
 </div>
  <?php } ?>
  <?php } else { ?> 
 <p>No products found.</p>
<?php } ?>
 </div>
     </div>
</body>
</html>
