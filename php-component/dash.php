<?php
function render() {
    $name = $_SESSION["user name"];
    echo "<h3 class='fw-bold'>Hello $name.</h3>";
    // echo "<h5>Tanpa keberanian, tak ada kemenangan. Tanpa perjuangan, tak ada happy ending.</h5>";
    echo "<h5>RULES ARE MADE TO BE BROKEN.</h5>";
    echo "<hr>";
    echo "<select id='overview' class='mb-2 overview-option' name='overview'>";
    echo "<option value='all' default>All</option>";
    echo "<option value='week'>Weekly</option>";
    echo "<option value='month'>Monthly</option>";
    echo "<option value='year'>Annually</option>";
    echo "</select>";
    echo "<script src='/js/watch_overview.js'></script>";

    // handle nuel
    $dest = "/dashboard";
    $cando = false;
    $_SESSION["location"] = $dest;
    if (isset($_GET["overview"])) {
        $mode = $_GET["overview"];
        makeSingleTable($dest, "dbayarjual", $cando, $mode);
        makeSingleTable($dest, "dbayarbeli", $cando, $mode);
    } else {
        makeSingleTable($dest, "dbayarjual", $cando);
        makeSingleTable($dest, "dbayarbeli", $cando);
    }
}
?>
