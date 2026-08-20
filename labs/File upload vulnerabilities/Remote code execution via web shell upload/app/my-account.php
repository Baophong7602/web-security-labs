<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

/*
 * Tìm avatar mới nhất đã upload
 */
$avatar = null;
$latestTime = 0;

if (is_dir(__DIR__ . "/uploads")) {

    $files = scandir(__DIR__ . "/uploads");

    foreach ($files as $file) {

        if ($file === "." || $file === "..") {
            continue;
        }

        $path = __DIR__ . "/uploads/" . $file;

        if (is_file($path)) {

            $time = filemtime($path);

            if ($time > $latestTime) {
                $latestTime = $time;
                $avatar = $file;
            }
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
            background: #f4f6f8;
            color: #333;
        }

        /* Navbar */

        .navbar {
            background: #222;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            font-size: 20px;
        }

        .logout {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .logout:hover {
            text-decoration: underline;
        }

        /* Main container */

        .container {
            width: 900px;
            max-width: 90%;
            margin: 40px auto;
        }

        /* Account card */

        .account-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.08);
        }

        /* Avatar */

        .avatar-container {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        .avatar {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #eee;
        }

        .avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
            font-size: 14px;
        }

        /* Header */

        .account-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .account-header h1 {
            margin: 0 0 8px;
        }

        .account-header p {
            margin: 0;
            color: #777;
        }

        /* Account information */

        .info {
            margin-bottom: 30px;
        }

        .info p {
            margin: 10px 0;
        }

        /* Sections */

        .section {
            border-top: 1px solid #eee;
            padding-top: 25px;
            margin-top: 25px;
        }

        .section h3 {
            margin-top: 0;
        }

        /* Inputs */

        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 11px;
            margin: 10px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Buttons */

        button {
            background: #222;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #444;
        }

        /* Upload note */

        .upload-note {
            color: #777;
            font-size: 13px;
            margin-top: -5px;
        }

    </style>

</head>

<body>

    <!-- Navbar -->

    <div class="navbar">

        <h2>My Account</h2>

        <a
            class="logout"
            href="logout.php"
        >
            Logout
        </a>

    </div>


    <!-- Main -->

    <div class="container">

        <div class="account-card">


            <!-- Avatar -->

            <div class="avatar-container">

                <?php if ($avatar): ?>

                    <img
                        class="avatar"
                        src="uploads/<?php echo rawurlencode($avatar); ?>"
                        alt="Avatar"
                    >

                <?php else: ?>

                    <div class="avatar-placeholder">
                        No Avatar
                    </div>

                <?php endif; ?>

            </div>


            <!-- Account header -->

            <div class="account-header">

                <h1>
                    Account Settings
                </h1>

                <p>
                    Manage your account information and profile.
                </p>

            </div>


            <!-- Account information -->

            <div class="info">

                <h3>
                    Account Information
                </h3>


                <p>

                    <strong>
                        Username:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $_SESSION['username']
                    );

                    ?>

                </p>


                <p>

                    <strong>
                        Email:
                    </strong>

                    <?php

                    echo htmlspecialchars(
                        $_SESSION['email']
                    );

                    ?>

                </p>

            </div>


            <!-- Update email -->

            <div class="section">

                <h3>
                    Update Email
                </h3>


                <form
                    action="change-email.php"
                    method="POST"
                >

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter new email"
                        required
                    >

                    <button type="submit">
                        Update Email
                    </button>

                </form>

            </div>


            <!-- Upload avatar -->

            <div class="section">

                <h3>
                    Upload Avatar
                </h3>


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


                    <p class="upload-note">
                        Upload an image to use
                        as your profile avatar.
                    </p>


                    <button type="submit">
                        Upload Avatar
                    </button>

                </form>

            </div>


        </div>

    </div>

</body>

</html>