<?php

session_start();

if (!isset($_SESSION["users"])) {
    $_SESSION["users"] = [
        "wiener" => "peter",
        "carlos" => "oldpassword"
    ];
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    if (
        isset($_SESSION["users"][$username]) &&
        $_SESSION["users"][$username] === $password
    ) {

        $_SESSION["user"] = $username;

        header("Location: /my-account.php");
        exit;
    }

    $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>

<body>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red">
        <?= htmlspecialchars($error) ?>
    </p>
<?php endif; ?>

<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
    >

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

<br>

<a href="/forgot-password.php">
    Forgot password?
</a>

</body>
</html>