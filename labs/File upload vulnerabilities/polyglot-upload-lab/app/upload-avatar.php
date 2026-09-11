<?php

    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (!isset($_FILES["avatar"])) {

            $message = "No file uploaded";

        } else {

            $file = $_FILES["avatar"];

            if ($file["error"] !== UPLOAD_ERR_OK) {

                $message = "Upload failed";

            }

            /*
            * Kiểm tra nội dung file có phải hình ảnh hay không.
            */
            elseif (@getimagesize($file["tmp_name"]) === false) {

                $message = "Invalid image";

            } else {

                /*
                 CODE Hỏng               
                */

                $filename = basename($file["name"]);

                $destination = __DIR__ . "/files/" . $filename;

                if (move_uploaded_file(
                    $file["tmp_name"],
                    $destination
                )) {

                    $_SESSION["avatar"] = "/files/" . $filename;
                    $message = "Upload successful";

                } else {

                    $message = "Upload failed";
                }


                /*
                * CODE FIX 
                */
                
                // $filename = basename($file["name"]);
                // $extension = strtolower(
                //     pathinfo($filename, PATHINFO_EXTENSION)
                // );
                
                // $allowed = [
                //     "jpg",
                //     "jpeg",
                //     "png",
                // ];
                // if (!in_array($extension, $allowed, true)) {

                //     http_response_code(200);
                //     header("Content-Type: text/plain");
                //     exit("Invalid file type");
                // }
                // if (preg_match('/\.php(?:\.|$)/i', $filename)) {

                //     http_response_code(200);
                //     header("Content-Type: text/plain");
                //     exit("Invalid file type");
                // }
                // $destination = __DIR__ . "/files/" . $filename;

                // if (move_uploaded_file(
                //     $file["tmp_name"],
                //     $destination
                // )) {

                //     $_SESSION["avatar"] = "/files/" . $filename;
                //     $message = "Upload successful";

                // } else {

                //     http_response_code(200);
                //     header("Content-Type: text/plain");
                //     exit("Upload failed");
                // }
                

            }
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Upload Avatar</title>
    </head>

    <body>

    <h2>Upload Avatar</h2>

    <?php if ($message): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <input
            type="file"
            name="avatar"
            accept="image/*"
            required
        >

        <br><br>

        <button type="submit">
            Upload
        </button>

    </form>

    <br>

    <a href="my-account.php">
        Back to My Account
    </a>

    </body>

    </html>
