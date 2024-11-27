<?php
session_start(); // Start the session

// Example: Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form if it's submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    // SQL query to check if user exists with the given email
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($user_password, $hashed_password)) {
            // Store user ID and username in session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            echo "<script>window.location.href='shop.php';</script>"; // Redirect to shop page
            exit(); // End script to prevent further execution
        } else {
            $error_message = "Invalid password!";
        }
    } else {
        $error_message = "No user found with that email!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <script defer src="js/login.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <div class="login-container">
        <h2>Log in</h2>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePassword()"><i class="fas fa-eye"></i></span>
            </div>
            <input type="submit" value="Log in">
            <p>Don't have an account? <a href="signup.php" style="text-decoration: none;">Sign up</a></p>

            <?php
            // Display error message if there is an issue with login
            if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            }
            ?>
        </form>
    </div>
</body>
</html>
