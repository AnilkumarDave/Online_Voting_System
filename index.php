<?php
session_start();
include 'database/db.php';

$error = "";

// When login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Prepare SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $db_password = $user['password'];

        // For plain text password (admin123) use direct comparison
        // For hashed password use password_verify()
        if ($db_password === $password || password_verify($password, $db_password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: pages/vote.php");
            }
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Online Voting System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; padding-top: 80px; }
        form { background: white; padding: 20px; border-radius: 8px; display: inline-block; box-shadow: 0px 0px 10px #ccc; }
        input { margin: 8px; padding: 8px; width: 200px; }
        input[type=submit] { background: #007bff; color: white; border: none; cursor: pointer; width: 220px; }
        input[type=submit]:hover { background: #0056b3; }
        p { color: red; font-weight: bold; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h2>Online Voting System - Login</h2>

    <?php if ($error != ""): ?>
        <p><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

    <p>New user? <a href="pages/register.php">Register here</a></p>
</body>
</html>
