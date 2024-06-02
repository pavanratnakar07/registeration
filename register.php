<?php
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // File uploads
    $profilePhoto = $_FILES['profile_photo'];
    $resume = $_FILES['resume'];

    $uploadDir = 'uploads/';
    $profilePhotoPath = $uploadDir . basename($profilePhoto['name']);
    $resumePath = $uploadDir . basename($resume['name']);

    // Create upload directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move uploaded files to designated directory
    if (move_uploaded_file($profilePhoto['tmp_name'], $profilePhotoPath) && move_uploaded_file($resume['tmp_name'], $resumePath)) {
        // Database connection details
        $servername = "localhost";
        $username = "root"; // Replace with your MySQL username
        $password = ""; // Replace with your MySQL password
        $dbname = "student"; // Replace with your MySQL database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO students (name, email, password, profile_photo, resume) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $password, $profilePhotoPath, $resumePath);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        echo "File upload failed.";
    }
}
?>
