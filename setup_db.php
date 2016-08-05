<?php

require_once './lib.php';

$conn = get_db_connection();

$query = '
    create table spawn (
        id integer unsigned not null auto_increment, 
        latitude float not null,
        longitude float not null,
        timestamp int unsigned not null,
        primary key (id)
    );
';

$conn->exec($query);
