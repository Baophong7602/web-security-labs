<?php

session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username === "wiener" && $password === "peter") {

        $_SESSION["username"] = $username;

        header("Location: my-account.php");
        exit();

    } else {

        $error = "Invalid username or password";
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <h2>Login</h2>

    <?php if ($error): ?>

        <p class="error">
            <?php echo $error; ?>
        </p>

    <?php endif; ?>


    <form method="POST">

        <label>Username</label>

        <input
            type="text"
            name="username"
            required
        >


        <label>Password</label>

        <input
            type="password"
            name="password"
            required
        >


        <button type="submit">
            Login
        </button>

    </form>


    <hr>

   
</div>

</body>

</html>