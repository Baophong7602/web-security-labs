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

    /*
    CODE LỖI - VULNERABLE
    */

    // Lấy tên file do người dùng cung cấp
    // $filename = $_FILES['avatar']['name'];

    // File tạm mà PHP tạo ra khi upload
    // $tmpFile = $_FILES['avatar']['tmp_name'];

    // LỖI:
    // Không kiểm tra extension
    // Không kiểm tra MIME type
    // Không đổi tên file
    // File người dùng upload được lưu trực tiếp vào uploads
    // $uploadPath = __DIR__ . "/uploads/" . $filename;

    // if (move_uploaded_file($tmpFile, $uploadPath)) {

    //     echo "<h2>Upload successful</h2>";

    //     echo "<p>File name: ";
    //     echo htmlspecialchars($filename);
    //     echo "</p>";

    //     echo "<p>";
    //     echo "<a href='my-account.php'>Back to My Account</a>";
    //     echo "</p>";

    // } else {

    //     echo "Upload failed.";

    // }


    /*
    CODE FIX

    */

    
    // FIX 1: Kiểm tra lỗi upload
    if ($_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed.");
    }

    $filename = $_FILES['avatar']['name'];
    $tmpFile = $_FILES['avatar']['tmp_name'];


    // FIX 2: Chỉ cho phép extension cần thiết
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    $extension = strtolower(
        pathinfo($filename, PATHINFO_EXTENSION)
    );

    if (!in_array($extension, $allowedExtensions, true)) {
        die("Invalid file type.");
    }


    // FIX 3: Kiểm tra MIME type thực tế
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    $mimeType = finfo_file($finfo, $tmpFile);

    finfo_close($finfo);

    $allowedMimeTypes = [
        'image/jpeg',
        'image/png'
    ];

    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        die("Invalid MIME type.");
    }


    // FIX 4: Không sử dụng trực tiếp tên file do người dùng cung cấp
    // Server tự tạo tên file mới
    $newFilename = bin2hex(random_bytes(16)) . '.' . $extension;


    // FIX 5: Lưu file bằng tên do server tạo
    $uploadPath = __DIR__ . "/uploads/" . $newFilename;


    if (move_uploaded_file($tmpFile, $uploadPath)) {

        echo "<h2>Upload successful</h2>";

        echo "<p>File name: ";
        echo htmlspecialchars($newFilename);
        echo "</p>";

        echo "<p>";
        echo "<a href='my-account.php'>Back to My Account</a>";
        echo "</p>";

    } else {

        echo "Upload failed.";

    }
    

}
?>