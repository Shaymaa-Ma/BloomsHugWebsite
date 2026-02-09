<?php
define("db_SERVER", "localhost");
define("db_USER", "YOUR_DB_USERNAME");   // Replace with your username
define("db_PASSWORD", "YOUR_DB_PASSWORD"); // Replace with your password
define("db_DBNAME", "YOUR_DB_NAME");       // Replace with your DB name

$conn = mysqli_connect(db_SERVER, db_USER, db_PASSWORD, db_DBNAME);

if (!$conn) {   
    echo '<script type="text/javascript"> alert("Error connecting the server: '. mysqli_connect_error() .'") </script>';
} 
?>
