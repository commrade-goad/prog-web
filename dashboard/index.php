<?php
session_start();
if (!isset($_SESSION["start"])) {
    echo "<script>window.location=\"/login\"</script>";
}
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Dashboard</title>
        <link rel="stylesheet" href="/css/style.css" />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
        crossorigin="anonymous"
    />
    </head>

    <body class="dark-bg-custom">
        <div id="header">
            <?php
            include '../php-component/header.php';
            ?>
        </div>
        <div id="sidebar">
            <?php
            include '../php-component/sidebar.php';
            ?>
        </div>
        <div class="content">
            <!-- <h1>Hello, world!</h1> -->
            <!-- <h1>Generate PDF</h1> -->
            <!-- <button id="generate-pdf">Generate PDF</button> -->
            <div id="content-real">
                <?php
                include '../php-component/table.php';
                include '../php-component/table-handle.php';
                if (isset($_GET["tview"])) {
                    if ($_GET["tview"] == "all") {
                        $dest = "/dashboard/?tview=all";
                        $_SESSION["location"] = $dest;
                        if ($_SESSION["user type"] == 1) {
                            echo "<div class='table-start' id='table-pos'>";
                            makeTable($dest);
                            echo "</div>";
                        } else {echo "<h1>Illegal access.</h1>";}
                    } else {
                        if (isset($_SESSION["displayed"])) {
                            unset($_SESSION["displayed"]);
                        }
                    }
                } else {
                    if (isset($_SESSION["displayed"])) {
                        unset($_SESSION["displayed"]);
                    }
                }
                ?>
            </div>
            <script src="/js/jspdf.umd.min.js"></script>
            <script src="/js/html2canvas.min.js"></script>
            <script type="module" src="/js/print.js"></script>
        </div>
        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"
    ></script>
    </body>
</html>
