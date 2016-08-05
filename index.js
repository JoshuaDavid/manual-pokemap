window.addEventListener('DOMContentLoaded', function() {
    var reportSightingBtn = document.getElementById('report-sighting');
    var successAlert = document.getElementById('sighting-reported-success-alert');
    var position = null;

    navigator.geolocation.watchPosition(function(nextPosition) {
        position = nextPosition;
    });

    reportSightingBtn.addEventListener('click', function() {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        reportSightingBtn.setAttribute('disabled', true);
        httpPost('./save_location.php', {
            'latitude': latitude,
            'longitude': longitude,
        }, function(response) {
            successAlert.style.display = "block";
            setTimeout(function() {
                reportSightingBtn.removeAttribute('disabled');
                successAlert.style.display = "none";
            }, 3000);
        }, function(error) {
            reportSightingBtn.removeAttribute('disabled');
        });
    });
});
