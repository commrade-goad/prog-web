<?php

function render_action($target) {
    $db = new SQLite3('../db/database.db');
    $rekening = array();
    $result = $db->query("select count(*) from $target");
    $hasil = "NJ-";
    while ($row = $result->fetchArray()) {
        $hasil = $hasil . $row["count(*)"];
    }
    $result = $db->query("select * from rekening");
    while ($row = $result->fetchArray()) {
        array_push($rekening,
            array(
                "koderekening" => $row["koderekening"],
                "namarekening" => $row["namarekening"],
                "saldo" => $row["saldo"]
            )
        );
    }
    echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
    echo "<div class='d-flex justify-content-evenly'>";
    echo "<div class='p-2 custom-split'>";
    echo "<h4 class='fw-bold p-1 pt-2'>Tambahkan Item</h4>";
    echo "<hr class='mt-1'>";
    echo "<div class='d-flex justify-content-center'>";
    echo "<input type='text' id='sitem' class='search' placeholder='Search...'>";
    echo "</div>";
    echo "<div class='table-responsive' id='table-me'></div>";
    echo "</div>";

    echo "<div class='p-2 custom-split'>";
    echo "<div id='header-co' class='d-flex justify-content-between'>";
    echo "<h4 class='fw-bold p-1 pt-2'>Checkout</h4>";
    echo "<button id='checkout-me' class='table-button' disabled>Lanjutkan</button>";
    echo "</div>";
    echo "<hr class='mt-1'>";
    echo "<div class='d-flex justify-content-between align-items-center'>";
    echo "<p class='mb-0'>No Nota : <span id='nonota'>$hasil</span></p>";
    echo "<select class='overview-option' style='min-width: 50px !important; width: 120px' id='rekening'>";
    for ($i=0; $i < count($rekening); $i++) { 
        $kode = $rekening[$i]["koderekening"];
        $nama = $rekening[$i]["namarekening"];
        echo "<option value='$kode'>$kode - $nama</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div id='co' class='table-responsive'></div>";
    echo "</div>";
    echo "</div>";
    echo "<script src='../js/search-item.js'></script>";
}
?>
