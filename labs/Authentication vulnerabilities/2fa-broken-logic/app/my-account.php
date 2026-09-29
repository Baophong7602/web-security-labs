<?php

session_start();

if (
    !isset($_SESSION["2fa_verified"]) ||
    $_SESSION["2fa_verified"] !== true
) {
    header("Location: /login.php");
    exit;
}

$username = $_SESSION["authenticated_user"] ?? "";

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
    <b><?= htmlspecialchars($username) ?></b>
</p>

<?php if ($username === "carlos"): ?>

    <p>
        Carlos account successfully accessed.
    </p>

    <p>
        Secret: Carlos's secret data
    </p>

<?php elseif ($username === "wiener"): ?>

    <p>
        Wiener account successfully accessed.
    </p>

<?php endif; ?>

<br>

<a href="/logout.php">
    Logout
</a>

</body>
</html>

