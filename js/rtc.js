var projeto = "http://www.rtcagro.com.br/novo_rtc_web";


function resolverRecursao(obj, pilha) {

    if (typeof obj == 'number' || typeof obj == 'string' || typeof obj == 'boolean' || obj == null) {

        return obj;

    }

    if (Array.isArray(obj)) {

        for (var i = 0; i < obj.length; i++) {

            obj[i] = resolverRecursao(obj[i], pilha);

        }

        return obj;

    } else if (typeof obj == 'object') {

        pilha[pilha.length] = obj;

        if (typeof obj['recursao'] !== 'undefined') {

            pilha.length--;

            return pilha[pilha.length - obj['recursao']];

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

            r = '{"recursao":' + (pilha.length - i) + '}';

            return r;

        }


    }

    pilha[pilha.length] = objeto;

    if (Array.isArray(objeto)) {

        r = "[";

        pilha.length--;

        for (var i = 0; i < objeto.length; i++) {

            if (i > 0)
                r += ",";

            r += recParaJson(objeto[i], pilha);

        }

        r += "]";

        return r;

    } else if (typeof objeto == 'string') {

        r = '"' + objeto.split('"').join('') + '"';

    } else if (typeof objeto == 'number') {

        r = objeto;

    } else if (typeof objeto == 'boolean') {

        r = objeto ? "true" : "false";

    } else if (typeof objeto == 'object') {

        if (typeof objeto["_classe"] === 'undefined') {
            objeto["_classe"] = "stdClass";
        }

        r = "{";

        for (a in objeto) {

            if (a == "$$hashKey")
                continue;

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



function createFilterList(service, cols, rows, maxPage) {

    var listar = {
        filtro: null,
        ordem: null,
        linhas: rows,
        por_coluna: cols,
        elementos: [],
        pagina: 0,
        next: function () {
            this.pagina++;
            this.attList();
        },
        prev: function () {
            this.pagina--;
            this.attList();
        },
        paginas: [],
        attList: function () {

            var este = this;


            //----------------------------

            loading.show();
            service.getElementos(este.pagina * (este.linhas * este.por_coluna),
                    (este.pagina + 1) * (este.linhas * este.por_coluna),
                    este.filtro, este.ordem, function (e) {

                        if (este.filtro == null) {
                            este.filtro = e.filtros;
                        } else {
                            for (var i = 0; i < este.filtro.length; i++) {
                                var f = este.filtro[i];
                                if (typeof f.opcoes === 'undefined') {
                                    continue;
                                }
                                for (var op = 0; op < f.opcoes.length; op++) {
                                    f.opcoes[op].quantidade = 0;
                                }
                                for (var j = 0; j < e.filtros.length; j++) {
                                    var ff = e.filtros[j];
                                    if (ff.id === f.id) {
                                        for (var o = 0; o < ff.opcoes.length; o++) {
                                            var op = ff.opcoes[o];
                                            for (var oo = 0; oo < f.opcoes.length; oo++) {
                                                var oop = f.opcoes[oo];
                                                if (oop.id === op.id) {
                                                    oop.quantidade = op.quantidade;
                                                    break;
                                                }
                                            }
                                        }
                                        break;
                                    }
                                }
                            }

                        }

                        if (este.ordem == null) {

                            este.ordem = e.ordem;
                        }

                        var np = Math.ceil(e.qtd / (este.linhas * este.por_coluna));
                        este.pagina = Math.max(Math.min(este.pagina, np - 1), 0);

                        este.elementos = [];

                        var els = e.elementos;

                        for (var i = 0; i < este.linhas && (i * este.por_coluna) < els.length; i++) {
                            este.elementos[i] = [];
                            for (var j = 0; j < este.por_coluna && (i * este.por_coluna + j) < els.length; j++) {
                                este.elementos[i][j] = els[i * este.por_coluna + j];
                            }
                        }

                        este.paginas = [];

                        var a = Math.max(este.pagina - maxPage + 1, 0);
                        for (var i = a; i < a + maxPage && i < np; i++) {
                            var p = {numero: i, ir: function () {
                                    este.pagina = this.numero;
                                    este.attList();
                                }, isAtual: este.pagina == i}
                            este.paginas[este.paginas.length] = p;
                        }

                        if (typeof este["posload"] !== 'undefined') {
                            este["posload"](els);
                        }

                        loading.close();

                    });


            //-----------------------------





        }
    }

    listar.attList();


    return listar;

}

function createAssinc(lista, cols, rows, maxPage) {

    var listar = {
        filtro: "",
        ordem: "",
        por_pagina: rows,
        por_coluna: cols,
        elementos: [],
        pagina: 0,
        next: function () {
            this.pagina++;
            this.attList();
        },
        prev: function () {
            this.pagina--;
            this.attList();
        },
        paginas: [],
        attList: function () {

            var este = this;
            
            lista.getCount(este.filtro, function (r) {
                //----------------------------
                var np = Math.ceil(r.qtd / (este.por_pagina * este.por_coluna));
                este.pagina = Math.max(Math.min(este.pagina, np - 1), 0);

                lista.getElementos(este.pagina * (este.por_pagina * este.por_coluna),
                        Math.min((este.pagina + 1) * (este.por_pagina * este.por_coluna), r.qtd),
                        este.filtro, este.ordem, function (e) {
                            este.elementos = [];
                            
                            var els = e.elementos;
                            
                            for (var i = 0; i < este.por_pagina && (i * este.por_coluna) < els.length; i++) {
                                este.elementos[i] = [];
                                for (var j = 0; j < este.por_coluna && (i * este.por_coluna + j) < els.length; j++) {
                                    este.elementos[i][j] = els[i * este.por_coluna + j];
                                }
                            }

                            este.paginas = [];

                            var a = Math.max(este.pagina - maxPage + 1, 0);
                            for (var i = a; i < a + maxPage && i < np; i++) {
                                var p = {numero: i, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: este.pagina == i}
                                este.paginas[este.paginas.length] = p;
                            }

                            if (typeof este["posload"] !== 'undefined') {
                                este["posload"](els);
                            }
                            

                        });


                //-----------------------------

            });



        }
    }

    listar.attList();

    return listar;

}

function assincFuncs(lista, base, campos, filtro) {

    var b = [];
    var e = [];

    $((filtro == null) ? "#filtro" : "#" + filtro).change(function () {

        var f = "";
        var v = $(this).val();
        for (var i = 0; i < campos.length; i++) {

            if (i > 0)
                f += " OR ";

            if (campos[i].indexOf('.') == -1) {

                f += base + "." + campos[i] + " like '%" + v + "%'";

            } else {

                f += campos[i] + " like '%" + v + "%'";

            }

        }

        lista.filtro = "(" + f + ") ";
        lista.attList();

    })

    var fn = function (campos, i) {

        $("body").find("[data-ordem='" + base + "." + campos[i] + "']").each(function () {

            e[i][e[i].length] = $(this);

            var img = $("<img></img>").attr('src', 'imagens/seta.png').css('opacity', '0.5');
            var img2 = $("<img></img>").attr('src', 'imagens/seta.png').css('transform', 'rotate(180deg)').css('opacity', '0.5');

            $(this).append(img.css('float', 'right')).append(img2.css('float', 'right'));
            $(this).css('cursor', 'pointer');

            $(this).click(function () {

                b[i] = (b[i] + 1) % 3;

                if (b[i] == 0) {
                    img.css('opacity', '0.5');
                    img2.css('opacity', '0.5');
                } else if (b[i] == 1) {
                    img.css('opacity', '0.5');
                    img2.css('opacity', '1');
                }
                if (b[i] == 2) {
                    img.css('opacity', '1');
                    img2.css('opacity', '0.5');
                }

                var f = "";
                for (var j = 0; j < b.length; j++) {
                    if (b[j] > 0) {
                        if (f != "")
                            f += ",";

                        if (campos[j].indexOf('.') == -1) {

                            f += base + "." + campos[j] + " " + ((b[j] === 1) ? "DESC" : "ASC");

                        } else {

                            f += campos[j] + " " + ((b[j] === 1) ? "DESC" : "ASC");

                        }

                    }
                }

                lista.ordem = f;
                lista.attList();

            });

        })

    }

    for (var i = 0; i < campos.length; i++) {

        b[i] = 0;
        e[i] = [];
        fn(campos, i);
    }

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

            var este = this;

            if (comparator != null) {
                for (var i = 1; i < lista.length; i++) {
                    for (var j = i; j > 0 && comparator(lista[j], lista[j - 1]); j--) {
                        var k = lista[j];
                        lista[j] = lista[j - 1];
                        lista[j - 1] = k;
                    }
                }
            }


            var lst = [];

            lbl:
                    for (var i = 0; i < lista.length; i++) {

                for (a in lista[i]) {

                    if (typeof lista[i][a] === 'string') {
                        if (lista[i][a].toUpperCase().indexOf(this.filtro.toUpperCase()) >= 0) {

                            lst[lst.length] = lista[i];
                            continue lbl;

                        }
                    }
                }

            }

            var np = Math.ceil(lst.length / (this.por_pagina * this.por_coluna));
            this.pagina = Math.max(Math.min(this.pagina, np - 1), 0);
            this.elementos = [];
            for (var i = 0; i < this.por_pagina && (i * (this.por_coluna) + (this.pagina * this.por_coluna * this.por_pagina)) < lst.length; i++) {
                this.elementos[this.elementos.length] = [];
                for (var j = 0; j < this.por_coluna && (i * (this.por_coluna) + (this.pagina * this.por_coluna * this.por_pagina) + j) < lst.length; j++) {

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

    }, setProgress: function (v) {

    }
};

var msg = {
    alerta: function (msg) {
        alert(msg);
    },
    erro: function (msg) {
        alert(msg);
    }
    , confirma: function (msg, fn) {
        if (confirm(msg)) {
            fn();
        }
    }
}

function toDate(lo) {

    var d = new Date(parseFloat(lo + ""));

    var dia = d.getDate();
    var mes = (d.getMonth() + 1);
    var ano = (d.getYear() + 1900);

    return  ((dia < 10) ? "0" : "") + dia + "/" + ((mes < 10) ? "0" : "") + mes + "/" + ano;

}

function toTime(lo) {

    var d = new Date(parseFloat(lo + ""));

    var dia = d.getDate();
    var mes = (d.getMonth() + 1);
    var ano = (d.getYear() + 1900);

    var hora = d.getHours();
    var minuto = d.getMinutes();

    return  ((dia < 10) ? "0" : "") + dia + "/" + ((mes < 10) ? "0" : "") + mes + "/" + ano + " " + hora + ":" + minuto;

}

function toHours(lo) {

    var d = new Date(parseFloat(lo + ""));

    var hora = d.getHours();
    var minuto = d.getMinutes();

    return  hora + ":" + minuto;

}

function fromHours(h) {

    var h = h.split(":");

    return parseInt(h[0]) * 60 * 60 * 1000 + parseInt(h[1]) * 60 * 1000;

}

function fromTime(str) {

    var l = str.split(" ");

    var k = l[0].split("/");

    var m = l[1].split(":");

    if (k.length != 3 || m.length != 2)
        return -1;

    var dia = parseInt(k[0]);
    var mes = parseInt(k[1]);
    var ano = parseInt(k[2]);

    var hora = parseInt(m[0]);
    var minuto = parseInt(m[1]);

    var d = new Date();
    d.setDate(dia);
    d.setMonth(mes - 1);
    d.setYear(ano);
    d.setHours(hora);
    d.setMinutes(minuto);

    return d.getTime();

}

function fromDate(str) {

    var k = str.split("/");

    if (k.length != 3)
        return -1;

    var dia = parseInt(k[0]);
    var mes = parseInt(k[1]);
    var ano = parseInt(k[2]);

    var d = new Date();
    d.setDate(dia);
    d.setMonth(mes - 1);
    d.setYear(ano);

    return d.getTime();

}

function fix(str, n) {

    var s = str;
    while (s.length < n) {
        s = "0" + s;
    }
    return s;

}

var ids = [];
var id = 0;

function baseService(http, q, obj, get, cancel) {

    var idt = ++id;


    var p = q.defer();

    if (get == 2) {

        document.write("c=" + obj.query.split("&").join("<e>") + ((typeof obj["o"] !== 'undefined') ? ("&o=" + paraJson(obj.o).split("&").join("<e>")) : ""));

    }

    http({
        url: 'php/controler/crt.php',
        method: ((get == null) ? "POST" : "GET"),
        data: "c=" + obj.query.split("&").join("<e>").split("+").join("<m>").split("%").join("<p>") + ((typeof obj["o"] !== 'undefined') ? ("&o=" + paraJson(obj.o).split("&").join("<e>").split("+").join("<m>").split("%").join("<p>")) : ""),
        timeout: p.promise,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}}).then(function (exx) {

        var m = 0;
        for (var i = 0; i < ids.length; i++) {
            if (ids[i] == idt) {
                ids[i] = 0;
            } else if (m < ids[i]) {
                m = ids[i];
            }
        }
        if (m == 0) {
            loading.close();
        }

        if (typeof obj["sucesso"] !== 'undefined') {
            obj.sucesso(paraObjeto(JSON.stringify(exx.data).split("<e>").join("&").split("<m>").join("+").split("<p>").join("%")));
        }


    }, function (exx) {

        var m = 0;
        for (var i = 0; i < ids.length; i++) {
            if (ids[i] == idt) {
                ids[i] = 0;
            } else if (m < ids[i]) {
                m = ids[i];
            }
        }
        if (m == 0) {
            loading.close();
        }

        if (typeof obj["falha"] !== 'undefined') {
            obj.falha(paraObjeto(JSON.stringify(exx.data).split("<e>").join("&").split("<m>").join("+").split("<p>").join("%")));
        }

    })

    var m = 0;
    for (var i = 0; i < ids.length; i++) {
        if (ids[i] > m) {
            m = ids[i];
        }
    }

    if (m == 0) {
        loading.show();
    }

    for (var i = 0; i < requests.length; i++) {
        if (cancel) {
            requests[i].resolve();
            ids[i] = 0;
        }
    }
    requests = [];

    ids[ids.length] = idt;
    requests[requests.length] = p;

}

function remove(vector, element) {
    var a = false;
    for (var i = 0; i < vector.length - 1; i++) {
        if (vector[i] === element) {
            a = true;
        }
        if (a) {
            vector[i] = vector[i + 1];
        }
    }
    for (var i = 0; i < vector.length; i++) {
        if (vector[i] === element) {
            a = true;
        }
    }

    if (a)
        vector.length--;
}

function equalize(obj, param, vect) {
    for (var i = 0; i < vect.length; i++) {
        if (vect[i].id === obj[param].id) {
            obj[param] = vect[i];
            break;
        }
    }
}



function privateXmlToJson(r, e) {
    for (var t = ["<", ">", "</", "/>"], l = "", a = {}, n = "", h = -1, i = !1, s = !1; e < r.length; e++) {
        for (var f = e, g = 0; g < t.length; g++) {
            var c = f;
            try {
                for (; r.charAt(c) == t[g].charAt(c - f) && c - f < t[g].length && c < r.length; c++)
                    ;
            } catch (r) {
            }
            c - f == t[g].length && (h = g, e = c)
        }
        if (-1 == h)
            n += r.charAt(e), i = !0;
        else if (0 == h)
            n += r.charAt(e);
        else if (1 == h) {
            if (s) {
                if (n == l)
                    return[a, e];
                e--, s = !1
            } else {
                if ("" == l) {
                    for (var o = n.split(" "), A = 1; A < o.length; A++) {
                        var v = o[A].split("=", 2);
                        a[v[0]] = v[1].substr(1, v[1].length - 2)
                    }
                    l = n = o[0], e--, h = -1
                } else {
                    var u = n.length;
                    void 0 != a[n = n.split(" ")[0]] && (Array.isArray(a[n]) || (a[n] = [a[n]]));
                    var y = privateXmlToJson(r, e - u - 2);
                    e = y[1] - 1, Array.isArray(a[n]) ? a[n][a[n].length] = y[0] : a[n] = y[0]
                }
                for (; e + 1 < r.length && " " == r.charAt(e + 1); )
                    e++
            }
            n = ""
        } else if (2 == h) {
            if (i)
                return[n, e - t[2].length];
            s = !0, e--, h = 0
        } else
            3 == h && (e--, n = "")
    }

    return[a, e];
}

function xmlToJson(xxx) {

    var xml = xxx;

    if (xml.indexOf('<?xml version="1.0" encoding="UTF-8"?>') < 0) {
        xml = '<?xml version="1.0" encoding="UTF-8"?>' + xml;
    }
    xml = xml.split("\n").join("").split("\t").join("").split("\r").join("").replace(/ +(?= )/g, '').split('> <').join('><');

    return privateXmlToJson(xml, 0)[0];

}


function getExt(nome) {
    return nome.split('.')[nome.split('.').length - 1];
}

function isNormalInteger(str) {
    var n = Math.floor(Number(str));
    return n !== Infinity && String(n) === str && n >= 0;
}

function getRandom(v) {

    var ca = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    var k = "";

    for (var i = 0; i < v; i++) {

        k += ca[Math.floor(Math.random() * (ca.length - 0.01))];

    }

    return k;

}



var rtc = angular.module("appRtc", []);


rtc.service('uploadService', function ($http, $q) {

    var up = function (arquivo, obj, fn) {

        var reader = new FileReader();
        var este = this;
        if (reader) {

            var f = function (bytes, buffer, offset, nome) {

                var k = Math.min(offset + buffer, bytes.length);

                if (k == offset) {

                    obj.arquivos[obj.arquivos.length] = projeto + "/php/uploads/" + nome;

                    if (obj.arquivos.length == (obj.qtdArquivos - obj.qtdFalhas)) {
                        if (obj.qtdFalhas == 0) {
                            fn(obj.arquivos, true);
                        } else {
                            fn(obj.arquivos, false);
                        }

                    }

                    return;

                }

                var b = "";
                for (var i = offset; i < k; i++)
                    b += String.fromCharCode(bytes[i]);


                b = window.btoa(b);
                baseService($http, $q, {
                    o: {nome: nome},
                    query: "Sistema::mergeArquivo($o->nome,'" + b + "')",
                    sucesso: function (r) {

                        f(bytes, buffer, k, nome);

                    },
                    falha: function (r) {

                        obj.qtdFalhas++;

                        if (obj.qtdFalhas == obj.qtdArquivos) {

                            fn(obj.arquivos, false);

                        }

                    }

                });

                obj.atual++;

                loading.setProgress(obj.atual * 100 / obj.total);

            }

            reader = new FileReader();
            reader.readAsArrayBuffer(new Blob([arquivo]));
            reader.onload = function () {

                var array = reader.result;
                var bytes = new Uint8Array(array);
                var ext = getExt(arquivo.name);

                var nome = "arquivo_" + getRandom(40) + "." + ext;
                var buffer = 3 * 1000;

                obj.total += (bytes.length / buffer);

                f(bytes, buffer, 0, nome);

            }

        }


    }


    this.upload = function (arquivos, fn) {

        var obj = {total: 0, atual: 0, qtdArquivos: arquivos.length, arquivos: [], qtdFalhas: 0};

        for (var i = 0; i < arquivos.length; i++) {

            up(arquivos[i], obj, fn);

        }

    }

})

rtc.directive('ngConfirm', function ($parse) {
    return{
        restrict: 'A',
        link: function (scope, element, attrs) {
            var exp = $parse(attrs.ngConfirm);
            $(element).change(function () {
                exp(scope, {});
                scope.$apply();
            })
        }
    };
});

rtc.directive('ngDownload', function () {
    return{
        restrict: 'A',
        link: function (scope, element, attrs) {
            $(element).click(function () {
                window.open(attrs.ngDownload);
            })
        }
    };
});

var idsUnicos = 1;

rtc.directive('cronometro', function ($interval) {
    return {
        restrict: 'E',
        scope: {
            model: '='
        },
        templateUrl: 'cronometro.html',
        link: function (scope, element, attrs) {

            $interval(function () {

                scope.model -= 1000;

            }, 1000);

        }
    };
})

rtc.directive('inteiro', function () {
    return {
        restrict: 'E',
        scope: {
            model: '='
        },
        templateUrl: 'txtInteiro.html',
        link: function (scope, element, attrs) {
            var c = "0 1 2 3 4 5 6 7 8 9".split(" ");
            var rep = function (str) {
                var s = "";
                for (var i = 0; i < str.length; i++) {
                    for (var j = 0; j < c.length; j++) {
                        if (c[j] === str[i]) {
                            s += str[i];
                            break;
                        }
                    }
                }
                return s;
            }
            scope.adjust = function () {
                scope.model = parseInt(rep(scope.model) + "");
            }
        }
    };
})

rtc.directive('decimal', function ($parse) {
    return {
        restrict: 'E',
        scope: {
            model: '='
        },
        templateUrl: 'txtDecimal.html',
        link: function (scope, element, attrs) {

            var c = "0 1 2 3 4 5 6 7 8 9 ,".split(" ");
            var rep = function (str) {
                var s = "";
                for (var i = 0; i < str.length; i++) {
                    for (var j = 0; j < c.length; j++) {
                        if (c[j] === str[i]) {
                            s += str[i];
                            break;
                        }
                    }
                }
                return s;
            }



            var ultm =
                    scope.ini = function () {

                        var ant = scope.model2;

                        scope.model2 = (scope.model + "").split(".").join(",");

                        scope.adjust();

                        if (ant.length - 1 === scope.model2.length) {
                            var a = true;

                            for (var i = 0; i < scope.model2.length; i++) {

                                if (scope.model2.charAt(i) !== ant.charAt(i)) {
                                    a = false;
                                    break;
                                }

                            }

                            if (a && ant[ant.length - 1] === ',') {
                                scope.model2 = ant;
                            }
                        }



                        scope.$apply();


                    }

            setInterval(scope.ini, 500);

            scope.adjust = function () {


                var k = rep(scope.model2);
                var s = k.split(",");

                if (s.length > 2) {
                    s = [s[0], s[1]];
                }

                var p1 = s[0];
                var pp1 = "";

                for (var i = 0; i < p1.length; i++) {
                    if ((p1.length - i) % 3 == 0 && i > 0)
                        pp1 += ".";
                    pp1 += p1[i];
                }
                var k = pp1.split(".").join("");
                if (s.length == 2) {

                    if (s[1].length > 2) {
                        s[1] = s[1].substr(0, 2);
                    }

                    pp1 += "," + s[1];
                    if (s[1].length > 0) {
                        k += "." + s[1];
                    }
                }

                scope.model = parseFloat(k);
                scope.model2 = pp1;

                if (isNaN(scope.model)) {
                    scope.model = 0;
                    scope.model2 = "0";
                }

            }


        }
    };
})

rtc.directive('email', function () {
    return{
        restrict: 'E',
        scope: {
            emailAtual: "=atributo",
            temSenha: "=senha",
            alterar: "="
        },
        templateUrl: 'email.html',
        link: function (scope, element, attrs) {

            scope.idUnico = idsUnicos;
            idsUnicos++;
            scope.entidade = attrs.entidade;
            scope.selectEmail = function () {

                var e = scope.emailAtual.endereco.split(";");

                var emailEnvio = "";

                //Nomes dos grupos devem condizer com a da classe Email.php, acoplado :(, por?�?�m infelizmente n?�?�o vai dar tempo de tomar uma abordagem mais correta;
                //De qualquer forma, salvo este acoplamento nestes dois locais, essa abordagem nao tr??z prejuizos maiores;

                var grupos = [{nome: "Emails Principais", enderecos: [], principal: true},
                    {nome: "Logistica", enderecos: [], principal: false},
                    {nome: "Compras", enderecos: [], principal: false},
                    {nome: "Vendas", enderecos: [], principal: false},
                    {nome: "Manutencao", enderecos: [], principal: false},
                    {nome: "Diretoria", enderecos: [], principal: false},
                    {nome: "Administrativo", enderecos: [], principal: false},
                    {nome: "Financeiro", enderecos: [], principal: false}];

                for (var i = 0, j = 0; i < e.length; i++) {

                    var a = e[i];

                    if (a.indexOf(':') < 0) {

                        grupos[0].enderecos[grupos[0].enderecos.length] = {endereco: a};

                        if (j === 0) {

                            emailEnvio = a;

                        }

                        j++;

                    } else {

                        var nome_grupo = a.split(":")[0];
                        var emails_grupo = a.split(":")[1].split(",");

                        var gr = null;

                        for (var t = 0; t < grupos.length; t++) {
                            if (grupos[t].nome === nome_grupo) {
                                gr = grupos[t];
                                break;
                            }
                        }

                        if (gr === null) {
                            gr = {nome: nome_grupo, enderecos: [], principal: false};
                            grupos[grupos.length] = gr;
                        }

                        for (var g = 0; g < emails_grupo.length; g++) {

                            gr.enderecos[gr.enderecos.length] = {endereco: emails_grupo[g]};

                        }

                    }

                }

                scope.grupos = grupos;
                scope.emailEnvio = emailEnvio;

            };
            scope.attString = function () {

                var ne = "";
                var g = scope.grupos;

                for (var i = 0; i < g.length; i++) {
                    if (i === 0) {
                        for (var j = 0; j < g[i].enderecos.length; j++) {
                            if (ne !== "") {
                                ne += ";";
                            }
                            ne += g[i].enderecos[j].endereco;
                        }
                    } else {

                        if (g[i].enderecos.length == 0) {
                            continue;
                        }

                        if (ne !== "") {
                            ne += ";";
                        }
                        ne += g[i].nome + ":";
                        for (var j = 0; j < g[i].enderecos.length; j++) {
                            if (ne !== "") {
                                ne += ",";
                            }
                            ne += g[i].enderecos[j].endereco;
                        }
                    }
                }

                scope.emailAtual.endereco = ne;

            };
            scope.endereco_email = "";
            scope.removeEmail = function (e) {
                for (var i = 0; i < scope.grupos.length; i++) {
                    remove(scope.grupos[i].enderecos, e);
                }
                scope.attString();
            };
            scope.addEmail = function (grupo) {

                if (scope.endereco_email === "") {
                    msg.erro("Insira algo no campo de email");
                    return;
                }

                grupo.enderecos[grupo.enderecos.length] = {endereco: scope.endereco_email};
                scope.endereco_email = "";
                scope.attString();
            };
            scope.$apply();
        }
    };
});

var focoAtual = 0;

rtc.directive('calendario', function ($timeout) {
    return {
        restrict: 'E',
        scope: {
            model: '=?',
            inicio: '=?',
            fim: '=?',
            meses: '=?',
            botao: '=?',
            tempo: '=?',
            change: '&?',
            confirma: '&?',
            refresh: '=?'
        },
        transclude: true,
        templateUrl: 'calendario.html',
        link: function (scope, element, attrs) {

            var lk = function () {

                scope.idUnico = idsUnicos++;
                scope.intervalo = (typeof scope["inicio"] !== 'undefined') && (typeof scope["fim"] !== 'undefined');
                scope.quantidade_meses = (typeof scope["meses"] !== 'undefined') ? scope.meses : 2;
                scope.meses_alias = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jul", "Jun", "Ago", "Set", "Out", "Nov", "Dec"];
                scope.dias = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"];
                scope.elementos = [];

                scope.horas = [];
                scope.minutos = [];

                scope.botao = (typeof scope["botao"] === 'undefined') ? false : scope.botao;
                scope.tem_confirma = scope.confirma !== undefined;
                scope.dsp = !scope.botao;

                scope.trocar = function () {

                    scope.dsp = !scope.dsp;

                    if (scope.dsp) {
                        focoAtual = scope.idUnico;
                    }
                    scope.$apply();

                }

                scope.foco = function () {

                    return focoAtual === scope.idUnico;

                }


                scope.hora_model = {hora: 12};
                scope.minuto_model = {minuto: 10};
                scope.hora_inicio = {hora: 12};
                scope.minuto_inicio = {minuto: 10};
                scope.hora_fim = {hora: 12};
                scope.minuto_fim = {minuto: 10};

                if (typeof scope["model"] !== 'undefined') {
                    scope.hora_model.hora = new Date(scope.model).getHours();
                    scope.minuto_model.minuto = new Date(scope.model).getMinutes();
                }

                if (typeof scope["inicio"] !== 'undefined') {
                    scope.hora_inicio.hora = new Date(scope.inicio).getHours();
                    scope.minuto_inicio.minuto = new Date(scope.inicio).getMinutes();
                }

                if (typeof scope["fim"] !== 'undefined') {
                    scope.hora_fim.hora = new Date(scope.fim).getHours();
                    scope.minuto_fim.minuto = new Date(scope.fim).getMinutes();
                }


                if (!scope.intervalo) {
                    scope.initDate = angular.copy(scope.model);
                } else {
                    scope.initDate = angular.copy(scope.inicio);
                }

                scope.trocaPeriodo = function () {

                    if (scope.hora_model.hora === "") {
                        scope.hora_model.hora = 0;
                    } else {
                        scope.hora_model.hora = parseInt(scope.hora_model.hora);
                        if (isNaN(scope.hora_model.hora)) {
                            return;
                        }
                        if (scope.hora_model.hora >= 24) {
                            scope.hora_model.hora = 1;
                        }
                    }

                    if (scope.minuto_model.minuto === "") {
                        scope.minuto_model.minuto = 0;
                    } else {
                        scope.minuto_model.minuto = parseInt(scope.minuto_model.minuto);
                        if (isNaN(scope.minuto_model.minuto)) {
                            return;
                        }
                        if (scope.minuto_model.minuto >= 60) {
                            scope.minuto_model.minuto = 1;
                        }
                    }
                    //----
                    if (scope.hora_inicio.hora === "") {
                        scope.hora_inicio.hora = 0;
                    } else {
                        scope.hora_inicio.hora = parseInt(scope.hora_inicio.hora);
                        if (isNaN(scope.hora_inicio.hora)) {
                            return;
                        }
                        if (scope.hora_inicio.hora >= 24) {
                            scope.hora_inicio.hora = 1;
                        }
                    }

                    if (scope.minuto_inicio.minuto === "") {
                        scope.minuto_inicio.minuto = 0;
                    } else {
                        scope.minuto_inicio.minuto = parseInt(scope.minuto_inicio.minuto);
                        if (isNaN(scope.minuto_inicio.minuto)) {
                            return;
                        }
                        if (scope.minuto_inicio.minuto >= 60) {
                            scope.minuto_inicio.minuto = 1;
                        }
                    }
                    //----
                    if (scope.hora_fim.hora === "") {
                        scope.hora_fim.hora = 0;
                    } else {
                        scope.hora_fim.hora = parseInt(scope.hora_fim.hora);
                        if (isNaN(scope.hora_fim.hora)) {
                            return;
                        }
                        if (scope.hora_fim.hora >= 24) {
                            scope.hora_fim.hora = 1;
                        }
                    }

                    if (scope.minuto_fim.minuto === "") {
                        scope.minuto_fim.minuto = 0;
                    } else {
                        scope.minuto_fim.minuto = parseInt(scope.minuto_fim.minuto + "");
                        if (isNaN(scope.minuto_fim.minuto)) {
                            return;
                        }
                        if (scope.minuto_fim.minuto >= 60) {
                            scope.minuto_fim.minuto = 1;
                        }
                    }



                    if (typeof scope["model"] !== "undefined") {

                        var d = new Date(parseInt(scope.model+""));
                        d.setHours(scope.hora_model.hora);
                        d.setMinutes(scope.minuto_model.minuto);
                        scope.model = d.getTime();

                    }

                    if (typeof scope["inicio"] !== "undefined") {

                        var d = new Date(parseInt(scope.inicio+""));

                        d.setHours(scope.hora_inicio.hora);
                        d.setMinutes(scope.minuto_inicio.minuto);
                        scope.inicio = d.getTime();

                    }

                    if (typeof scope["fim"] !== "undefined") {

                        var d = new Date(parseInt(scope.fim+""));
                        d.setHours(scope.hora_fim.hora);
                        d.setMinutes(scope.minuto_fim.minuto);
                        scope.fim = d.getTime();

                    }


                }

                scope.attCalendario = function () {

                    if (typeof scope["model"] === 'undefined') {
                        if (typeof scope["inicio"] === 'undefined' || typeof scope["fim"] === 'undefined') {
                            return;
                        }
                    }

                    scope.elementos = [];
                    var cmp = new Date(parseFloat(scope.model+""));
                    var inicio = new Date(parseFloat(scope.inicio + ""));
                    var fim = new Date(parseFloat(scope.fim + ""));
                    var data = new Date(parseFloat(scope.initDate + ""));
                    var clone = new Date(parseFloat(scope.initDate + ""));
                    for (var i = 0; i < scope.quantidade_meses; i++) {
                        data.setDate(1);
                        var mes = data.getMonth();
                        scope.elementos[i] = {titulo: data.getFullYear() + "/" + scope.meses_alias[data.getMonth()], dias: [], i: i};
                        while (data.getDay() !== 0)
                            data.setDate(data.getDate() - 1);
                        for (var j = 0; j < 5; j++) {
                            scope.elementos[i].dias[j] = [];
                            for (var k = 0; k < 7; k++, data.setDate(data.getDate() + 1)) {
                                if (!scope.intervalo) {
                                    scope.elementos[i].dias[j][k] = {dia: data.getDate(), millis: data.getTime(), mes_contexto: data.getMonth() === mes, inicio: false, fim: false, intervalo: false, selecionado: cmp.getFullYear() === data.getFullYear() && cmp.getMonth() === data.getMonth() && cmp.getDate() === data.getDate(), j: j, k: k};
                                } else {
                                    scope.elementos[i].dias[j][k] = {dia: data.getDate(), millis: data.getTime(), mes_contexto: data.getMonth() === mes, inicio: inicio.getFullYear() === data.getFullYear() && inicio.getMonth() === data.getMonth() && inicio.getDate() === data.getDate(), fim: fim.getFullYear() === data.getFullYear() && fim.getMonth() === data.getMonth() && fim.getDate() === data.getDate(), intervalo: data.getTime() > inicio.getTime() && data.getTime() < fim.getTime(), selecionado: false, j: j, k: k};
                                }
                            }
                        }
                        clone.setMonth(clone.getMonth() + 1);
                        data = clone;
                        clone = new Date(clone.getTime());
                    }

                }

                scope.attCalendario();


                scope.inif = 0;

                scope.eventoCalendarioReal = false;

                scope.setData = function (dt) {


                    if (!scope.intervalo) {
                        
                        
                        scope.model = dt.millis;

                        scope.attCalendario();

                        $timeout(function () {
                            
                            scope.change();

                        }, 100)


                    } else {

                        scope.setDataIntervalo(dt);

                    }

                }

                scope.setDataIntervalo = function (dt) {



                    if (dt.inicio && scope.inif === 0) {
                        scope.inif = 1;
                    } else if (dt.fim && scope.inif === 0) {
                        scope.inif = -1;
                    } else {
                        if (scope.setIntervalo(dt)) {
                            scope.inif = 0;
                        }
                    }

                }

                scope.confirmar = function () {
                    scope.dsp = false;
                    scope.confirma();
                }

                scope.setIntervalo = function (dt) {

                    if (scope.inif > 0) {


                        if (scope.fim < dt.millis) {
                            msg.erro("A data inicial nao pode ser maior que a final");
                            return false;
                        }

                        scope.inicio = dt.millis;
                        scope.attCalendario();

                        $timeout(function () {

                            scope.change();

                        }, 100)


                    } else if (scope.inif < 0) {

                        if (scope.inicio > dt.millis) {
                            msg.erro("A data final nao pode ser menor que a inicial");
                            return false;
                        }

                        scope.fim = dt.millis;
                        scope.attCalendario();

                        $timeout(function () {

                            scope.change();

                        }, 100)

                    }

                    return true;

                }

                scope.addMonth = function () {
                    scope.quantidade_meses++;
                    scope.attCalendario();
                }

                scope.removeMonth = function () {
                    scope.quantidade_meses--;
                    scope.quantidade_meses = Math.max(1, scope.quantidade_meses);
                    scope.attCalendario();
                }

                scope.prevMonth = function (q) {
                    var dt = new Date(parseFloat(scope.initDate+""));
                    if (dt.getMonth() > 0) {
                        dt.setMonth(dt.getMonth() - q);
                        dt.setDate(1);
                    } else {
                        dt.setYear(dt.getFullYear() - 1);
                        dt.setMonth(11);
                        dt.setDate(1);
                    }
                    scope.initDate = dt.getTime();
                    scope.attCalendario();
                }

                scope.nextMonth = function (q) {
                    var dt = new Date(parseFloat(scope.initDate+""));
                    dt.setMonth(dt.getMonth() + q);
                    dt.setDate(1);
                    scope.initDate = dt.getTime();
                    scope.attCalendario();
                }

                if (typeof scope["refresh"] !== 'undefined') {
                    scope.$watch(function () {
                        return scope.refresh;
                    }, function (n, a) {
                        
                        scope.intervalo = (typeof scope["inicio"] !== 'undefined') && (typeof scope["fim"] !== 'undefined');
                        scope.quantidade_meses = (typeof scope["meses"] !== 'undefined') ? scope.meses : 2;
                        scope.elementos = [];
                        scope.horas = [];
                        scope.minutos = [];
                        scope.botao = (typeof scope["botao"] === 'undefined') ? false : scope.botao;
                        scope.tem_confirma = scope.confirma !== undefined;
                        scope.dsp = !scope.botao;

                        scope.hora_model = {hora: 12};
                        scope.minuto_model = {minuto: 10};
                        scope.hora_inicio = {hora: 12};
                        scope.minuto_inicio = {minuto: 10};
                        scope.hora_fim = {hora: 12};
                        scope.minuto_fim = {minuto: 10};
                        
                        if (typeof scope["model"] !== 'undefined') {
                            scope.hora_model.hora = new Date(parseFloat(scope.model+"")).getHours();
                            scope.minuto_model.minuto = new Date(parseFloat(scope.model+"")).getMinutes();
                        }

                        if (typeof scope["inicio"] !== 'undefined') {
                            scope.hora_inicio.hora = new Date(parseFloat(scope.inicio+"")).getHours();
                            scope.minuto_inicio.minuto = new Date(parseFloat(scope.inicio+"")).getMinutes();
                        }

                        if (typeof scope["fim"] !== 'undefined') {
                            scope.hora_fim.hora = new Date(parseFloat(scope.fim+"")).getHours();
                            scope.minuto_fim.minuto = new Date(parseFloat(scope.fim+"")).getMinutes();
                        }


                        if (!scope.intervalo) {
                            scope.initDate = angular.copy(scope.model);
                        } else {
                            scope.initDate = angular.copy(scope.inicio);
                        }
                        
                        scope.inif = 0;
                   
                        scope.attCalendario();
                    }, false);
                }
            }
            lk();
        }
    };
})