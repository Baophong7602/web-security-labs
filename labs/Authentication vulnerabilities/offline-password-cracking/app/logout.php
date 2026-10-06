<?php

session_start();

/*
 * =========================
 * LOGIC
 * =========================
 */

/*
 * Xóa session đăng nhập
 */
session_unset();

session_destroy();


/*
 * Xóa cookie stay-logged-in
 */
setcookie(
    "stay-logged-in",
    "",
    time() - 3600,
    "/"
);


/*
 * Quay về trang chủ
 */
header("Location: /");
exit;

?>