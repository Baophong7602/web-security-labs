<?php

session_start();

/*
 * =========================
 * LOGIC
 * =========================
 */

$username = $_SESSION["username"] ?? null;


/*
 * Kiểm tra đăng nhập
 */

if ($username === null) {

    header("Location: /login.php");

    exit;

}

?>


<!-- =========================
     GIAO DIỆN
     ========================= -->

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>My Account</title>

    <style>

        body {

            font-family: Arial, sans-serif;

            width: 700px;

            margin: 60px auto;

        }

        .account {

            border: 1px solid #ccc;

            padding: 25px;

        }

        .delete {

            margin-top: 30px;

        }

        button {

            padding: 10px 20px;

            background: #c00;

            color: white;

            border: none;

        }

    </style>

</head>


<body>


<h1>My Account</h1>


<div class="account">


    <p>

        Username:

        <strong>

            <?= htmlspecialchars($username) ?>

        </strong>

    </p>


    <p>

        You are currently logged in.

    </p>


    <div class="delete">


        <form

            method="POST"

            action="/delete-account.php"

        >

            <button type="submit">

                Delete account

            </button>

        </form>


    </div>


</div>


<p>

    <a href="/">

        Back to blog

    </a>

</p>


</body>

</html>