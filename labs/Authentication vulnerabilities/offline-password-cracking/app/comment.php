<?php

session_start();

/*
 * =========================
 * LOGIC
 * =========================
 */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: /");

    exit;
}

if (!isset($_SESSION["username"])) {

    header("Location: /login.php");

    exit;
}

$username = $_SESSION["username"];

$post_id = (int) ($_POST["post_id"] ?? 0);

$comment = $_POST["comment"] ?? "";

$comments_file = __DIR__ . "/comments.json";

$comments = [];

if (file_exists($comments_file)) {

    $comments = json_decode(
        file_get_contents($comments_file),
        true
    );

    if (!is_array($comments)) {
        $comments = [];
    }
}

/*
 * =========================
 * VULNERABLE LOGIC
 * =========================
 *
 * Lưu comment nguyên dạng.
 *
 * Không lọc HTML hoặc JavaScript.
 */

$comments[] = [
    "post_id" => $post_id,
    "username" => $username,
    "comment" => $comment
];

file_put_contents(
    $comments_file,
    json_encode(
        $comments,
        JSON_PRETTY_PRINT
    )
);

header("Location: /");
exit;