rtc.filter('data', function () {
    return function (ms) {
        var data = new Date(parseFloat(ms + ""));
        return data.toLocaleString();
    }
});

rtc.filter('data_st', function () {
    return function (ms) {
        var data = new Date(parseFloat(ms + ""));
        return data.toLocaleString().split(" ")[0];
    }
});

rtc.filter('decimal', function () {
    return function (v) {
        var x = v.toFixed(2).split(".").join(",");
        return x; 
    }
});

