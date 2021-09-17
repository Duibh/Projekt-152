<?php

$server = "localhost";
$user = "php-user";
$password = "!1KNCb]T_cILgk6T";
$database = "wildlife_social";
$db_conn = mysqli_connect($server, $user, $password, $database);

if (isset($_POST['submit'])) {

    $newFileName = $_POST['filename'];
    if (empty($newFileName)) {
        $newFileName = "gallery";
    } else {
        $newFileName = strtolower(str_replace(" ", "-", $newFileName));
    }
    $imageTitle = $_POST['filetitle'];
    $imageDesc = $_POST['filedesc'];

    $file = $_FILES['file'];

    $fileName = $file["name"];
    $fileType = $file["type"];
    $fileTempName = $file["tmp_name"];
    $fileError = $file["error"];
    $fileSize = $file["size"];

    $fileExt = explode(".", $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array("jpg", "jpeg", "png");

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError == 0) {
            if ($fileSize < 50000) {
                $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
                $fileDestination = "../images/gallery/" . $imageFullName;

//                include_once "db_connects.php";

                if (empty($imageTitle) || empty($imageDesc)) {
                    header("Location: ../gallery.php");
                    exit();
                } else {
                    $sql = "SELECT * FROM pictures;";
                    $conn = mysqli_stmt_init($db_conn);
                    if (!mysqli_stmt_prepare($conn,$sql)) {
                        echo "SQL statement has failed!";
                    } else {
                        mysqli_stmt_execute($conn);
                        $sql = "INSERT INTO pictures (title, description, filename) VALUES (?,?,?);";
                        if (!mysqli_stmt_prepare($conn,$sql)) {
                            echo "SQL statement has failed!";
                        } else {
                            mysqli_stmt_bind_param($conn, "sss", $imageTitle, $imageDesc, $imageFullName);
                            mysqli_stmt_execute($conn);

                            move_uploaded_file($fileTempName, $fileDestination);

                            header("Location: ../gallery.php");
                        }
                    }
                }
            } else {
                echo "File size is over 50MB!";
                exit();
            }
        } else {
            echo "An error has occured!";
            exit();
        }
    } else {
        echo "File type not allowed.";
        exit();
    }

}
