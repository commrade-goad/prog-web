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
    $total = 0;
    $db->exec('BEGIN TRANSACTION');
    try {
        $response['data'] = $q;
        for ($i=0; $i < count($q); $i++) {
            $current = $q[$i];
            $nojual = $no;
            $kodeitem = $current['kodeitem'];
            $qty = $current['qty'];
            $hargajual = $current['hargajual'];
            $stok = $current['stok'];
            $str = "insert into djual (nojual, kodeitem, qty, hargajual, stok) values ('$nojual', '$kodeitem', $qty, $hargajual, $stok)";
            $total += $qty * $hargajual;
            $db->query($str);
            $calculate_stok = $stok - $qty;
            $str = "update item set stok = $calculate_stok where kodeitem = '$kodeitem'";
            $db->query($str);
        }
        $str = "insert into hjual (nojual, tanggal, total, keterangan, kodepelanggan) values ('$no', date('now'), $total, 'Lunas', '-')";
        $db->query($str);
        $str = "insert into dbayarjual (nojual, tanggal, totalbayar, keterangan, koderekening) values ('$no', date('now'), $total, 'Lunas', '$rek')";
        $db->query($str);
        $str = "update rekening set saldo = saldo + $total where koderekening = '$rek'";
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
