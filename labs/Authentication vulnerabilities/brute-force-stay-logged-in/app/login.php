<?php

session_start();

$users = [
    "wiener" => "peter",
    "carlos" => "moscow"
];

$username = $_POST["username"] ?? "";
$password = $_POST["password"] ?? "";

if (!isset($users[$username]) || $users[$username] !== $password) {
    die("Invalid username or password");
}

$_SESSION["username"] = $username;

if (isset($_POST["stay_logged_in"])) {

    /*
     * BẢN LỖI     *
     * Cookie được tạo từ username và MD5 của password.
     *
     * Attacker có thể brute-force password để tạo
     * cookie hợp lệ.
     */
    /*
    $value = $username . ":" . md5($password);
    $cookie = base64_encode($value);

    setcookie(
        "stay-logged-in",
        $cookie,
        time() + 3600,
        "/"
    );
    */


    /*
      BẢN Fix
     *
     * Tạo token ngẫu nhiên thay vì sử dụng password.
     */
    $token = bin2hex(random_bytes(32));


    /*
     * Lưu token ở phía server và gắn với username.
     */
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


    /*
     * Cookie chỉ chứa token.
     */
    setcookie(
        "stay-logged-in",
        $token,
        time() + 3600,
        "/"
    );
}


header("Location: my-account.php?id=" . urlencode($username));
exit;
