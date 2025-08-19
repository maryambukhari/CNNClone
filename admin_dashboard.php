<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_article'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category_id = $_POST['category_id'];
    $thumbnail = isset($_POST['thumbnail']) ? $_POST['thumbnail'] : 'https://via.placeholder.com/300x200?text=News+Thumbnail';

    $stmt = $conn->prepare("INSERT INTO articles (title, content, category_id, thumbnail) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $title, $content, $category_id, $thumbnail);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input, textarea, select { width: 100%; padding: 8px; margin-bottom: 10px; }
        input[type="submit"] { background-color: #0078d4; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #005bb5; }
        a { color: #0078d4; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <p><a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a></p>
        <h3>Add New Article</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" id="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select name="category_id" id="category_id" required>
                    <?php
                    $categories = $conn->query("SELECT * FROM categories");
                    while ($category = $categories->fetch_assoc()) {
                        echo "<option value='{$category['id']}'>{$category['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail URL (optional):</label>
                <input type="text" name="thumbnail" id="thumbnail">
            </div>
            <input type="submit" name="add_article" value="Add Article">
        </form>
    </div>
</body>
</html>
