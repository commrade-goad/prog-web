<?php
session_start();
if (!isset($_SESSION["start"])) {
    echo "<script>window.location=\"index.php\"</script>";
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Bootstrap demo</title>
        <link rel="stylesheet" href="style.css" />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous"
    />
    </head>

    <body>
        <div id="header"></div>
        <div id="sidebar"></div>
        <div class="content">
            <h1>Hello, world!</h1>
            <h1>Generate PDF</h1>
            <div id="content-real">
            </div>
            <button id="generate-pdf">Generate PDF</button>
            <script src="./js/jspdf.umd.min.js"></script>
            <script src="./js/html2canvas.min.js"></script>
            <script type="module" src="js/print.js"></script>
        </div>
        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"
    ></script>
        <script src="js/c-header.js"></script>
        <script src="js/c-sidebar.js"></script>
    </body>
</html>
