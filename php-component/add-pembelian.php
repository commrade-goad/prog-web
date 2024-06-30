<?php
header('Content-Type: application/json');
$db = new SQLite3('../db/database.db');

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
    'data' => []
];

// Check if 'q' parameter is set
if (isset($_GET["q"])) {
    $q = $_GET["q"];
    $no = $_GET["no"];
    $rek = $_GET["rek"];
    $sup = $_GET["sup"];
    $total = 0;
    $db->exec('BEGIN TRANSACTION');
    try {
        $response['data'] = $q;
        for ($i=0; $i < count($q); $i++) {
            $current = $q[$i];
            $nobeli = $no;
            $kodeitem = $current['kodeitem'];
            $qty = $current['qty'];
            $hargabeli = $current['hargabeli'];
            $stok = $current['stok'];
            $str = "insert into dbeli (nobeli, kodeitem, qty, hargabeli, stok) values ('$nobeli', '$kodeitem', $qty, $hargabeli, $stok)";
            $total += $qty * $hargabeli;
            $db->query($str);
            $calculate_stok = $stok + $qty;
            $str = "update item set stok = $calculate_stok where kodeitem = '$kodeitem'";
            $db->query($str);
        }

        $res = $db->query("select count(noref) from hbeli");
        $noref = 0;
        while ($row = $res->fetchArray()) {
            $noref = $row["count(noref)"];
        }

        $str = "insert into hbeli (nobeli, noref, tanggal, kodepemasok, total, keterangan) values ('$no', '$noref', date('now'), '$sup', $total, 'Lunas')";
        $db->query($str);
        $str = "insert into dbayarbeli (nobeli, tanggal, totalbayar, keterangan, koderekening) values ('$no', date('now'), $total, 'Lunas', '$rek')";
        $db->query($str);
        $str = "update rekening set saldo = saldo - $total where koderekening = '$rek'";
        $db->query($str);
        $db->exec("COMMIT");

        $response['status'] = 'success';
        $response['message'] = 'Data retrieved successfully';
    } catch (Exception $e){
        $db->exec("ROLLBACK");
    }
} 

// Output the JSON response
echo json_encode($response);
?>
