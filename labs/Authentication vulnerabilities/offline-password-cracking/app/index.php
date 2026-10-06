<?php

session_start();

/*
 * =========================
 * LOGIC
 * =========================
 */

$logged_in = isset($_SESSION["username"]);
$username = $_SESSION["username"] ?? "";

/*
 * Danh sách bài viết
 */

$posts = [
    [
        "id" => 1,
        "title" => "How to Protect Your Web Application",
        "description" => "Basic security practices for modern web applications."
    ],
    [
        "id" => 2,
        "title" => "Understanding Web Authentication",
        "description" => "Learn how authentication works in web applications."
    ],
    [
        "id" => 3,
        "title" => "Common Web Security Vulnerabilities",
        "description" => "An introduction to common vulnerabilities found in web applications."
    ]
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Security Blog</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            width: 900px;
            margin: 40px auto;
            background: #f7f7f7;
        }

        nav {
            background: #222;
            padding: 15px;
            margin-bottom: 30px;
        }

        nav a {
            color: white;
            margin-right: 25px;
            text-decoration: none;
        }

        nav span {
            color: #ddd;
            float: right;
        }

        .post {
            background: white;
            border: 1px solid #ddd;
            padding: 25px;
            margin-bottom: 20px;
        }

        .post h2 {
            margin-top: 0;
        }

        .post a {
            display: inline-block;
            margin-top: 10px;
        }

    </style>

</head>

<body>

<nav>

    <a href="/">
        Home
    </a>

    <?php if ($logged_in): ?>

        <a href="/my-account.php">
            My Account
        </a>

        <a href="/logout.php">
            Logout
        </a>

        <span>
            Logged in as:
            <strong><?= htmlspecialchars($username) ?></strong>
        </span>

    <?php else: ?>

        <a href="/login.php">
            Login
        </a>

    <?php endif; ?>

</nav>

<h1>Security Blog</h1>

<p>
    Welcome to the security research blog.
    Select an article to read and leave a comment.
</p>

<?php foreach ($posts as $post): ?>

    <div class="post">

        <h2>
            <?= htmlspecialchars($post["title"]) ?>
        </h2>

        <p>
            <?= htmlspecialchars($post["description"]) ?>
        </p>

        <a href="/post.php?id=<?= $post["id"] ?>">
            Read article →
        </a>

    </div>

<?php endforeach; ?>

</body>
</html>