<?php

require_once './lib.php';

$config = get_config();
$gmaps_api_key = array_get(array_get($config, 'api_keys', []), 'google_maps', null);
?>
<!doctype html>
<html>
    <head>
    </head>
    <body>
    <?php if(is_null($gmaps_api_key)): ?>
        <h1>No Google Maps API Key</h1>
    <?php else: ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $gmaps_api_key ?>&callback=initMap" async defer></script>
        <script src="./lib.js"></script>
        <script src="./map.js"></script>
    <?php endif; ?>
    </body>
</html>

