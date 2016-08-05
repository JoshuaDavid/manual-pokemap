<?php

function array_get(array $array, $key, $default_value = null) {
    if(array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $default_value;
    }
}

function get_config() {
    $config_file = './config.json';
    $config = json_decode(file_get_contents('./config.json'), true);
    return $config;
}

function get_db_connection() {
    $config = get_config();
    $database_config = array_get($config, 'database', []);
    $username = array_get($database_config, 'username', 'dbuser');
    $password = array_get($database_config, 'password', 'dbpass');
    $dbname = array_get($database_config, 'dbname', 'dbname');
    $host = array_get($database_config, 'host', 'dbhost');
    $port = array_get($database_config, 'host', 'dbport');
    $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";
    $conn = new PDO($dsn, $username, $password);
    return $conn;
}

function db_insert($conn, $table_name, $data) {
    $cols = [];
    $binding_points = [];
    $bindings = [];

    foreach($data as $key => $value) {
        $cols []= "`$key`";
        $binding_points []= ":{$key}";
        $bindings[":{$key}"] = $value;
    }

    $q = "INSERT INTO `{$table_name}`\n"
        . "    (" . implode(', ', $cols) . ")\n"
        . "    VALUES\n"
        . "    (" . implode(', ', $binding_points) . ")\n";

    $stmt = $conn->prepare($q);
    foreach($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }
    $stmt->execute();
}

function json_respond(array $response = [], $status = 200) {
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode($response);
    exit;
}
