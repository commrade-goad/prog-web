<?php
function render() {
    $name = $_SESSION["user name"];
    echo "<h3 class='fw-bold'>Hello $name.</h3>";
    // echo "<h5>Tanpa keberanian, tak ada kemenangan. Tanpa perjuangan, tak ada happy ending.</h5>";
    echo "<h5>RULES ARE MADE TO BE BROKEN.</h5>";
    echo "<hr>";
    echo "<form method='post' action='/dashboard/'>";
    echo "<span style='margin-right:10px' class='fw-bold'>Action : </span>";
    echo "<button type='submit' name='tbeli' class='table-button p-2'>Tambah Pembelian</button>";
    echo "<button type='submit' name='tjual' class='table-button p-2'>Tambah Penjualan</button>";
    echo "</form>";
    echo "<hr>";
    echo "<select id='overview' class='mb-2 overview-option' name='overview'>";
    echo "<option value='all' default>All</option>";
    echo "<option value='week'>Weekly</option>";
    echo "<option value='month'>Monthly</option>";
    echo "<option value='year'>Annually</option>";
    echo "</select>";
    echo "<script src='/js/watch_overview.js'></script>";

    // handle nuel
    $dest = "/dashboard/";
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
    echo "<hr>";

    if (isset($_POST["tbeli"])) {
        $item = array(
           "nobeli", "kodeitem", "qty", "hargabeli", "stok", "noref", "tanggal", "kodepemasok", "keterangan", "koderekening",
           "totalbayar" 
        );

        $item_t = array(
            "text", "text", "number", "number", "number", "text", "date", "text", "text", "text",
            "number"
        );
        $stuff = new SqlItem();
        $result = $stuff->gen_object($item, $item_t);
        make_form("Pembelian", $dest, "submit-tbeli", $result);
    }
    if (isset($_POST["tjual"])) {
        $item = array(
           "nojual", "kodeitem", "qty", "hargajual", "stok", "tanggal", "kodepelanggan", "total", "keterangan",
           "totalbayar", "koderekening" 
        );

        $item_t = array(
            "text", "text", "number", "number", "number", "date", "text", "number", "text", "number",
            "text"
        );
        $stuff = new SqlItem();
        $result = $stuff->gen_object($item, $item_t);
        make_form("Penjualan", $dest, "submit-tjual", $result);
    }

    handle_req_sec("submit-tjual", "submit-tbeli");
}

function handle_req_sec($jual, $beli) {
    if (isset($_POST[$jual])) {
        echo "JUALANNNNN";
    }
    if (isset($_POST[$beli])) {
        echo "DUIT HABIS";
    }
    /* if ($table_name == "djual") {
            $sec_query = "insert into hjual (nojual, tanggal, kodepelanggan, total, keterangan) values ('" . $_POST["nojual"] . "', DATE()";
            $sec_query = $sec_query . ", '-', " . $_POST["qty"] * $_POST["hargajual"] . ", '-')";
            $db->query($sec_query);
            $third_query = "insert into dbayarjual (nojual, tanggal, totalbayar, keterangan, koderekening) values ('" . $_POST["nojual"] . "', DATE()";
            $third_query = $third_query . ", " . $_POST["qty"] * $_POST["hargajual"] . ", '-', '-')";
            $db->query($third_query);
        }
        if ($table_name == "dbeli") {
            $sec_query = "insert into hbeli (nobeli, noref, tanggal, kodepemasok, total, keterangan) values ('" . $_POST["nobeli"] . "', '-', DATE()";
            $sec_query = $sec_query . ", '-', " . $_POST["qty"] * $_POST["hargabeli"] . ", '-')";
            $db->query($sec_query);
            $third_query = "insert into dbayarjual (nobeli, tanggal, totalbayar, keterangan, koderekening) values ('" . $_POST["nobeli"] . "', DATE()";
            $third_query = $third_query . ", " . $_POST["qty"] * $_POST["hargajual"] . ", '-', '-')";
            $db->query($third_query);
        } */
}

function make_form($name, $dest, $handle, $item) {
    echo "<div class='float-me-sec' id='popup'>";
    echo "<h3>Tambah $name</h3>";
    echo "<form method='post' action='$dest'>";
    $counter = 0;
    echo "<div class='form-start'>";
    for ($i=0; $i < count($item); $i++) {
        if ($counter >= 4) {
            $counter = 0;
            echo "</div>";
        }
        if ($counter <= 0) {
            echo "<div class='spacer'>";
        }
        $type = $item[$i]->type;
        $name = $item[$i]->name;
        echo "<div class='form-input'>";
        if ($name != "no" && $name != "nogenerate") {
            echo "<label for='$name'>$name: </label><br/>";
            echo "<input type='$type' name='$name'>";
            $counter += 1;
        }
        echo "</div>";
    }
    if ($counter > 0 && $counter < 4) {
        echo "</div>";
    }
    echo "</div>";
    echo "<br/><input class='c-text-bold c-bg-green' type='submit' name='$handle' value='Submit'>";
    echo "<br/><input class='c-text-bold c-bg-secondary' type='submit' name='cancel' value='Cancel'><br/>";
    echo "</form>";
    echo "</div>";
}
?>
