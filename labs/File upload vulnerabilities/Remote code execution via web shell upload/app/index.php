<?php
session_start();

if (isset($_SESSION['username'])) {
    header("Location: my-account.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>

<body>

<h2>Login</h2>

<form action="login.php" method="POST">

    <label>Username:</label>
    <input type="text" name="username">

    <br><br>

    <label>Password:</label>
    <input type="password" name="password">

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>