<?php

$users = [
    "appserver" => "michael"
];

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";


    /*
    Lỗi:
    - Username không tồn tại và username tồn tại nhưng sai password
      trả về response khác nhau.
    - Attacker có thể dựa vào message/response length để biết username hợp lệ.
    */


    
    if (!isset($users[$username])) {

        // Username không tồn tại
        $message = "Invalid username or password.";

    } elseif ($users[$username] !== $password) {

        // Username tồn tại nhưng password sai
        $message = "Invalid username or password ";

    } else {

        header("Location: success.php");
        exit;

    }
    


    /*
    FIXED CODE 
   
    */

    // if (!isset($users[$username]) || $users[$username] !== $password) {

    //     // Không tiết lộ username có tồn tại hay không
    //     $message = "Invalid username or password.";

    // } else {

    //     header("Location: success.php");
    //     exit;

    // }

}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

<h2>Login</h2>


<?php if ($message): ?>

    <p><?= htmlspecialchars($message) ?></p>

<?php endif; ?>


<form method="POST">

    <input
        type="text"
        name="username"
        placeholder="Username"
        required
    >

    <br><br>


    <input
        type="password"
        name="password"
        placeholder="Password"
        required
    >

    <br><br>


    <button type="submit">
        Login
    </button>

</form>


</body>

</html>