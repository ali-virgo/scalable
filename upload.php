<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) die('Unauthorized');

if (isset($_POST['upload'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $caption = $_POST['caption'];
    $file = $_FILES['media'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    move_uploaded_file($file["tmp_name"], $target_file);

    $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_path, title, caption) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $target_file, $title, $caption);
    $stmt->execute();

    header("Location: dashboard.php");
}
?>