<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) die('Unauthorized');

$id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM uploads WHERE id = $id AND user_id = $user_id");
if ($row = $result->fetch_assoc()) {
    $file_path = $row['file_path'];
    if (file_exists($file_path)) {
        unlink($file_path); // delete file
    }
    $conn->query("DELETE FROM uploads WHERE id = $id");
}

header('Location: dashboard.php');
?>
