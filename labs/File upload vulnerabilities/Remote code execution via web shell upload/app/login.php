<?php
session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username === 'wiener' && $password === 'peter') {

    $_SESSION['username'] = 'wiener';
    $_SESSION['email'] = 'wiener@example.com';

    header("Location: my-account.php");
    exit;
}

echo "Invalid username or password";
?>