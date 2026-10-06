<?php

session_start();

$username = $_SESSION["username"] ?? null;

if ($username === null) {

    header("Location: /login.php");

    exit;
}

$deleted_file = __DIR__ . "/deleted_users.json";

$deleted_users = [];

if (file_exists($deleted_file)) {

    $deleted_users = json_decode(
        file_get_contents($deleted_file),
        true
    );

    if (!is_array($deleted_users)) {
        $deleted_users = [];
    }
}

$deleted_users[] = $username;

file_put_contents(
    $deleted_file,
    json_encode(
        array_unique($deleted_users),
        JSON_PRETTY_PRINT
    )
);

session_unset();

session_destroy();

setcookie(
    "stay-logged-in",
    "",
    time() - 3600,
    "/"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Account Deleted</title>

</head>

<body>

<h1>
    Account deleted
</h1>

<p>

    The account
    <strong>
        <?= htmlspecialchars($username) ?>
    </strong>
    has been deleted.

</p>

<p>

    <a href="/">
        Back to Blog
    </a>

</p>

</body>
</html>