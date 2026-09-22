<?php

session_start();

if (!isset($_SESSION["users"])) {

    $_SESSION["users"] = [
        "wiener" => "peter",
        "carlos" => "oldpassword"
    ];

}

if (!isset($_SESSION["reset_tokens"])) {

    $_SESSION["reset_tokens"] = [];

}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];

    if (isset($_SESSION["users"][$username])) {

        $token = bin2hex(random_bytes(16));

        
        //   LỖ HỔNG:
        //   Token không được liên kết với username.
                  
         $_SESSION["reset_tokens"][$token] = true;
         

        /*
         * FIX
         */

        // $_SESSION["reset_tokens"][$token] = $username;

        $message =
            "<a href='/reset-password.php?temp-forgot-password-token="
            . urlencode($token)
            . "'>Open reset link</a>";

    }

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Forgot Password</title>

</head>

<body>

<h2>Forgot Password</h2>

<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
    >

    <br><br>

    <button type="submit">
        Send reset link
    </button>

</form>

<?php if ($message): ?>

    <p>
        <?= $message ?>
    </p>

<?php endif; ?>

<br>

<a href="/login.php">
    Back to login
</a>

</body>

</html>

