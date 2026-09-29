<?php

session_start();

$users = [
    "wiener" => "peter",
    "carlos" => "carlos123"
];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if (isset($users[$username]) && $users[$username] === $password) {

        $_SESSION["username"] = $username;
        $_SESSION["logged_in"] = true;
        $_SESSION["2fa_verified"] = false;

        header(
            "Location: /login2.php?verify=" .
            urlencode($username)
        );

        exit;
    }

    $message = "Invalid user";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>

<body>

<h2>Login</h2>

<form method="POST" action="/login.php">

    <label>Username</label>
    <br>

    <input type="text" name="username">

    <br><br>

    <label>Password</label>
    <br>

    <input type="password" name="password">

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

<p>
    <?= htmlspecialchars($message) ?>
</p>

</body>
</html>