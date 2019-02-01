rtc.filter('data', function () {
    return function (ms) {
        var data = new Date(parseFloat(ms + ""));
        return data.toLocaleString();
    }
});

