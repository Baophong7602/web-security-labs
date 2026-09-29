<?php

session_start();

/*
 * File lưu mã 2FA.
 *
 * Mã 2FA không nằm trong session,
 * vì logout không được làm mất mã của Carlos.
 */
$mfa_file = __DIR__ . "/mfa_codes.json";


/*
 * Đọc các mã 2FA hiện tại.
 */
if (file_exists($mfa_file)) {

    $mfa_codes = json_decode(
        file_get_contents($mfa_file),
        true
    );

    if (!is_array($mfa_codes)) {
        $mfa_codes = [];
    }

} else {

    $mfa_codes = [];
}


/*
 * GET /login2.php
 */
if ($_SERVER["REQUEST_METHOD"] === "GET") {

// Bảng lỗi Server tin tưởng verify do client gửi
    // $verify = $_GET["verify"] ?? "";

    // if ($verify !== "wiener" && $verify !== "carlos") {
    //     die("Invalid user");
    // }
// Bảng Fix
        $verify = $_SESSION["username"] ?? "";

    if ($verify === "") {
        header("Location: /login.php");
        exit;
    }


//    Bảng lỗi
    // $code = str_pad(
    //     random_int(0, 9999),
    //     4,
    //     "0",
    //     STR_PAD_LEFT
    // );
// Bảng Fix
   $code = str_pad(
        random_int(0, 999999),
        6,
        "0",
        STR_PAD_LEFT
    );

   
    $mfa_codes[$verify] = $code;

    file_put_contents(
        $mfa_file,
        json_encode($mfa_codes)
    );


    echo "<h2>Two-Factor Authentication</h2>";


    /*
     * Chỉ hiển thị mã nếu verify là
     * tài khoản đang đăng nhập.
     */
    if (
        isset($_SESSION["username"]) &&
        $_SESSION["username"] === $verify
    ) {

        echo "<p>Your 2FA code: <b>"
            . htmlspecialchars($code)
            . "</b></p>";

    } else {

        echo "<p>Verification code sent.</p>";
    }

    ?>

    <form method="POST" action="/login2.php">

        <input
            type="hidden"
            name="verify"
            value="<?= htmlspecialchars($verify) ?>"
        >
    <!-- Bảng lỗi -->
        <!-- <input
            type="text"
            name="mfa-code"
            maxlength="4"
            minlength="4"
            placeholder="4-digit code"
        > -->
        <!-- Bảng fix  -->
         <input
        type="text"
        name="mfa-code"
        maxlength="6"
        minlength="6"
        placeholder="6-digit code"
        >

        <button type="submit">
            Verify
        </button>

    </form>

    <?php

    exit;
}


/*
 * POST /login2.php
 */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Bảng lỗi
    // $verify = $_POST["verify"] ?? "";
    // Bảng fix
     $verify = $_SESSION["username"] ?? "";
    $mfa_code = $_POST["mfa-code"] ?? "";


    /*
     * Đọc lại mã 2FA.
     */
    if (file_exists($mfa_file)) {

        $mfa_codes = json_decode(
            file_get_contents($mfa_file),
            true
        );

        if (!is_array($mfa_codes)) {
            $mfa_codes = [];
        }

    } else {

        $mfa_codes = [];
    }


  

    /*
     * Kiểm tra mã dựa vào verify.
     */
    if (
        isset($mfa_codes[$verify]) &&
        hash_equals(
            (string) $mfa_codes[$verify],
            (string) $mfa_code
        )
    ) {

        $_SESSION["2fa_verified"] = true;

        $_SESSION["authenticated_user"] = $verify;
    

        header(
            "Location: /my-account.php",
            true,
            302
        );

        exit;
    }


    echo "Invalid verification code";
}
