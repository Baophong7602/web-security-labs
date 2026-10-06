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
     * có thể brute-force password để tạo
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
  * BẢN Fix
  *
  * Tạo token ngẫu nhiên thay vì sử dụng password.
  */
 $token = bin2hex(random_bytes(32));

 /*
  * Lưu token vào session và gắn với username.
  */
 $_SESSION["stay_logged_in"] = $token;
 $_SESSION["username"] = $username;

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
