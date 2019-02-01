
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

    $((filtro == null) ? "#filtro" : "#" + filtro).keyup(function () {

        var f = "";
        var v = $(this).val();
        for (var i = 0; i < campos.length; i++) {

            if (i > 0)
                f += " OR ";

            f += base + "." + campos[i] + " like '%" + v + "%'";

        }

        lista.filtro = "(" + f + ")";
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

                        f += base + "." + campos[j] + " " + ((b[j] === 1) ? "DESC" : "ASC");
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


            for (var i = 1; i < lista.length; i++) {
                for (var j = i; j > 0 && comparator(lista[j], lista[j - 1]); j--) {
                    var k = lista[j];
                    lista[j] = lista[j - 1];
                    lista[j - 1] = k;
                }
            }



            var lst = [];

            lbl:
                    for (var i = 0; i < lista.length; i++) {

                for (a in lista[i]) {

                    if (typeof listta[i][a] === 'string') {
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

function baseService(http, q, obj,get) {

    loading.show();

    for (var i = 0; i < requests.length; i++) {
        //requests[i].resolve();
    }
    requests = [];

    var p = q.defer();

    if (typeof obj["o"] !== 'undefined') {

        if (typeof obj.o["_classe"] === 'undefined') {

            obj.o["_classe"] = "stdClass";

        }

    }
    
    if(get==2){
        
        document.write("c=" + obj.query.split("&").join("e") + ((typeof obj["o"] !== 'undefined') ? ("&o=" + paraJson(obj.o).split("&").join("e")) : ""));
        
    }
    
    http({
        url: 'php/controler/crt.php',
        method: ((get==null)?"POST":"GET"),
        data: "c=" + obj.query.split("&").join("e").split("+").join("<m>") + ((typeof obj["o"] !== 'undefined') ? ("&o=" + paraJson(obj.o).split("&").join("e").split("+").join("<m>")) : ""),
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

function equalize(obj, param, vect) {
    for (var i = 0; i < vect.length; i++) {
        if (vect[i].id == obj[param].id) {
            vect[i] = obj[param];
            break;
        }
    }
}

function getExt(nome) {
    return nome.split('.')[nome.split('.').length - 1];
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

                    obj.arquivos[obj.arquivos.length] = "http://10.0.0.107/novo_rtc_web/php/uploads/" + nome;

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
                    query: "Sistema::mergeArquivo($o->nome,'"+b+"')",
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


    