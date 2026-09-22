<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /login.php");
    exit;
}

$username = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Account</title>
</head>

<body>

<h2>My Account</h2>

<p>
    Welcome,
    <strong><?= htmlspecialchars($username) ?></strong>
</p>

<p>
    You are logged in.
</p>

<a href="/logout.php">
    Logout
</a>

</body>

</html>