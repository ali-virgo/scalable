<?php include 'config.php'; session_start(); if (!isset($_SESSION['user_id'])) header('Location: login.php'); ?>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    padding: 20px;
}

form {
    background: white;
    padding: 20px;
    margin-bottom: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
}

input[type="text"],
textarea,
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0 15px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background-color: #0056b3;
}

.media-wrapper {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding: 10px 0;
}

.media-item {
    min-width: 350px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    padding: 15px;
    flex-shrink: 0;
}

.media-item h3 {
    margin-top: 0;
}

.media-item video,
.media-item img {
    max-width: 100%;
    border-radius: 6px;
}

.media-item form {
    margin-top: 10px;
}

.media-item input[type="text"] {
    margin-top: 5px;
}

hr {
    border: none;
    border-top: 2px solid #ddd;
    margin: 40px 0;
}

/* Sign out button style */
.signout-btn {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    margin-bottom: 20px;
    display: block;
    width: 150px;
    text-align: center;
}

.signout-btn:hover {
    background-color: #c82333;
}
</style>

<!-- Sign out button -->
<form action="logout.php" method="POST">
    <button type="submit" class="signout-btn" name="signout">Sign Out</button>
</form>

<!-- Upload form -->
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="caption" placeholder="Caption" required></textarea><br>
    <input type="file" name="media" accept="image/*,video/*" required><br>
    <button type="submit" name="upload">Upload</button>
</form>
<hr>
<div class="media-wrapper">
<?php
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT uploads.*, users.username FROM uploads JOIN users ON uploads.user_id = users.id ORDER BY upload_time DESC");
while ($row = $result->fetch_assoc()) {
    $upload_id = $row['id'];
    echo "<div class='media-item'>";
    echo "<h3>{$row['title']} <small>by <em>{$row['username']}</em></small></h3>";
    echo "<p>{$row['caption']}</p>";
    if (preg_match('/video/', $row['file_path'])) {
        echo "<video src='{$row['file_path']}' width='320' controls></video><br><br>";
    } else {
        echo "<img src='{$row['file_path']}' width='320'><br><br>";
    }

    echo "<p><strong>Uploaded:</strong> {$row['upload_time']}</p>";
    echo "<a href='{$row['file_path']}' download>Download</a>";
    if ($row['user_id'] == $user_id) {
        echo " | <a href='delete.php?id={$upload_id}' onclick=\"return confirm('Delete this post?');\">Delete</a>";
    }

    $likes_result = $conn->query("SELECT COUNT(*) AS total FROM likes WHERE upload_id = $upload_id");
    $likes = $likes_result->fetch_assoc()['total'];
    $liked = $conn->query("SELECT * FROM likes WHERE user_id = $user_id AND upload_id = $upload_id")->num_rows > 0;

    echo "<form action='like.php' method='POST' style='margin:10px 0;'>
            <input type='hidden' name='upload_id' value='$upload_id'>
            <button type='submit' name='action' value='".($liked ? "unlike" : "like")."' >
                ".($liked ? "Unlike" : "Like")." ($likes)
            </button>
          </form>";

    echo "<h4>Comments:</h4>";
    $comments = $conn->query("SELECT c.comment, u.username, c.comment_time FROM comments c JOIN users u ON c.user_id = u.id WHERE c.upload_id = $upload_id ORDER BY c.comment_time DESC");
    while ($comment = $comments->fetch_assoc()) {
        echo "<p><strong>{$comment['username']}:</strong> {$comment['comment']} <em>({$comment['comment_time']})</em></p>";
    }

    echo "<form action='comment.php' method='POST'>
            <input type='hidden' name='upload_id' value='$upload_id'>
            <input type='text' name='comment' placeholder='Add a comment' required>
            <button type='submit'>Post</button>
          </form>";

    echo "</div>";
}
?>
</div>
