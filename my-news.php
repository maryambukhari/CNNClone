<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My News</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 1200px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #333; }
        .article-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .article-item { border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
        .article-item img { width: 100%; height: auto; }
        .article-item h3 { margin: 10px 0; color: #0078d4; }
        .article-item p { color: #666; }
        a { color: #0078d4; text-decoration: none; }
        a:hover { text-decoration: underline; }
        @media (max-width: 600px) { .article-list { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>My News</h2>
        <div class="article-list">
            <?php
            $result = $conn->query("SELECT a.*, c.name AS category_name FROM articles a JOIN categories c ON a.category_id = c.id WHERE a.author_id = $user_id ORDER BY published_at DESC");
            while ($row = $result->fetch_assoc()) {
                echo "<div class='article-item'>";
                echo "<img src='{$row['thumbnail']}' alt='{$row['title']}'>";
                echo "<h3><a href='javascript:void(0)' onclick=\"window.location.href='article.php?id={$row['id']}'\">{$row['title']}</a></h3>";
                echo "<p>{$row['content']}</p>";
                echo "<p><small>Category: {$row['category_name']} | Published: " . date('F j, Y', strtotime($row['published_at'])) . "</small></p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>
