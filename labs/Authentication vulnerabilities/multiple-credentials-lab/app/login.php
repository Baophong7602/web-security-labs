<?php
session_start();

$users = [
    "carlos" => "123456",
    "wiener" => "peter"
];

if (!isset($_SESSION["failed_attempts"])) {
    $_SESSION["failed_attempts"] = 0;
}

// Khóa sau 3 request đăng nhập sai.
if ($_SESSION["failed_attempts"] >= 3) {
    $_SESSION["message"] = "Đăng nhập sai quá nhiều lần.";
    header("Location: index.php");
    exit;
}

// Đọc dữ liệu JSON.
$data = json_decode(file_get_contents("php://input"), true);

$username = $data["username"] ?? "";
$password = $data["password"] ?? "";

// // Chấp nhận một mật khẩu hoặc mảng.
// $passwords = is_array($password) ? $password : [$password];

// $valid = false;

// if (isset($users[$username])) {
//     foreach ($passwords as $candidate) {
//         if (is_string($candidate) && $candidate === $users[$username]) {
//             $valid = true;
//             break;
//         }
//     }
// }

// Bảng Fix Chỉ chấp nhận một mật khẩu.
$valid = false;

if (
    isset($users[$username]) &&
    is_string($password) &&
    $password === $users[$username]
) {
    $valid = true;
}

if ($valid) {
    session_regenerate_id(true);
    $_SESSION["logged_in"] = $username;
    $_SESSION["failed_attempts"] = 0;

    header("Location: my-account.php?id=" . urlencode($username), true, 302);
    exit;
}
$_SESSION["failed_attempts"]++;

$_SESSION["message"] = "Sai tên đăng nhập hoặc mật khẩu.";
header("Location: index.php", true, 302);
exit;
?>