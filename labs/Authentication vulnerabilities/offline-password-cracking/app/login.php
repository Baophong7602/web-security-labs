<?php

session_start();

/*
 * =========================
 * LOGIC
 * =========================
 */

$users = [
    "wiener" => "peter",
    "carlos" => "onceuponatime"
];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";

    $password = $_POST["password"] ?? "";

    if (
        isset($users[$username]) &&
        $users[$username] === $password
    ) {

        $_SESSION["username"] = $username;

        /*
         * Bảng Lỗi
         *
         * Cookie được tạo từ:
         *
         * username:MD5(password)
         *
         * sau đó Base64.
         */

        // if (isset($_POST["stay_logged_in"])) {

        //     $hash = md5($password);

        //     $cookie_value = base64_encode(
        //         $username . ":" . $hash
        //     );

        //     setcookie(
        //         "stay-logged-in",
        //         $cookie_value,
        //         time() + 86400,
        //         "/"
        //     );
        // }


        // Bảng Fix
        if (isset($_POST["stay_logged_in"])) {

        $token = bin2hex(random_bytes(32));

        $token_file = __DIR__ . "/stay_tokens.json";

        if (file_exists($token_file)) {
            $tokens = json_decode(
                file_get_contents($token_file),
                true
            );
        } else {
            $tokens = [];
        }

        if (!is_array($tokens)) {
            $tokens = [];
        }

        $tokens[$token] = $username;

        file_put_contents(
            $token_file,
            json_encode($tokens)
        );

        setcookie(
            "stay-logged-in",
            $token,
            time() + 86400,
            "/"
        );
    }

        header("Location: /");

        exit;

    } else {

        $message = "Invalid username or password.";

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            width: 500px;
            margin: 80px auto;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
        }

        .error {
            color: red;
        }

    </style>

</head>

<body>

<h1>
    Login
</h1>

<?php if ($message): ?>

    <p class="error">
        <?= htmlspecialchars($message) ?>
    </p>

<?php endif; ?>

<form method="POST">

    <label>
        Username
    </label>

    <input
        type="text"
        name="username"
        required
    >

    <label>
        Password
    </label>

    <input
        type="password"
        name="password"
        required
    >

    <label>

        <input
            type="checkbox"
            name="stay_logged_in"
            value="1"
        >

        Stay logged in

    </label>

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

<p>
    <a href="/">
        ← Back to Blog
    </a>
</p>

</body>
</html>