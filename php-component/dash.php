<?php
function render() {
    $name = $_SESSION["user name"];
    echo "<h3 class='fw-bold'>Hello $name.</h3>";
    // echo "<h5>Tanpa keberanian, tak ada kemenangan. Tanpa perjuangan, tak ada happy ending.</h5>";
    echo "<h5>RULES ARE MADE TO BE BROKEN.</h5>";
    echo "<hr>";
    echo "<form method='get' action='/dashboard/'>";
    echo "<span style='margin-right:10px' class='fw-bold'>Action : </span>";
    echo "<button type='submit' name='action' class='table-button p-2' value='beli'>Tambah Pembelian</button>";
    echo "<button type='submit' name='action' class='table-button p-2' value='jual'>Tambah Penjualan</button>";
    echo "</form>";
    echo "<hr>";
    echo "<span style='margin-right:10px' class='fw-bold'>Range : </span>";
    echo "<select id='overview' class='mb-2 overview-option' name='overview'>";
    echo "<option value='all' default>All</option>";
    echo "<option value='week'>This Week / Weekly</option>";
    echo "<option value='month'>This Month / Monthly</option>";
    echo "<option value='year'>This Year / Annualy</option>";
    echo "</select>";
    echo "<script src='/js/watch_overview.js'></script>";

    // handle nuel
    $dest = "/dashboard/";
    $cando = false;
    $_SESSION["location"] = $dest;
    if (isset($_GET["overview"])) {
        $mode = $_GET["overview"];
        makeSingleTable($dest, "dbayarjual", $cando, $mode);
        makeSingleTable($dest, "hjual", $cando, $mode);
        makeSingleTable($dest, "dbayarbeli", $cando, $mode);
        makeSingleTable($dest, "hbeli", $cando, $mode);
        echo "<hr>";
        if ($mode == "week") {
            $new_t = array("weeks", "total", "count");
            create_rev_tab($new_t,"SELECT strftime('%Y-%W', tanggal) as weeks, SUM(totalbayar) as total, COUNT(nojual) as count FROM dbayarjual GROUP BY weeks ORDER BY weeks");
            $new_t2 = array("weeks", "total", "count");
            create_rev_tab($new_t2,"SELECT strftime('%Y-%W', tanggal) as weeks, SUM(totalbayar) as total, COUNT(nobeli) as count FROM dbayarbeli GROUP BY weeks ORDER BY weeks", "Expense");
        } elseif ($mode == "month") {
            $new_t = array("months", "total", "count");
            create_rev_tab($new_t,"SELECT strftime('%Y-%m', tanggal) as months, SUM(totalbayar) as total, COUNT(nojual) as count FROM dbayarjual GROUP BY months ORDER BY months");
            $new_t2 = array("months", "total", "count");
            create_rev_tab($new_t2,"SELECT strftime('%Y-%m', tanggal) as months, SUM(totalbayar) as total, COUNT(nobeli) as count FROM dbayarbeli GROUP BY months ORDER BY months", "Expense");
        } elseif ($mode == "year") {
            $new_t = array("years", "total", "count");
            create_rev_tab($new_t,"SELECT strftime('%Y', tanggal) as years, SUM(totalbayar) as total, COUNT(nojual) as count FROM dbayarjual GROUP BY years ORDER BY years");
            $new_t2 = array("years", "total", "count");
            create_rev_tab($new_t2,"SELECT strftime('%Y', tanggal) as years, SUM(totalbayar) as total, COUNT(nobeli) as count FROM dbayarbeli GROUP BY years ORDER BY years", "Expense");
        } else {
            echo "<p>Something no information is better than information.</p>";
        }
        echo "<hr>";
    } else {
        makeSingleTable($dest, "dbayarjual", $cando);
        makeSingleTable($dest, "hjual", $cando);
        makeSingleTable($dest, "dbayarbeli", $cando);
        makeSingleTable($dest, "hbeli", $cando);
        echo "<hr>";
    }



    if (isset($_POST["tbeli"])) {
        $item = array(
           "nobeli", "kodeitem", "qty", "hargabeli", "stok", "total", "noref", "tanggal", "kodepemasok", "keterangan", "koderekening",
           "totalbayar" 
        );

        $item_t = array(
            "text", "text", "number", "number", "number", "number", "text", "date", "text", "text", "text",
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

function create_rev_tab($item, $query, $title="Revenue"){
    echo "<div class='table-responsive'>";
    echo "<h3>$title</h3>";
    echo "<table class='table table-dark table-striped'>";
    echo "<thead>";
    echo "<tr>";
    for ($j=0; $j < count($item); $j++) { 
        echo "<th>" . $item[$j] . "</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    $db = connect_db();
    $result = $db->query($query); 
    while ($row = $result->fetchArray()) {
        echo "<tr>";
        for ($j=0; $j < count($item); $j++) { 
            echo "<td>" . $row[$item[$j]] . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}

function handle_req_sec($jual, $beli) {
    if (isset($_POST[$jual])) {
        $db = connect_db();
        $nojual = $_POST["nojual"];
        $kodeitem = $_POST["kodeitem"];
        $qty = $_POST["qty"];
        $hargajual = $_POST["hargajual"];
        $stok = $_POST["stok"];
        $tanggal = $_POST["tanggal"];
        $kodepelanggan = $_POST["kodepelanggan"];
        $total = $_POST["total"];
        $keterangan = $_POST["keterangan"];
        $totalbayar = $_POST["totalbayar"];
        $koderekening = $_POST["koderekening"];
        $str = "insert into djual (nojual, kodeitem, qty, hargajual, stok) values ('$nojual', '$kodeitem', $qty, $hargajual, $stok)";
        $db->query($str);
        $str = "insert into hjual (nojual, tanggal, kodepelanggan, total, keterangan) values ('$nojual', '$tanggal', '$kodepelanggan', $total, '$keterangan')";
        $db->query($str);
        $str = "insert into dbayarjual (nojual, tanggal, totalbayar, keterangan, koderekening) values ('$nojual', '$tanggal', $totalbayar, '$keterangan', '$koderekening')";
        $db->query($str);
    }
    if (isset($_POST[$beli])) {
        $db = connect_db();
        $nobeli = $_POST["nobeli"];
        $kodeitem = $_POST["kodeitem"];
        $qty= $_POST["qty"];
        $hargabeli = $_POST["hargabeli"];
        $total = $_POST["total"];
        $stok = $_POST["stok"];
        $noref = $_POST["noref"];
        $tanggal = $_POST["tanggal"];
        $kodepemasok = $_POST["kodepemasok"];
        $keterangan = $_POST["keterangan"];
        $koderekening = $_POST["koderekening"];
        $totalbayar = $_POST["totalbayar"];

        $str = "insert into dbeli (nobeli, kodeitem, qty, hargabeli, stok) values ('$nobeli', '$kodeitem', $qty, $hargabeli, $stok)";
        $db->query($str);
        $str = "insert into hbeli (nobeli, noref, tanggal, kodepemasok, total, keterangan) values ('$nobeli', '$noref', '$tanggal', '$kodepemasok', $total, '$keterangan')";
        $db->query($str);
        $str = "insert into dbayarbeli (nobeli, tanggal, totalbayar, keterangan, koderekening) values ('$nobeli', '$tanggal', $totalbayar, '$keterangan', '$koderekening')";
        $db->query($str);
    }
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
            if ($name == "qty" || $name == "hargajual" || $name == "hargabeli") {
                echo "<input type='$type' name='$name' id='$name'>";
            } elseif ($name == "total") {
                echo "<input type='$type' name='$name' id='$name' readonly>";
            } else {
                echo "<input type='$type' name='$name'>";
            }
            $counter += 1;
        }
        echo "</div>";
    }
    if ($counter > 0 && $counter <= 4) {
        echo "</div>";
    }
    echo "</div>";
    echo "<br/><input class='c-text-bold c-bg-green' type='submit' name='$handle' value='Submit'>";
    echo "<br/><input class='c-text-bold c-bg-secondary' type='submit' name='cancel' value='Cancel'><br/>";
    echo "</form>";
    echo "</div>";
    echo "<script src='../js/gen_total.js'></script>";
}
?>
