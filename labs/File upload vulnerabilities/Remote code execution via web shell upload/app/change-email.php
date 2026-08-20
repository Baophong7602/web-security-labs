<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';

    $_SESSION['email'] = $email;

    echo "Email updated successfully.";
    echo "<br><br>";
    echo "<a href='my-account.php'>Back to My Account</a>";
}
?>