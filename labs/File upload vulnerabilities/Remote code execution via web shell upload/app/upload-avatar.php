<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['avatar'])) {
        die("No file uploaded.");
    }

    $filename = $_FILES['avatar']['name'];
    $tmpFile = $_FILES['avatar']['tmp_name'];

    $uploadPath = __DIR__ . "/uploads/" . $filename;

    if (move_uploaded_file($tmpFile, $uploadPath)) {

        echo "<h2>Upload successful</h2>";

        echo "<p>File name: ";
        echo htmlspecialchars($filename);
        echo "</p>";

        echo "<p>";
        echo "<a href='my-account.php'>Back to My Account</a>";
        echo "</p>";

    } else {

        echo "Upload failed.";

    }
}
?>