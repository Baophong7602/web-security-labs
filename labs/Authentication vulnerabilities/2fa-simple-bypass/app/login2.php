<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /");
    exit;
}




// BẢN looix


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $code = $_POST["code"] ?? "";

    if ($code === "1817") {

        $_SESSION["2fa_verified"] = true;

        header("Location: /my-account.php");
        exit;
    }

    $message = "Invalid 2FA code";
}




/*
BẢN FIX
*/
// Lấy mã 2FA người dùng nhập từ form
// if ($_SERVER["REQUEST_METHOD"] === "POST") {

//     $code = $_POST["code"] ?? "";

//     $username = $_SESSION["username"];

//     // Mã 2FA riêng cho từng tài khoản
//     $codes = [
//         "wiener" => "1817",
//         "carlos" => "2468"
//     ];

//     // Chỉ xác thực thành công nếu mã đúng với tài khoản đang đăng nhập
//     if (isset($codes[$username]) && $code === $codes[$username]) {

//         $_SESSION["2fa_verified"] = true;

//         header("Location: /my-account.php");
//         exit;
//     }

//     $message = "Invalid 2FA code";
// }

?>

<!DOCTYPE html>
<html>
<head>
    <title>2FA</title>
</head>

<body>

<h2>Two-Factor Authentication</h2>

<?php if (isset($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="POST">

    <input
        type="text"
        name="code"
        placeholder="Enter 2FA code"
    >

    <button type="submit">Verify</button>

</form>

</body>
</html>

