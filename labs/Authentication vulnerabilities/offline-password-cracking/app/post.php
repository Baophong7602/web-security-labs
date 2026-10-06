<?php

session_start();

/*
 * =========================
 * LOGIC
 * =========================
 */

$posts = [
    1 => [
        "title" => "How to Protect Your Web Application",
        "content" => "
            Web applications should validate user input
            and properly encode data before displaying it.
            Authentication and session management are also
            important parts of application security.
        "
    ],

    2 => [
        "title" => "Understanding Web Authentication",
        "content" => "
            Authentication allows an application to identify
            and verify its users before granting access.
        "
    ],

    3 => [
        "title" => "Common Web Security Vulnerabilities",
        "content" => "
            Common vulnerabilities include XSS, SQL injection,
            authentication flaws and access control problems.
        "
    ]
];

$id = isset($_GET["id"])
    ? (int) $_GET["id"]
    : 1;

if (!isset($posts[$id])) {
    $id = 1;
}

$post = $posts[$id];

/*
 * Đọc comment
 */

$comments_file = __DIR__ . "/comments.json";

$comments = [];

if (file_exists($comments_file)) {

    $comments = json_decode(
        file_get_contents($comments_file),
        true
    );

    if (!is_array($comments)) {
        $comments = [];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        <?= htmlspecialchars($post["title"]) ?>
    </title>

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

        .article,
        .comments {
            background: white;
            border: 1px solid #ddd;
            padding: 25px;
            margin-bottom: 20px;
        }

        .comment {
            background: #f1f1f1;
            padding: 15px;
            margin-top: 15px;
        }

        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
        }

        button {
            margin-top: 10px;
            padding: 10px 20px;
        }

    </style>

</head>

<body>

<nav>

    <a href="/">
        Home
    </a>

    <?php if (isset($_SESSION["username"])): ?>

        <a href="/my-account.php">
            My Account
        </a>

        <a href="/logout.php">
            Logout
        </a>

        <span>
            Logged in as:
            <strong>
                <?= htmlspecialchars($_SESSION["username"]) ?>
            </strong>
        </span>

    <?php else: ?>

        <a href="/login.php">
            Login
        </a>

    <?php endif; ?>

</nav>

<div class="article">

    <h1>
        <?= htmlspecialchars($post["title"]) ?>
    </h1>

    <p>
        <?= nl2br($post["content"]) ?>
    </p>

</div>

<div class="comments">

    <h2>
        Comments
    </h2>

    <?php

    $post_comments = [];

    foreach ($comments as $comment) {

        if (
            isset($comment["post_id"]) &&
            $comment["post_id"] == $id
        ) {
            $post_comments[] = $comment;
        }
    }

    ?>

    <?php if (empty($post_comments)): ?>

        <p>
            No comments yet.
        </p>

    <?php else: ?>

        <?php foreach ($post_comments as $comment): ?>

            <div class="comment">

                <strong>
                    <?= htmlspecialchars($comment["username"]) ?>
                </strong>

                <p>

                    <?php

                    /*
                     Bảng Lỗi
                     *
                     * Comment được xuất trực tiếp
                     * ra HTML.
                     */

                    // echo $comment["comment"];

                    // Bảng fix
                        echo htmlspecialchars(
                        $comment["comment"],
                        ENT_QUOTES,
                        "UTF-8"
                        );

                    ?>

                </p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<div class="comments">

    <h2>
        Leave a comment
    </h2>

    <?php if (isset($_SESSION["username"])): ?>

        <form
            method="POST"
            action="/comment.php"
        >

            <input
                type="hidden"
                name="post_id"
                value="<?= $id ?>"
            >

            <textarea
                name="comment"
                rows="6"
                placeholder="Write your comment..."
                required
            ></textarea>

            <br>

            <button type="submit">
                Post Comment
            </button>

        </form>

    <?php else: ?>

        <p>
            Please
            <a href="/login.php">
                login
            </a>
            to leave a comment.
        </p>

    <?php endif; ?>

</div>

<p>

    <a href="/">
        ← Back to Blog
    </a>

</p>

</body>
</html>