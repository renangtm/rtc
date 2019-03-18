rtc.filter('data', function () {
    return function (ms) {
        var data = new Date(parseFloat(ms + ""));
        return data.toLocaleString();
    }
});

rtc.filter('tempo', function () {
    return function (ms) {

        var s = parseInt(ms / 1000);

        var segundos = s % 60;
        s-=segundos;
        s /= 60;
        var minutos = s % 60;
        s-=minutos;
        s /= 60;
        var horas = s % 24;
        s-=horas;
        s /= 24;

        var str = "";

        if (s > 0) {
            str += s + " Dias ";
        }

        str += horas + "h:";
        str += minutos + "m:";
        str += segundos + 's';

        return str;

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

