<?php
session_start();

session_unset();
session_destroy();

/*
 * Không xóa stay-logged-in cookie.
 * Đây là hành vi của chức năng Stay logged in.
 */

header("Location: index.php");
exit;

