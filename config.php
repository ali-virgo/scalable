<?php
// File: config.php
$host = 'localhost';
$db = 'insta';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    
}
else
  //  echo "Connection Succeful";
?>