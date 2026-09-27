<?php

session_start();

$users = [
    "wiener" => "peter",
    "carlos" => "secret123"
];

// Bộ đếm riêng cho từng username
if (
    !isset($_SESSION["failed_attempts"]) ||
    !is_array($_SESSION["failed_attempts"])
) {
    $_SESSION["failed_attempts"] = [];
}

$message = "";
$logged_in = false;
$current_user = "";

// Logout
if (isset($_GET["logout"])) {

    $_SESSION["logged_in"] = false;
    $_SESSION["username"] = "";

    header("Location: fixed.php");
    exit;
}

// Login
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // Khởi tạo counter cho username
    if (!isset($_SESSION["failed_attempts"][$username])) {
        $_SESSION["failed_attempts"][$username] = 0;
    }

    // Kiểm tra tài khoản đã bị giới hạn chưa
    if ($_SESSION["failed_attempts"][$username] >= 3) {

        $message = "Too many incorrect login attempts. Please try again later.";
    }

    // Kiểm tra password
    elseif ($users[$username] === $password) {

        // Chỉ reset counter của username hiện tại
        $_SESSION["failed_attempts"][$username] = 0;

        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;

        $logged_in = true;
        $current_user = $username;

        $message = "Login successful";
    }

    // Password sai
    else {

        // Chỉ tăng counter của username hiện tại
        $_SESSION["failed_attempts"][$username]++;

        $message = "Invalid username or password";
    }
}

// Kiểm tra trạng thái đăng nhập
if (
    isset($_SESSION["logged_in"]) &&
    $_SESSION["logged_in"] === true
) {

    $logged_in = true;
    $current_user = $_SESSION["username"];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fixed Login</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            cursor: pointer;
        }

        .success {
            color: green;
            font-weight: bold;
            text-align: center;
        }

        .error {
            color: red;
            font-weight: bold;
            text-align: center;
        }

        .account {
            margin-top: 20px;
            padding: 20px;
            background: #e8f5e9;
            border-radius: 5px;
            text-align: center;
        }

        .logout {
            background: #f44336;
            color: white;
            border: none;
        }
    </style>
</head>

<body>

<div class="container">

<?php if ($logged_in): ?>

    <h2>My Account</h2>

    <div class="account">

        <h3>Login successful</h3>

        <p>
            Welcome,
            <strong>
                <?= htmlspecialchars($current_user) ?>
            </strong>
        </p>

        <p>You are now logged in.</p>

        <form method="GET">

            <input
                type="hidden"
                name="logout"
                value="1"
            >

            <button
                type="submit"
                class="logout"
            >
                Logout
            </button>

        </form>

    </div>

<?php else: ?>

    <h2>Fixed Login</h2>

    <?php if ($message !== ""): ?>

        <p class="<?= $message === 'Login successful' ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>

    <?php endif; ?>

    <form method="POST">

        <label>Username</label>

        <input
            type="text"
            name="username"
            placeholder="Username"
            required
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >

        <button type="submit">
            Login
        </button>

    </form>

<?php endif; ?>

</div>

</body>
</html>
