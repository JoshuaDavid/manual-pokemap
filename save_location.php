<?php

require_once './lib.php';

$latitude = array_get($_POST, 'latitude');
$longitude = array_get($_POST, 'longitude');

if(!is_numeric($latitude) || !is_numeric($longitude)) {
    json_respond([
        'ok' => false,
        'error' => 'Latitude and Longitude are required and must be numeric'
    ], 400);
}

$conn = get_db_connection();
db_insert($conn, 'spawn', [
    'latitude' => $latitude,
    'longitude' => $longitude,
    'timestamp' => time(),
]);

json_respond(['ok' => true]);
