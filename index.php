<?php
session_start();
include 'db.php';

// Enable error display for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNN Clone</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #e0f7fa, #fff);
            color: #333;
        }
        .header {
            background: linear-gradient(90deg, #003087, #005bb5);
            color: #fff;
            padding: 15px 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .nav {
            background-color: #fff;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: center;
            gap: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .nav a {
            color: #005bb5;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 15px;
            transition: all 0.3s ease;
        }
        .nav a:hover {
            color: #e63946;
            background-color: #f1f1f1;
            border-radius: 5px;
        }
        .featured {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .featured h2 {
            color: #e63946;
            border-bottom: 2px solid #e63946;
            padding-bottom: 5px;
            font-size: 1.8em;
        }
        .featured-item {
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .featured-item:hover {
            transform: translateY(-5px);
        }
        .featured-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .featured-item h3 {
            margin: 10px 0;
            color: #1d3557;
            font-size: 1.3em;
        }
        .featured-item p {
            color: #457b9d;
            line-height: 1.6;
        }
        .featured-item a {
            color: #e63946;
            text-decoration: none;
        }
        .featured-item a:hover {
            text-decoration: underline;
        }
        .categories {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .categories h2 {
            color: #1d3557;
            border-bottom: 2px solid #1d3557;
            padding-bottom: 5px;
            font-size: 1.8em;
        }
        .category-list {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 15px;
        }
        .category-item {
            background: linear-gradient(135deg, #f1faee, #a8dadc);
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px;
            width: 200px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .category-item:hover {
            transform: scale(1.05);
        }
        .category-item a {
            color: #1d3557;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
        }
        .category-item a:hover {
            color: #e63946;
        }
        @media (max-width: 600px) {
            .nav { flex-direction: column; align-items: center; }
            .nav a { margin: 5px 0; }
            .category-list { flex-direction: column; align-items: center; }
            .category-item { width: 80%; }
            .featured-item { margin-bottom: 15px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CNN Clone</h1>
    </div>
    <div class="nav">
        <a href="javascript:void(0)" onclick="window.location.href='index.php'">Home</a>
        <?php
        $categories = $conn->query("SELECT * FROM categories");
        if ($categories) {
            while ($category = $categories->fetch_assoc()) {
                echo "<a href='javascript:void(0)' onclick=\"window.location.href='category.php?id={$category['id']}'\">{$category['name']}</a>";
            }
        } else {
            echo "<a href='javascript:void(0)' onclick=\"alert('Error loading categories: " . $conn->error . "')\">Categories</a>";
        }
        ?>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="javascript:void(0)" onclick="window.location.href='admin.php'">Admin</a>
            <a href="javascript:void(0)" onclick="window.location.href='logout.php'">Logout</a>
        <?php else: ?>
            <a href="javascript:void(0)" onclick="window.location.href='login.php'">Login</a>
            <a href="javascript:void(0)" onclick="window.location.href='signup.php'">Signup</a>
        <?php endif; ?>
    </div>
    <div class="featured">
        <h2>Breaking News</h2>
        <?php
        $result = $conn->query("SELECT * FROM articles ORDER BY published_at DESC LIMIT 3");
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='featured-item'>";
                echo "<img src='{$row['thumbnail']}' alt='{$row['title']}'>";
                echo "<h3><a href='javascript:void(0)' onclick=\"window.location.href='article.php?id={$row['id']}'\">{$row['title']}</a></h3>";
                echo "<p>{$row['content']}</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Error loading news: " . $conn->error . "</p>";
        }
        ?>
    </div>
    <div class="categories">
        <h2>Categories</h2>
        <div class="category-list">
            <?php
            $categories = $conn->query("SELECT * FROM categories");
            if ($categories) {
                while ($category = $categories->fetch_assoc()) {
                    echo "<div class='category-item'>";
                    echo "<a href='javascript:void(0)' onclick=\"window.location.href='category.php?id={$category['id']}'\">{$category['name']}</a>";
                    echo "</div>";
                }
            } else {
                echo "<p>Error loading categories: " . $conn->error . "</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
