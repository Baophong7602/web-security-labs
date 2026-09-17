<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /");
    exit;
}

// LỖI:
// Không kiểm tra $_SESSION["2fa_verified"]
// if (!isset($_SESSION["2fa_verified"]) || $_SESSION["2fa_verified"] !== true) {
//     header("Location: /login2.php");
//     exit;
// }
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
</head>
<body>

<h2>My Account</h2>

<p>Welcome, <?= htmlspecialchars($username) ?></p>

<p>This is your account page.</p>

<a href="/logout.php">Logout</a>

</body>
</html>