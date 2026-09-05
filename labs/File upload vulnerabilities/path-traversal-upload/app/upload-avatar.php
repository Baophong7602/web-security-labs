<?php 
 
session_start(); 
 
if (!isset($_SESSION["username"])) { 
    http_response_code(403); 
    die("You must login first."); 
} 
 
if ($_SERVER["REQUEST_METHOD"] !== "POST") { 
    http_response_code(405); 
    die("Method not allowed."); 
} 
 
if (!isset($_FILES["avatar"])) { 
    die("No file uploaded."); 
} 
 
$file = $_FILES["avatar"]; 
 
$filename = urldecode($file["name"]);

// Thư mục upload
$uploadDir = __DIR__ . "/files/avatars/"; 
 
// LỖ HỔNG PATH TRAVERSAL:
// filename do người dùng kiểm soát được nối trực tiếp
// vào đường dẫn lưu file.
$target = $uploadDir . $filename;


 
// if (strpos($filename, "..") !== false) {
//     die("Invalid file name.");
// }


if (move_uploaded_file($file["tmp_name"], $target)) { 
 
    echo "The file avatars/" . 
         htmlspecialchars($filename) . 
         " has been uploaded."; 
 
} else { 
 
    echo "Upload failed."; 
}