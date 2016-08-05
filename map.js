var map = null; 
    spawnsById = {},
    mapContainer = null,
    position = {lat: 0, lng: 0};

function initMap() {
    mountMapContainer();
    map = new google.maps.Map(mapContainer, {
        center: position,
        zoom: 15,
    });

    getSpawns();
    setInterval(getSpawns, 5000);
}

function getSpawns() {
    httpGet('./sightings.php', {
        latitude: position.lat,
        longitude: position.lng,
    }, function(response) {
        var spawns = response.spawns;
        for(var i = 0; i < spawns.length; i++) {
            var spawn = spawns[i];
            if(spawn.id in spawnsById) {
                continue;
            } else {
                (function(spawn) {
                    spawn.marker = new google.maps.Marker({
                        map: map,
                        position: {
                            lat: spawn.latitude,
                            lng: spawn.longitude,
                        },
                        title: 'XX:' + spawn.label + ':00',
                        icon: new google.maps.MarkerImage(
                            './icons/hour-offsets/' + spawn.label + '.svg',
                            null,
                            null,
                            new google.maps.Point(10, 10),
                            new google.maps.Size(20, 20)
                        )
                    });
                    spawn.marker.addListener('click', function() {
                        console.log(spawn.id);
                    })
                })(spawn);
            }
        }
    });
}

navigator.geolocation.getCurrentPosition(handleNewPosition);
navigator.geolocation.watchPosition(handleNewPosition);

function handleNewPosition(nextPosition) {
    position = {
        lat: nextPosition.coords.latitude,
        lng: nextPosition.coords.longitude,
    };

    if(map) {
        map.setCenter(position);
    }
}

function mountMapContainer() {
    var container = document.createElement('div');
    container.style.position = 'absolute';
    container.style.top = '0';
    container.style.left = '0';
    container.style.height = "100vh";
    container.style.width = "100%";
    container.style.background = "yellow";
    document.body.appendChild(container);
    mapContainer = container;
}
