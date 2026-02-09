<?php
session_start();
require 'config.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$username = trim($username);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Result</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f3f4f6;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 400px;
            text-align: center;
        }
        h2 {
            color: #2c3e50;
        }
        a {
            text-decoration: none;
            color: #ffffff;
            background-color: #28a745;
            padding: 10px 20px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 20px;
        }
        a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (empty($username) || empty($password)) {
            echo "<h2>Please enter username and password.</h2>";
        } else {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                echo "<h2>Invalid username or password.</h2>";
            } else {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['username'] = $username;
                    echo "<h2>Login successful! Welcome, " . htmlspecialchars($username) . ".</h2>";
                    echo '<a href="index.html">Go to homepage</a>';
                } else {
                    echo "<h2>Invalid username or password.</h2>";
                }
            }
            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
