<?php
function connect_db() {
    $db = new SQLite3('../db/database.db');
    return $db;
}

function makeTable() {
    $db = connect_db();
    // item
    echo "<h3>ITEM</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>kodeitem</th>";
    echo "<th>nama</th>";
    echo "<th>hargabeli</th>";
    echo "<th>hargajual</th>";
    echo "<th>stok</th>";
    echo "<th>satuan</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from item;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["kodeitem"] . "</td>";
        echo "<td>" . $row["nama"] . "</td>";
        echo "<td>" . $row["hargabeli"] . "</td>";
        echo "<td>" . $row["hargajual"] . "</td>";
        echo "<td>" . $row["stok"] . "</td>";
        echo "<td>" . $row["satuan"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    
    // pemasok
    echo "<h3>PEMASOK</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>kodepemasok</th>";
    echo "<th>namapemasok</th>";
    echo "<th>alamat</th>";
    echo "<th>kota</th>";
    echo "<th>telpon</th>";
    echo "<th>email</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from pemasok;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["kodepemasok"] . "</td>";
        echo "<td>" . $row["namapemasok"] . "</td>";
        echo "<td>" . $row["alamat"] . "</td>";
        echo "<td>" . $row["kota"] . "</td>";
        echo "<td>" . $row["telpon"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    
    // pelanggan 
    echo "<h3>PELANGGAN</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>kodepelanggan</th>";
    echo "<th>namapelanggan</th>";
    echo "<th>alamat</th>";
    echo "<th>kota</th>";
    echo "<th>telpon</th>";
    echo "<th>email</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from pelanggan;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["kodepelanggan"] . "</td>";
        echo "<td>" . $row["namapelanggan"] . "</td>";
        echo "<td>" . $row["alamat"] . "</td>";
        echo "<td>" . $row["kota"] . "</td>";
        echo "<td>" . $row["telpon"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // rekening
    echo "<h3>Rekening</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>koderekening</th>";
    echo "<th>namarekening</th>";
    echo "<th>saldo</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from rekening;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["koderekening"] . "</td>";
        echo "<td>" . $row["namarekening"] . "</td>";
        echo "<td>" . $row["saldo"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // hjual
    echo "<h3>HJUAL</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>nojual</th>";
    echo "<th>tanggal</th>";
    echo "<th>kodepelanggan</th>";
    echo "<th>total</th>";
    echo "<th>keterangan</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from hjual;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["nojual"] . "</td>";
        echo "<td>" . $row["tanggal"] . "</td>";
        echo "<td>" . $row["kodepelanggan"] . "</td>";
        echo "<td>" . $row["total"] . "</td>";
        echo "<td>" . $row["keterangan"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // djual
    echo "<h3>DJUAL</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>nogenerate</th>";
    echo "<th>nojual</th>";
    echo "<th>kodeitem</th>";
    echo "<th>qty</th>";
    echo "<th>hargajual</th>";
    echo "<th>stok</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from djual;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["nogenerate"] . "</td>";
        echo "<td>" . $row["nojual"] . "</td>";
        echo "<td>" . $row["kodeitem"] . "</td>";
        echo "<td>" . $row["qty"] . "</td>";
        echo "<td>" . $row["hargajual"] . "</td>";
        echo "<td>" . $row["stok"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // hbeli
    echo "<h3>HBELI</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>nobeli</th>";
    echo "<th>noref</th>";
    echo "<th>tanggal</th>";
    echo "<th>kodepemasok</th>";
    echo "<th>total</th>";
    echo "<th>keterangan</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from hbeli;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["nobeli"] . "</td>";
        echo "<td>" . $row["noref"] . "</td>";
        echo "<td>" . $row["tanggal"] . "</td>";
        echo "<td>" . $row["kodepemasok"] . "</td>";
        echo "<td>" . $row["total"] . "</td>";
        echo "<td>" . $row["keterangan"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // dbeli
    echo "<h3>DBELI</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>nogenerate</th>";
    echo "<th>nobeli</th>";
    echo "<th>kodeitem</th>";
    echo "<th>qty</th>";
    echo "<th>hargabeli</th>";
    echo "<th>stok</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from dbeli;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["nogenerate"] . "</td>";
        echo "<td>" . $row["nobeli"] . "</td>";
        echo "<td>" . $row["kodeitem"] . "</td>";
        echo "<td>" . $row["qty"] . "</td>";
        echo "<td>" . $row["hargabeli"] . "</td>";
        echo "<td>" . $row["stok"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    
    // dbayarjual
    echo "<h3>DBAYARJUAL</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>no</th>";
    echo "<th>nojual</th>";
    echo "<th>tanggal</th>";
    echo "<th>totalbayar</th>";
    echo "<th>keterangan</th>";
    echo "<th>koderekening</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from dbayarjual;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["no"] . "</td>";
        echo "<td>" . $row["nojual"] . "</td>";
        echo "<td>" . $row["tanggal"] . "</td>";
        echo "<td>" . $row["totalbayar"] . "</td>";
        echo "<td>" . $row["keterangan"] . "</td>";
        echo "<td>" . $row["koderekening"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    
    // dbayarbeli
    echo "<h3>DBAYARBELI</h3>";
    echo "<table class='table table-dark'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>no</th>";
    echo "<th>nobeli</th>";
    echo "<th>tanggal</th>";
    echo "<th>totalbayar</th>";
    echo "<th>keterangan</th>";
    echo "<th>koderekening</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    $results = $db->query("select * from dbayarbeli;");
    while ($row= $results->fetchArray()) {
        echo "<tr>";
        echo "<td>" . $row["no"] . "</td>";
        echo "<td>" . $row["nobeli"] . "</td>";
        echo "<td>" . $row["tanggal"] . "</td>";
        echo "<td>" . $row["totalbayar"] . "</td>";
        echo "<td>" . $row["keterangan"] . "</td>";
        echo "<td>" . $row["koderekening"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
}

?>
