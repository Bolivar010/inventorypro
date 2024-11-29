<?php
session_start();
include('db_connection.php');

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Check role: use dropdown value unless "Other" is selected, then use custom_role
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    if ($role === 'custom') {
        $custom_role = mysqli_real_escape_string($conn, $_POST['custom_role']);
        if (!empty($custom_role)) {
            $role = $custom_role;
        } else {
            $error = "Please specify your custom role!";
        }
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username already exists
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $error = "Username already exists!";
        } else {
            // Insert new user into the database
            $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
            if (mysqli_query($conn, $insert_query)) {
                // Redirect to login page after successful registration
                header('Location: login.php?success=1');
                exit;
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container styles */
        .register-container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Form styling */
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .error, .success {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            color: #ff4d4d;
            background-color: #ffe6e6;
            border: 1px solid #ff4d4d;
        }

        .success {
            color: #4CAF50;
            background-color: #e6ffe6;
            border: 1px solid #4CAF50;
        }

        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>
            <div class="form-group">
    <label for="role">Select Role</label>
    <select id="role" name="role" onchange="toggleCustomRoleInput(this)" required>
        <option value="">Role</option>
        <option value="employee">Employee</option>
        <option value="manager">Manager</option>
        <option value="custom">Other (Enter your role below)</option>
    </select>
</div>

<div class="form-group" id="customRoleGroup" style="display: none;">
    <label for="custom_role">Enter Your Role</label>
    <input type="text" id="custom_role" name="custom_role">
</div>

<button type="submit" name="register" class="btn">Register</button>

<script>
    function toggleCustomRoleInput(selectElement) {
        const customRoleGroup = document.getElementById('customRoleGroup');
        if (selectElement.value === 'custom') {
            customRoleGroup.style.display = 'block';
        } else {
            customRoleGroup.style.display = 'none';
            document.getElementById('custom_role').value = ''; // Clear the custom role field
        }
    }
</script>


        </form> 
    </div>
</body>
</html>
