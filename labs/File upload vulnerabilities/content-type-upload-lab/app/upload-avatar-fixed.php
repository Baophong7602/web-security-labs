<?php

session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: my-account.php");
    exit();
}

if (!isset($_FILES["avatar"])) {
    die("No file uploaded");
}

$file = $_FILES["avatar"];

if ($file["error"] !== UPLOAD_ERR_OK) {
    die("Upload error");
}

$filename = basename($file["name"]);

$extension = strtolower(
    pathinfo($filename, PATHINFO_EXTENSION)
);

$allowedExtensions = [
    "jpg",
    "jpeg",
    "png"
];

if (!in_array($extension, $allowedExtensions, true)) {
    die("Invalid file extension");
}

$finfo = new finfo(FILEINFO_MIME_TYPE);

$realMime = $finfo->file($file["tmp_name"]);

$allowedMimeTypes = [
    "image/jpeg",
    "image/png"
];

if (!in_array($realMime, $allowedMimeTypes, true)) {
    die("Invalid image type");
}

$newFilename =
    bin2hex(random_bytes(16))
    . "." . $extension;

$uploadPath =
    __DIR__
    . "/uploads/"
    . $newFilename;

if (!move_uploaded_file(
    $file["tmp_name"],
    $uploadPath
)) {
    die("Upload failed");
}

echo "<h2>Upload successful</h2>";

echo "<p>File uploaded successfully.</p>";

echo "<a href='my-account.php'>";
echo "Back to My Account";
echo "</a>";

?>