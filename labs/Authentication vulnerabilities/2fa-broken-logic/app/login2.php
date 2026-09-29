<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $verify = $_GET["verify"] ?? "";

    if ($verify !== "wiener" && $verify !== "carlos") {
        die("Invalid user");
    }

    // Tạo mã 2FA 4 số
    $code = str_pad(
        random_int(0, 9999),
        4,
        "0",
        STR_PAD_LEFT
    );

    // Lưu mã theo username
    $_SESSION["mfa_codes"][$verify] = $code;

    echo "<h2>Two-Factor Authentication</h2>";

    /*
     * Chỉ hiển thị mã khi verify trùng
     * với user đang đăng nhập.
     *
     * Carlos thì KHÔNG hiển thị mã.
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

        <input
            type="text"
            name="mfa-code"
            maxlength="4"
            placeholder="4-digit code"
        >

        <button type="submit">
            Verify
        </button>

    </form>

    <?php

    exit;
}


/*
 * POST /login2
 */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Bản Lỗi
        // $verify = $_POST["verify"] ?? "";
        // $mfa_code = $_POST["mfa-code"] ?? "";

        // if (
        //     isset($_SESSION["mfa_codes"][$verify]) &&
        //     hash_equals(
        //         (string) $_SESSION["mfa_codes"][$verify],
        //         (string) $mfa_code
        //     )
        // ) {

        //     $_SESSION["2fa_verified"] = true;

        //     // Lấy user từ verify do client gửi
        //     $_SESSION["authenticated_user"] = $verify;

        //     header("Location: /my-account.php", true, 302);
        //     exit;
        // }

        // echo "Invalid verification code";
        
        // Bản FIX
        $verify = $_POST["verify"] ?? "";
        $mfa_code = $_POST["mfa-code"] ?? "";

        $username = $_SESSION["username"] ?? "";

        // Kiểm tra verify có đúng tài khoản đã đăng nhập không
        if ($verify !== $username) {
        echo "Invalid verification request";
        exit;
        }   

    // Chỉ kiểm tra mã 2FA của tài khoản đã đăng nhập
    if (
        isset($_SESSION["mfa_codes"][$username]) &&
        hash_equals(
            (string) $_SESSION["mfa_codes"][$username],
            (string) $mfa_code
        )
    ) {

        $_SESSION["2fa_verified"] = true;
        $_SESSION["authenticated_user"] = $username;

        header("Location: /my-account.php", true, 302);
        exit;
    }

    echo "Invalid verification code";
    }