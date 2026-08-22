<?php

session_start();

if (isset($_SESSION["username"])) {
    header("Location: my-account.php");
    exit();
}

header("Location: login.php");
exit();

?>