<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            background-color: black;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .signup-form {
            text-align: left;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            font-family: Arial, sans-serif;
        }
        .signup-form input {
            display: block;
            margin: 10px 0;
            width: 100%;
            height: 25px;
            padding: 5px;
            font-size: 1em;
        }
        .signup-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 20px;
            width: 100%;
        }
        .signup-form label {
            display: block;
            margin: 10px 0;
            color: black;
            line-height: 1.5em;
        }
    </style>
</head>
<body>
    <div class="signup-form">
        <h2 style="color: black; text-align: center;">Sign Up</h2>
        <form action="" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <label for="contact">Contact Number</label>
            <input type="tel" id="contact" name="contact" pattern="[0-9]{11}" required>
            <button type="submit">Sign Up</button>
        </form>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "myshop"; // Replace with your actual database name

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $contact = $_POST['contact'];

            $sql = "INSERT INTO users (username, email, password, contact) VALUES ('$username', '$email', '$password', '$contact')";

            if ($conn->query($sql) === TRUE) {
                echo "Account created successfully. <a href='login.php'>Login</a>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
