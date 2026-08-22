<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];

// Avatar mặc định
$avatar = "default-avatar.png";

// Tìm ảnh upload mới nhất
$uploadDir = __DIR__ . "/uploads";

$latestFile = null;
$latestTime = 0;

if (is_dir($uploadDir)) {

    foreach (scandir($uploadDir) as $file) {

        // Bỏ . và ..
        if ($file === "." || $file === "..") {
            continue;
        }

        $filePath = $uploadDir . "/" . $file;

        // Chỉ lấy file
        if (!is_file($filePath)) {
            continue;
        }

        // Lấy extension
        $extension = strtolower(
            pathinfo($file, PATHINFO_EXTENSION)
        );

        // Chỉ lấy file ảnh
        if (!in_array(
            $extension,
            ["jpg", "jpeg", "png", "gif", "webp"]
        )) {
            continue;
        }

        // Lấy thời gian sửa đổi
        $time = filemtime($filePath);

        // Nếu file này mới hơn file trước
        if ($time > $latestTime) {

            $latestTime = $time;
            $latestFile = $file;
        }
    }
}

// Nếu tìm thấy ảnh upload
if ($latestFile !== null) {

    $avatar =
        "uploads/" . rawurlencode($latestFile);
}

?>

<!DOCTYPE html>

<html>

<head>

    <title>My Account</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .avatar-container {
            width: 130px;
            height: 130px;
            margin: 20px auto;
        }

        .avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }

        .account {
            text-align: center;
        }

        .upload-form {
            margin-top: 20px;
        }

    </style>

</head>

<body>

<div class="container account">

    <h2>My Account</h2>

    <!-- Avatar -->

    <div class="avatar-container">

        <img
            src="<?php echo htmlspecialchars($avatar); ?>"
            alt="Avatar"
            class="avatar"
        >

    </div>


    <p>

        Welcome,

        <b>
            <?php echo htmlspecialchars($username); ?>
        </b>

    </p>

    <hr>


    <h3>Upload Avatar</h3>


    <form
        class="upload-form"
        action="upload-avatar-fixed.php"
        method="POST"
        enctype="multipart/form-data"
    >

        <input
            type="file"
            name="avatar"
            accept="image/*"
            required
        >

        <br><br>

        <button type="submit">
            Upload Avatar
        </button>

    </form>


    <br>

    <a href="logout.php">
        Logout
    </a>

</div>

</body>

</html>