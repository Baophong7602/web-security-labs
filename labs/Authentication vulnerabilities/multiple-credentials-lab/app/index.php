<?php
session_start();

if (!isset($_SESSION["failed_attempts"])) {
    $_SESSION["failed_attempts"] = 0;
}

$message = $_SESSION["message"] ?? "";
unset($_SESSION["message"]);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Multiple Credentials Lab</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f7;
            margin: 0;
            padding: 50px;
        }

        .box {
            max-width: 380px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px #ddd;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
        }

        button {
            padding: 10px 18px;
            cursor: pointer;
        }

        .message {
            color: #b42318;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Đăng nhập</h2>

    <?php if ($message !== ""): ?>
        <p class="message">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
        </p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>
        Số request sai:
        <?= (int) $_SESSION["failed_attempts"] ?> / 3
    </p>
</div>
</body>
</html>
