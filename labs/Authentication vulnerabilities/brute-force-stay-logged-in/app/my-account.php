<?php

session_start();

$users = [
    "wiener" => "peter",
    "carlos" => "moscow"
];


/*
 * BẢN LỖI *
 * Server lấy id trực tiếp từ URL để xác định tài khoản.
 */
/*
$id = $_GET["id"] ?? "";

if ($id === "") {
    $id = "wiener";
}
*/


/*
 * BẢN Fix
 *
 * Không sử dụng id trên URL để xác định tài khoản.
 * Tài khoản được lấy từ session.
 */

$id = $_SESSION["username"] ?? "";

if ($id === "") {
    header("Location: index.php");
    exit;
}


/*
 * BẢN LỖI
 *
 * Cookie chứa username:MD5(password).
 * Attacker có thể brute-force password để tạo
 * cookie hợp lệ.
 */
/*
$decoded = base64_decode($_COOKIE["stay-logged-in"]);

$parts = explode(":", $decoded, 2);

if (count($parts) !== 2) {
    die("Invalid cookie");
}

$cookie_username = $parts[0];
$cookie_hash = $parts[1];

if (
    isset($users[$id]) &&
    md5($users[$id]) === $cookie_hash
) {
    $_SESSION["username"] = $id;
} else {
    die("Invalid stay-logged-in cookie");
}
*/


/*
 *  BẢN SỬA
 *
 * Cookie chỉ chứa token ngẫu nhiên.
 * Server kiểm tra token và lấy username từ server.
 */

$token = $_COOKIE["stay-logged-in"] ?? "";

$token_file = __DIR__ . "/stay_tokens.json";

if (!file_exists($token_file)) {
    die("Invalid stay-logged-in cookie");
}

$tokens = json_decode(
    file_get_contents($token_file),
    true
);

if (
    !is_array($tokens) ||
    !isset($tokens[$token])
) {
    die("Invalid stay-logged-in cookie");
}

/*
 * Username được lấy từ dữ liệu phía server,
 * không lấy từ id trên URL.
 */
$id = $tokens[$token];

if (!isset($users[$id])) {
    die("User not found");
}

$_SESSION["username"] = $id;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Account</title>
</head>

<body>

<div class="page">

    <div class="account-box">

        <h1>My Account</h1>

        <p>
            Welcome, <?= htmlspecialchars($id) ?>
        </p>

        <p>
            <a href="#">Update email</a>
        </p>

        <p>
            <a href="logout.php">Logout</a>
        </p>

    </div>

</div>

</body>

</html>
