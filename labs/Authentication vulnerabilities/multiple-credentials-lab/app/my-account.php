<?php
    session_start();

    $username = $_SESSION["logged_in"] ?? "";

    if ($username === "") {
        header("Location: index.php");
        exit;
    }

    $display_name = htmlspecialchars(
        $username,
        ENT_QUOTES,
        "UTF-8"
    );
    ?>
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>My Account</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 40px;
            }

            .account {
                max-width: 500px;
                padding: 25px;
                border: 1px solid #ddd;
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
    <div class="account">
        <h2>My Account</h2>
        <p>Đăng nhập thành công!</p>
        <p>Xin chào, <?= $display_name ?>.</p>
        <a href="logout.php">Đăng xuất</a>
    </div>
    </body>
    </html>
