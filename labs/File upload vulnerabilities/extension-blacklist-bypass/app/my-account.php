<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Account</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f6f8;
        }

        .container {
            width: 500px;
            margin: 60px auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
        }

        .avatar {
            width: 140px;
            height: 140px;
            margin: 0 auto 15px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #eee;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-text {
            font-size: 20px;
            font-weight: bold;
             color: #777;
        }

        .username {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .upload-box {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: left;
        }

        .upload-box h3 {
            margin-top: 0;
            text-align: center;
        }

        input[type="file"] {
            width: 100%;
            margin: 15px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background: #333;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background: #555;
        }

        .logout {
            display: inline-block;
            margin-top: 25px;
            color: #d33;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>My Account</h2>

    <!-- Avatar -->
    <div class="avatar">
        <div class="avatar-text">AVATAR</div>
    </div>

    <!-- Username -->
    <div class="username">
        <?= htmlspecialchars($_SESSION["username"]) ?>
    </div>

    <!-- Upload Avatar -->
    <div class="upload-box">

        <h3>Upload Avatar</h3>

        <form
            action="upload-avatar.php"
            method="POST"
            enctype="multipart/form-data"
        >

            <input
                type="file"
                name="avatar"
                required
            >

            <button type="submit">
                Upload Avatar
            </button>

        </form>

    </div>

    <a class="logout" href="logout.php">
        Logout
    </a>

</div>

</body>
</html>
