<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === "wiener" && $password === "peter") {

        $_SESSION["username"] = $username;

        header("Location: my-account.php");
        exit;
    }

    $error = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if (isset($error)): ?>
    <p><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
        required
    >

    <br><br>

    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>