function httpGet(url, data, onSuccess, onError) {
    var params = [];
    for(var key in data) {
        if(data.hasOwnProperty(key)) {
            var value = data[key];
            params.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
        }
    }
    var queryString = params.join('&');

    var xhr = new XMLHttpRequest;
    xhr.addEventListener('load', function(e) {
        var response = xhr.response;
        onSuccess(JSON.parse(response));
    });
    xhr.addEventListener('error', function(e) {
        var response = xhr.response;
        onError(JSON.parse(response));
    });

    xhr.open('get', url + '?' + queryString);
    xhr.send();
}

function httpPost(url, data, onSuccess, onError) {
    var params = [];
    for(var key in data) {
        if(data.hasOwnProperty(key)) {
            var value = data[key];
            params.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
        }
    }
    var queryString = params.join('&');

    var xhr = new XMLHttpRequest;
    xhr.addEventListener('load', function(e) {
        var response = xhr.response;
        onSuccess(JSON.parse(response));
    });
    xhr.addEventListener('error', function(e) {
        var response = xhr.response;
        onError(JSON.parse(response));
    });

    xhr.open('POST', url);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(queryString);
}
