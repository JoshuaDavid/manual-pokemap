<?php

require_once './lib.php';

$latitude = array_get($_GET, 'latitude');
$longitude = array_get($_GET, 'longitude');

if(!is_numeric($latitude) || !is_numeric($longitude)) {
    json_respond([
        'ok' => false,
        'error' => 'Latitude and Longitude are required and must be numeric'
    ], 400);
}

$conn = get_db_connection();
$query = 'select id, latitude, longitude, timestamp from spawn';
$stmt = $conn->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spawns = [];
foreach($results as $row) {
    $hour_offset = floor((array_get($row, 'timestamp') % 3600) / 60);
    $spawns []= [
        'id' => (int) array_get($row, 'id'),
        'latitude' => (float) array_get($row, 'latitude'),
        'longitude' => (float) array_get($row, 'longitude'),
        'label' => str_pad($hour_offset, 2, '0', STR_PAD_LEFT),
        'hour_offset' => $hour_offset,
    ];
}

json_respond([
    'ok' => true,
    'spawns' => $spawns,
]);
