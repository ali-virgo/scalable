<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
$upload_id = (int)$_POST['upload_id'];
$comment = $conn->real_escape_string($_POST['comment']);

$conn->query("INSERT INTO comments (user_id, upload_id, comment) VALUES ($user_id, $upload_id, '$comment')");
header("Location: dashboard.php");
?>
