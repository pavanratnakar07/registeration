<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "students");

    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == true) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard
        exit();
    } else {
        echo "Invalid username or password.";
    }

    mysqli_close($conn);
}
?>
