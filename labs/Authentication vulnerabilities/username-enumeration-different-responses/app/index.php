<?php

$users = [
    "appserver" => "michael"
];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // if (!isset($users[$username])) {
    //     $message = "Invalid username";
    // }
    // elseif ($users[$username] !== $password) {
    //     $message = "Incorrect password";
    // }
    // else {
    //     header("Location: /success.php");
    //     exit;
    // }

    if (!isset($users[$username]) || $users[$username] !== $password) {

    $message = "Invalid username or password";

}
else {

    header("Location: /success.php");
    exit;

}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>

<body>

<h2>Login</h2>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST" action="/">

    <input type="text" name="username" placeholder="Username">

    <br><br>

    <input type="password" name="password" placeholder="Password">

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>