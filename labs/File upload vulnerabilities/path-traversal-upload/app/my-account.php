<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /login.php");
    exit;
}

$username = $_SESSION["username"];

$avatar = null;

$avatarDir = __DIR__ . "/files/avatars/";

$files = glob($avatarDir . "*");

foreach ($files as $file) {

    if (is_file($file)) {

        $filename = basename($file);

        // Chỉ hiển thị các file ảnh bình thường
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $filename)) {

            $avatar = "/files/avatars/" . rawurlencode($filename);

            break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Account</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        .header {
            background: #222;
            color: white;
            padding: 18px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .logout {
            color: white;
            text-decoration: none;

            padding: 9px 16px;

            border: 1px solid #666;
            border-radius: 4px;
        }

        .logout:hover {
            background: #444;
        }

        .container {
            width: 700px;
            max-width: calc(100% - 40px);

            margin: 40px auto;
        }

        .account-card {
            background: white;

            padding: 30px;

            border-radius: 6px;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .account-header {
            display: flex;
            align-items: center;

            gap: 20px;

            margin-bottom: 30px;
        }

        .avatar {
            width: 90px;
            height: 90px;

            border-radius: 50%;

            object-fit: cover;

            border: 2px solid #ddd;
        }

        .avatar-placeholder {
            width: 90px;
            height: 90px;

            border-radius: 50%;

            background: #eee;

            display: flex;
            align-items: center;
            justify-content: center;

            color: #777;

            font-size: 14px;
        }

        .username {
            color: #666;

            margin: 5px 0 0;
        }

        .upload-box {
            border-top: 1px solid #ddd;

            padding-top: 25px;
        }

        .upload-box h3 {
            margin-top: 0;
        }

        .file-input {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 4px;

            background: #fafafa;
        }

        .upload-button {
            margin-top: 15px;

            padding: 11px 22px;

            border: none;

            border-radius: 4px;

            background: #222;

            color: white;

            cursor: pointer;
        }

        .upload-button:hover {
            background: #444;
        }

        .note {
            margin-top: 15px;

            font-size: 13px;

            color: #777;
        }

    </style>

</head>

<body>

    <div class="header">

        <h2>My Account</h2>

        <a href="/logout.php" class="logout">
            Logout
        </a>

    </div>


    <div class="container">

        <div class="account-card">

            <div class="account-header">

                <?php if ($avatar): ?>

                    <img
                        src="<?= htmlspecialchars($avatar) ?>"
                        class="avatar"
                        alt="Avatar"
                    >

                <?php else: ?>

                    <div class="avatar-placeholder">
                        No Avatar
                    </div>

                <?php endif; ?>


                <div>

                    <h3>
                        Account Information
                    </h3>

                    <p class="username">
                        Welcome,
                        <strong>
                            <?= htmlspecialchars($username) ?>
                        </strong>
                    </p>

                </div>

            </div>


            <div class="upload-box">

                <h3>
                    Upload Avatar
                </h3>

                <form
                    action="/my-account/avatar"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <input
                        type="file"
                        name="avatar"
                        class="file-input"
                        accept="image/*"
                        required
                    >

                    <button
                        type="submit"
                        class="upload-button"
                    >
                        Upload Avatar
                    </button>

                </form>

                <p class="note">
                    Select an image file to use as your avatar.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
```
