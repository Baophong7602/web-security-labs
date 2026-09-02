<?php
session_start();
if (!isset($_SESSION["username"])) {
    http_response_code(403);
    die("You must login first.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Method not allowed.");
}

if (!isset($_FILES["avatar"])) {
    die("No file uploaded.");
}

$file = $_FILES["avatar"];
$filename = $file["name"];
$uploadDir = __DIR__ . "/files/avatars/";
$target = $uploadDir . $filename;
$extension = strtolower(
    pathinfo($filename, PATHINFO_EXTENSION)
);

if ($extension === "php") {
    die("Invalid file type.");
}
// if (!in_array($extension, ["jpg", "jpeg", "png"])) {
//     die("Invalid file type.");
// }
if (move_uploaded_file($file["tmp_name"], $target)) {

    $_SESSION["avatar"] = $filename;

    echo "The file avatars/" .
        htmlspecialchars($filename) .
        " has been uploaded.";
} else {

    echo "Upload failed.";
}
