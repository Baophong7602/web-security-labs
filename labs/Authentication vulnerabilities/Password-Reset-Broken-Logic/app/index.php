<?php

session_start();

if (!isset($_SESSION["users"])) {
    $_SESSION["users"] = [
        "wiener" => "peter",
        "carlos" => "oldpassword"
    ];
}

if (!isset($_SESSION["reset_tokens"])) {
    $_SESSION["reset_tokens"] = [];
}

header("Location: /login.php");
exit;