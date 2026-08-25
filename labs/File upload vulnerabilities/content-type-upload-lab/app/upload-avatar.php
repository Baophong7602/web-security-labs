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

$filename = basename($file["name"]);



if (
    $file["type"] !== "image/jpeg" &&
    $file["type"] !== "image/png"
) {

    die("Invalid file type");
}



$uploadPath = __DIR__ . "/uploads/" . $filename;


if (move_uploaded_file(
    $file["tmp_name"],
    $uploadPath
)) {

    echo "<h2>Upload successful</h2>";

    echo "<p>File uploaded:</p>";

    echo "<a href='uploads/"
        . htmlspecialchars($filename)
        . "'>"
        . htmlspecialchars($filename)
        . "</a>";

    echo "<br><br>";

    echo "<a href='my-account.php'>";
    echo "Back to My Account";
    echo "</a>";

} else {

    echo "Upload failed";
}

?>