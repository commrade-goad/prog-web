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
            include '../php-component/table.php';
            include '../php-component/sidebar.php';
            ?>
        </div>
        <div class="content">
            <!-- <h1>Hello, world!</h1> -->
            <!-- <h1>Generate PDF</h1> -->
            <!-- <button id="generate-pdf">Generate PDF</button> -->
            <div id="content-real">
                <?php
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
                        $found = false;
                        for ($i=0; $i < count($_SESSION["table name"]); $i++) { 
                            $current = $_SESSION["table name"][$i];
                            if ($current == $_GET["tview"]) {
                                $found = true;
                                $dest = "/dashboard/?tview=$current";
                                $_SESSION["location"] = $dest;
                                if ($_SESSION["user type"] == 1) {
                                    makeSingleTable($dest, $current, true);
                                } else {
                                    makeSingleTable($dest, $current, false);
                                }
                            } 
                        }
                        if (isset($_SESSION["displayed"]) && $found == false) {
                            unset($_SESSION["displayed"]);
                        }
                    }
                } elseif (isset($_GET["acc"])) {
                    if ($_GET["acc"] == "profile") {
                        echo "<div class='d-flex justify-content-center'>";
                        echo "<p><b><i class='nf nf-fa-user'></i> username : </b>" . $_SESSION["user name"] . "</p>";
                        echo "</div>";
                        echo "<div class='d-flex justify-content-center'>";
                        echo "<p><b><i class='nf nf-md-email_open'></i> email : </b>" . $_SESSION["user email"] . "</p>";
                        echo "</div>";
                        echo "<div class='d-flex justify-content-center'>";
                        echo "<p><b><i class='nf nf-cod-type_hierarchy'></i> type : </b>" . $_SESSION["user type"];
                        if ($_SESSION["user type"] == 1) {
                            echo " (Admin)";
                        } else {
                            echo " (User)";
                        }
                        echo "</p>";
                        echo "</div>";
                        echo "<div class='d-flex justify-content-center'>";
                        echo "<iframe width='560' height='315' src='https://www.youtube.com/embed/dQw4w9WgXcQ?si=Dt0HesjU21EEhOV6' title='YouTube video player' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' referrerpolicy='strict-origin-when-cross-origin' allowfullscreen></iframe>";
                        echo "</div>";
                    } elseif ($_GET["acc"] = "settings") {
                        include "../php-component/acc-settings.php";
                        $dest = "/dashboard/?acc=settings";
                        renderAccSettings($dest);
                    } else {
                        if (isset($_SESSION["displayed"])) {
                            unset($_SESSION["displayed"]);
                        }
                    }

                } elseif (isset($_GET["action"])) {
                    include "../php-component/action.php";
                    render_action("hjual");
                } else {
                    if (isset($_SESSION["displayed"])) {
                        unset($_SESSION["displayed"]);
                    }
                    include "../php-component/dash.php";
                    render();
                }
                ?>
            </div>
            <script src="/js/jspdf.umd.min.js"></script>
            <script src="/js/html2canvas.min.js"></script>
            <!-- <script type="module" src="/js/print.js"></script> -->
        </div>
        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"
    ></script>
    </body>
</html>
