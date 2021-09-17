<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gallery</title>
    <link href="https://allfont.net/allfont.css?fonts=pt-sans-narrow" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style/styles.css">
    <script src="js/main.js"></script>
</head>
<body>
<?php include_once("template_pageTop.php"); ?>
<div id="pageMiddle">

    <section class="displays">
        <div class="wrapper">
            <h2>Gallery</h2>

            <div class="gallery-element">
                <?php
                $server = "localhost";
                $user = "php-user";
                $password = "!1KNCb]T_cILgk6T";
                $database = "wildlife_social";
                $db_conn = mysqli_connect($server, $user, $password, $database);

                $sql = "SELECT * FROM pictures";
                $stmt = mysqli_stmt_init($db_conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL statement has failed!";
                } else {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<a href="#">
                            <div style="background-image: url(images/gallery/'.$row["filename"].');"></div>
                            <h3>'.$row["title"].'</h3>
                            <p>'.$row["description"].'</p>
                        </a>';
                    }
                }

                ?>
            </div>

            <br>

            <div class="gallery-upload">
                <form action="php_includes/gallery_upload.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="filename" placeholder="File name">
                    <input type="text" name="filetitle" placeholder="Image title">
                    <input type="text" name="filedesc" placeholder="Image description">
                    <input type="file" name="file" placeholder="Upload">
                    <button type="submit" name="submit">Upload</button>
                </form>
            </div>

        </div>
    </section>
    &nbsp;
</div>
<?php include_once("template_pageBottom.php"); ?>
</body>
</html>