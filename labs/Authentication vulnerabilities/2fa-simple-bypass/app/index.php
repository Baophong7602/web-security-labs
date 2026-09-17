<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $users = [
        "wiener" => "peter",
        "carlos" => "montoya"
    ];

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION["username"] = $username;
        $_SESSION["2fa_verified"] = false;

        header("Location: /login2.php");
        exit;
    }

    $message = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username">
    <br><br>

    <input type="password" name="password" placeholder="Password">
    <br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>