<?php
session_start();

if (isset($_SESSION["username"])) {
    header("Location: my-account.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f4f4;
            color: #333;
        }

        .page {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 380px;
            background: #ffffff;
            padding: 35px 40px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin: 0 0 30px;
            font-size: 28px;
            font-weight: normal;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            height: 40px;
            padding: 8px 10px;
            border: 1px solid #aaa;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #555;
        }

        .remember {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .remember input {
            margin-right: 8px;
        }

        .remember label {
            margin: 0;
            font-weight: normal;
        }

        button {
            width: 100%;
            height: 42px;
            border: none;
            background: #333;
            color: white;
            font-size: 14px;
            cursor: pointer;
        }

        button:hover {
            background: #222;
        }
    </style>
</head>

<body>

<div class="page">

    <div class="login-box">

        <h1>Login</h1>

        <form method="POST" action="login.php">

            <div class="form-group">
                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <div class="remember">
                <input
                    type="checkbox"
                    id="stay_logged_in"
                    name="stay_logged_in"
                >

                <label for="stay_logged_in">
                    Stay logged in
                </label>
            </div>

            <button type="submit">
                Log in
            </button>

        </form>

    </div>

</div>

</body>
</html>
