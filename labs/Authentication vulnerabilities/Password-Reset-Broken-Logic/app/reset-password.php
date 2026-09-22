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

$token =
    $_GET["temp-forgot-password-token"]
    ?? $_POST["temp-forgot-password-token"]
    ?? "";

$error = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];

    $password1 = $_POST["new-password-1"];
    $password2 = $_POST["new-password-2"];


    if (!isset($_SESSION["reset_tokens"][$token])) {

        $error = "Invalid reset token";

    } elseif ($password1 !== $password2) {

        $error = "Passwords do not match";

    } elseif (!isset($_SESSION["users"][$username])) {

        $error = "User not found";

    } else {


        $_SESSION["users"][$username] = $password1;


        /*
        $tokenUser = $_SESSION["reset_tokens"][$token];

        if ($username !== $tokenUser) {

            http_response_code(403);
            exit("Invalid reset request");

        } else {

            $_SESSION["users"][$tokenUser] = $password1;

            $message =
                "Password reset successful for "
                . htmlspecialchars($tokenUser);

        }
        */


        $message =
            "Password reset successful for "
            . htmlspecialchars($username);
    }

}

?>

<!DOCTYPE html>

<html>

<head>

    <title>Reset Password</title>

</head>

<body>

<h2>Reset Password</h2>

<?php if ($error): ?>

    <p style="color:red">

        <?= htmlspecialchars($error) ?>

    </p>

<?php endif; ?>


<?php if ($message): ?>

    <p style="color:green">

        <?= $message ?>

    </p>

    <a href="/login.php">

        Login

    </a>

<?php else: ?>

<form method="POST">

    <input
        type="hidden"
        name="temp-forgot-password-token"
        value="<?= htmlspecialchars($token) ?>"
    >

    <input
        type="text"
        name="username"
        placeholder="Username"
    >

    <br><br>

    <input
        type="password"
        name="new-password-1"
        placeholder="New password"
    >

    <br><br>

    <input
        type="password"
        name="new-password-2"
        placeholder="Confirm password"
    >

    <br><br>

    <button type="submit">

        Reset Password

    </button>

</form>

<?php endif; ?>

</body>

</html>