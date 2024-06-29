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
    $sql = "SELECT * FROM item WHERE kodeitem LIKE '%$q%' OR nama LIKE '%$q%' OR hargajual LIKE '%$q%' OR satuan LIKE '%$q%' limit 20";
    $result = $db->query($sql);

    $response['status'] = 'success';
    $response['message'] = 'Data retrieved successfully';

    while ($row = $result->fetchArray()) {
        $response['data'][] = [
            'kodeitem' => $row['kodeitem'],
            'nama' => $row['nama'],
            'hargabeli' => $row['hargabeli'],
            'hargajual' => $row['hargajual'],
            'stok' => $row['stok'],
            'satuan' => $row['satuan'],
            'qty' => 0,
        ];
    }
} 

// Output the JSON response
echo json_encode($response);
?>
