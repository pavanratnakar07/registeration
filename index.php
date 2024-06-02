<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .container label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        .container input[type="text"],
        .container input[type="email"],
        .container input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .container input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .container input[type="submit"]:hover {
            background-color: #218838;
        }
        /* Style for the login link */
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #666;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Student Registration</h2>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>
        
        <label for="image">Upload Image:</label>
        <input type="file" name="image" id="image" required><br><br>
        
        <label for="resume">Upload Resume:</label>
        <input type="file" name="resume" id="resume" required><br><br>
        
        <input type="submit" name="submit" value="Register">
    </form>
    <!-- Adjusted Login link -->
    <div class="login-link">
            <a href="admin_login.php">Login as Admin</a>
        </div>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // File upload handling
    $image = $_FILES['image'];
    $resume = $_FILES['resume'];

    $imagePath = 'uploads/images/' . basename($image['name']);
    $resumePath = 'uploads/resumes/' . basename($resume['name']);

    // Create directories if they do not exist
    if (!file_exists('uploads/images')) {
        mkdir('uploads/images', 0777, true);
    }
    if (!file_exists('uploads/resumes')) {
        mkdir('uploads/resumes', 0777, true);
    }

    // Move uploaded files to their respective directories
    if (move_uploaded_file($image['tmp_name'], $imagePath) && move_uploaded_file($resume['tmp_name'], $resumePath)) {
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'students');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO students (name, email, image, resume) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssss", $name, $email, $imagePath, $resumePath);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Failed to upload files.";
    }
}
?>
