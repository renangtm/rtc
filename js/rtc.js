
function resolverRecursao(obj, pilha) {

    if (typeof obj == 'number' || typeof obj == 'string' || typeof obj == 'boolean' || obj == null) {

        return obj;

    }

    pilha[pilha.length] = obj;

    if (Array.isArray(obj)) {

        for (var i = 0; i < obj.length; i++) {

            obj[i] = resolverRecursao(obj[i], pilha);

        }

    } else if (typeof obj == 'object') {

        if (typeof obj['recursao'] !== 'undefined') {

            pilha.length--;

            return pilha[pilha.length - obj['recursao'] + 1];

        }

        for (a in obj) {

            obj[a] = resolverRecursao(obj[a], pilha);

        }

    }

    pilha.length--;

    return obj;

}

function paraObjeto(json) {

    return resolverRecursao(JSON.parse(json), []);

}

function recParaJson(objeto, pilha) {



    if (objeto == null) {

        return "null";

    }

    var r = "";

    for (var i = 0; i < pilha.length; i++) {

        if (pilha[i] === objeto) {

            r = '{"recursao":' + (pilha.length - i + 1) + '}';

            return r;

        }


    }



    pilha[pilha.length] = objeto;

    if (Array.isArray(objeto)) {

        r = "[";

        for (var i = 0; i < objeto.length; i++) {

            if (i > 0)
                r += ",";

            r += recParaJson(objeto[i], pilha);

        }

        r += "]";

    } else if (typeof objeto == 'string') {



        r = '"' + objeto + '"';

    } else if (typeof objeto == 'number') {

        r = objeto;

    } else if (typeof objeto == 'boolean') {

        r = objeto ? "true" : "false";

    } else if (typeof objeto == 'object') {

        r = "{";

        for (a in objeto) {

            if (r.length > 1) {
                r += ",";
            }

            r += '"' + a + '":' + recParaJson(objeto[a], pilha);

        }

        r += "}";

    }

    pilha.length--;

    return r;

}

function paraJson(objeto) {

    return recParaJson(objeto, []);

}

function createList(lista, cols, rows, filterParam, comparator) {

    var listar = {
        filtro: "",
        por_pagina: rows,
        por_coluna: cols,
        elementos: [],
        pagina: 0,
        paginas: [],
        attList: function () {




            var sinc = Array.isArray(lista);

            var este = this;

            if (sinc) {
                for (var i = 1; i < lista.length; i++) {
                    for (var j = i; j > 0 && comparator(lista[j], lista[j - 1]); j--) {
                        var k = lista[j];
                        lista[j] = lista[j - 1];
                        lista[j - 1] = k;
                    }
                }
            }



            var count = 0;
            var lst = [];
            if (sinc) {
                for (var i = 0; i < lista.length; i++) {

                    if (typeof filterParam === 'string') {
                        if (lista[i][filterParam] == null)
                            continue;
                        if (lista[i][filterParam].toUpperCase().indexOf(this.filtro.toUpperCase()) >= 0) {
                            lst[lst.length] = lista[i];
                        }
                    } else if (typeof filterParam === 'function') {
                        if (filterParam(lista[i])) {
                            lst[lst.length] = lista[i];
                        }
                    }

                }

            } else {

                count = lista.getCount(este.filtro);

                lst = lista.getElementos(este.por_pagina * este.por_coluna * este.pagina, Math.min(este.por_pagina * este.por_coluna * (este.pagina + 1)), count);

            }

            var np = Math.ceil(((sinc) ? lst.length : count) / (this.por_pagina * this.por_coluna));
            this.pagina = Math.max(Math.min(this.pagina, np - 1), 0);
            this.elementos = [];
            for (var i = 0; i < this.por_pagina && (i * (this.por_coluna) + (this.pagina * this.por_coluna * this.por_pagina)) < ((sinc) ? lst.length : count); i++) {
                this.elementos[this.elementos.length] = [];
                for (var j = 0; j < this.por_coluna && (i * (this.por_coluna) + (this.pagina * this.por_coluna * this.por_pagina) + j) < ((sinc) ? lst.length : count); j++) {

                    this.elementos[i][this.elementos[i].length] = lst[(i * (this.por_coluna) + (this.pagina * this.por_coluna * this.por_pagina) + j)];

                }
            }
            this.paginas = [];
            for (var i = 0; i < np; i++) {
                var p = {numero: i, ir: function () {
                        este.pagina = this.numero;
                        este.attList();
                    }, isAtual: este.pagina == i}
                this.paginas[this.paginas.length] = p;
            }
        }
    }

    listar.attList();

    return listar;

}

var requests = [];

var loading = {
    show: function () {

    }, close: function () {

    }
};

var msg = {
    alerta: function (msg) {
        alert(msg);
    },
    erro: function(msg){
        alert(msg);
    }
    , confirma: function (msg, fn) {
        if (confirm(msg)) {
            fn();
        }
    }
}

function baseService(http, q, obj) {

    loading.show();
    
    for (var i = 0; i < requests.length; i++) {
        requests[i].resolve();
    }
    requests = [];

    var p = q.defer();

    if (typeof obj["o"] !== 'undefined') {

        if (typeof obj.o["_classe"] === 'undefined') {

            obj.o["_classe"] = "stdClass";

        }

    }

    http({

        url: 'php/controler/crt.php',
        method: "POST",
        data: "c=" + obj.query.split("&").join("e") + ((typeof obj["o"] !== 'undefined') ? ("&o=" + paraJson(obj.o).split("&").join("e")) : ""),
        timeout: p.promise,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).then(function (exx) {

        if (typeof obj["sucesso"] !== 'undefined') {
            obj.sucesso(paraObjeto(JSON.stringify(exx.data)));
        }

        loading.close();

    }, function (exx) {

        loading.close();

        if (typeof obj["falha"] !== 'undefined') {
            obj.falha(paraObjeto(JSON.stringify(exx.data)));
        }

    })

    requests[requests.length] = p;

}

var rtc = angular.module("appRtc", []);
