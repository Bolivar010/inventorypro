<?php
include('db_connection.php');

$product_id = $_GET['id'];

// First, delete all sales entries referencing this product
mysqli_query($conn, "DELETE FROM sales WHERE product_id = $product_id");

// Now, delete the product from the products table
mysqli_query($conn, "DELETE FROM products WHERE id = $product_id");

header("Location: manage_products.php"); // Redirect back to the products management page
exit();
?>
