<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
$upload_id = (int)$_POST['upload_id'];
$action = $_POST['action'];

if ($action === 'like') {
    $conn->query("INSERT IGNORE INTO likes (user_id, upload_id) VALUES ($user_id, $upload_id)");
} elseif ($action === 'unlike') {
    $conn->query("DELETE FROM likes WHERE user_id = $user_id AND upload_id = $upload_id");
}
header("Location: dashboard.php");
?>
