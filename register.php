<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('images/bgg.png');
            background-size: cover;
            background-position: center;
            position: relative;
        }
         /* Overlay for better readability */
        body::before {
            content: "";
            position: absolute;
            top:0; left:0; right:0; bottom:0;
            background: rgba(180, 180, 180, 0.8);
            z-index: 0;
        }
       .container {
            position: relative;
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 350px;
            z-index: 1;
        }
        h2 {
            text-align: center;
            color: #d6336c;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background: #d6336c;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 25px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        input[type="submit"]:hover {
            background: #b52c5a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register_action.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>
