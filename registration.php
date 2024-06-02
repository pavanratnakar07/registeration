<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
</head>
<body>
    <h2>Student Registration Form</h2>
    <form action="register.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required><br><br>

        <label for="resume">Resume:</label>
        <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
