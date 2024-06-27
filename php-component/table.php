<?php
function get_table_name():void {
    $ret = array("item", "pemasok", "pelanggan", "rekening", "hjual", "djual", "hbeli", "dbeli", "dbayarjual", "dbayarbeli");
    $_SESSION["table name"] = $ret;
}

get_table_name();

function connect_db() {
    $db = new SQLite3('../db/database.db');
    return $db;
}

function add_data(&$table_name, &$template, &$template_t) {
    $table_name = $_SESSION["table name"];
    $template = array(
        array("kodeitem", "nama", "hargabeli", "hargajual", "stok", "satuan"),
        array("kodepemasok", "namapemasok", "alamat", "kota", "telepon", "email"),
        array("kodepelanggan", "namapelanggan", "alamat", "kota", "telepon", "email"),
        array("koderekening", "namarekening", "saldo"),
        array("nojual", "tanggal", "kodepelanggan", "total", "keterangan"),
        array("nogenerate", "nojual", "kodeitem", "qty", "hargajual", "stok"),
        array("nobeli", "noref", "tanggal", "kodepemasok", "total", "keterangan"),
        array("nogenerate", "nobeli", "kodeitem", "qty", "hargabeli", "stok"),
        array("no", "nojual", "tanggal", "totalbayar", "keterangan", "koderekening"),
        array("no", "nobeli", "tanggal", "totalbayar", "keterangan", "koderekening"), 
    );
    $template_t = array (
        array("text", "text", "number", "number", "number", "text"),
        array("text", "text", "text", "text", "text", "text"),
        array("text", "text", "text", "text", "text", "text"),
        array("text", "text", "number"),
        array("text", "date", "text", "number", "text"),
        array("number", "text", "text", "number", "number", "number"),
        array("text", "text", "date", "text", "number", "text"),
        array("number", "text", "text", "number", "number", "number"),
        array("number", "text", "date", "number", "text", "text"),
        array("number", "text", "date", "number", "text", "text"), 
    );
    $_SESSION["table"] = $table_name;
    $_SESSION["template"] = $template;
    $_SESSION["template_t"] = $template_t;
}

function makeTable($dest) {
    $db = connect_db();
    $table_name = array();
    $template = array();
    $template_t = array();
    add_data($table_name, $template, $template_t);
    $_SESSION["displayed"] = true;

    // echo "<div class='search-bar'><input type='text' name='search'>";
    // echo "<input type='submit' name='search-button' value='Search'>";
    // echo "</div>";
    for ($i=0; $i < count($table_name); $i++) { 
        $name_upper = strtoupper($table_name[$i]);
        $name = $table_name[$i];
        echo "<div class='table-responsive'>";
        echo "<h3>$name_upper</h3>";
        echo "<table class='table table-dark table-striped'>";
        echo "<thead>";
        echo "<tr>";
        for ($j=0; $j < count($template[$i]); $j++) { 
            echo "<th>" . $template[$i][$j] . "</th>";
        }
        echo "<td></td>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $results = $db->query("select * from $name;");
        while ($row= $results->fetchArray()) {
            $current_id = $row[$template[$i][0]];
            echo "<tr>";
            for ($j=0; $j < count($template[$i]); $j++) { 
                echo "<td>" . $row[$template[$i][$j]] . "</td>";
            }
            echo "<td>";
            echo "<form method='post' action=$dest>";
            echo "<button name='edit-$name' type='submit' class='btn text-white' value='$current_id'>&nbsp<i class='nf nf-fa-edit'></i>&nbsp</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "<form action='$dest' method='post' class='inline-button mb-1'>";
        echo "<span>Option : </span>";
        echo "<button class='table-button p-1' type='submit' name='del-$name'><i class='nf nf-fa-minus'></i></button>";
        echo "<button class='table-button p-1' type='submit' name='add-$name'><i class='nf nf-fa-plus'></i></button>";
        // echo "<input class='table-button' type='submit' name='del-$name' value='Delete'>";
        // echo "<input class='table-button' type='submit' name='add-$name' value='Add'>";
        echo "</form>";
    }
}

function makeSingleTable($dest, $name, $cando, $from='none') {
    $db = connect_db();
    $table_name = array();
    $template = array();
    $template_t = array();
    add_data($table_name, $template, $template_t);

    $index = 0;
    for ($i=0; $i < count($template); $i++) { 
        if ($table_name[$i] == $name) {
            $index = $i;
        }
    }
    $_SESSION["displayed"] = true;
    $name_upper = strtoupper($name);
    echo "<div class='table-responsive'>";
    echo "<h3>$name_upper</h3>";
    echo "<table class='table table-dark table-striped'>";
    echo "<thead>";
    echo "<tr>";
    for ($j=0; $j < count($template[$index]); $j++) { 
        echo "<th>" . $template[$index][$j] . "</th>";
    }
    if ($cando) {
        echo "<td></td>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if ($from == "none") {
        $str = "select * from $name";
    } elseif ($from == "week") {
        $str = "select * from $name WHERE tanggal >= DATE('now', '-7 days') AND tanggal <= DATE('now')";
    } elseif ($from == "month") {
        $str = "select * from $name WHERE tanggal >= DATE('now', '-1 months') AND tanggal <= DATE('now')";
    } elseif ($from == "year") {
        $str = "select * from $name WHERE tanggal >= DATE('now', '-1 years') AND tanggal <= DATE('now')";
    } else {
        $str = "select * from $name";
    }
    $results = $db->query($str);
    while ($row= $results->fetchArray()) {
        $current_id = $row[$template[$index][0]];
        echo "<tr>";
        for ($j=0; $j < count($template[$index]); $j++) { 
            echo "<td>" . $row[$template[$index][$j]] . "</td>";
        }
        if ($cando) {
            echo "<td>";
            echo "<form method='post' action=$dest>";
            echo "<button name='edit-$name' type='submit' class='btn text-white' value='$current_id'>&nbsp<i class='nf nf-fa-edit'></i>&nbsp</button>";
            echo "</form>";
            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    if ($cando) {
        echo "<form action='$dest' method='post' class='inline-button mb-1'>";
        echo "<span>Option : </span>";
        echo "<button class='table-button p-1' type='submit' name='del-$name'><i class='nf nf-fa-minus'></i></button>";
        echo "<button class='table-button p-1' type='submit' name='add-$name'><i class='nf nf-fa-plus'></i></button>";
        // echo "<input class='table-button' type='submit' name='del-$name' value='Delete'>";
        // echo "<input class='table-button' type='submit' name='add-$name' value='Add'>";
        echo "</form>";
    }
}

?>
