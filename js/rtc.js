var projeto = "http://192.168.18.121:888/novo_rtc_web";



function mtlCharAt(str, idx) {
    str += '';
    var code,
            end = str.length;

    var surrogatePairs = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g;
    while ((surrogatePairs.exec(str)) != null) {
        var li = surrogatePairs.lastIndex;
        if (li - 2 < idx) {
            idx++;
        } else {
            break;
        }
    }

    if (idx >= end || idx < 0) {
        return NaN;
    }

    code = str.charCodeAt(idx);

    var hi, low;
    if (0xD800 <= code && code <= 0xDBFF) {
        hi = code;
        low = str.charCodeAt(idx + 1);
        // V� um adiante, j� que um dos "characters" � parte de um par substituto
        return ((hi - 0xD800) * 0x400) + (low - 0xDC00) + 0x10000;
    }
    return code;
}

//@author Renan Goncalves Teixeira Miranda
function DOMToJson(h) {

    h = h.split("\n").join("").split("\r").join("");

    var preCompile = [];
    for (var i = 0, a = ["<", ">"], b = -2, inner = ["'", '"'], k = 0; i < h.length; i++) {
        var c = h.charAt(i);
        var bb = -1;
        for (var j = 0; j < a.length; j++) {
            if (c === a[j]) {
                bb = j;
                break;
            }
        }
        for (var j = 0; j < inner.length; j++) {
            if (c === inner[j]) {
                //k++;
                break;
            }
        }
        if (k % 2 === 0 && bb !== b && (b < 0 || bb >= 0)) {
            preCompile[preCompile.length] = {valor: "", tipo: bb, atributos: {}, filhos: [], fechamento: null};
            b = bb;
        } else if (k % 2 === 0) {
            preCompile[preCompile.length - 1].valor += c;
        } else {
            preCompile[preCompile.length - 1].valor += (c !== " ") ? c : "<space>";
        }
    }

    var refineCompile = [];
    for (var i = 0; i < preCompile.length; i++) {
        var p = preCompile[i];
        p.valor = p.valor.split("\n").join("");
        while (p.valor.charAt(0) === " " || p.valor.charAt(0) === "    ") {
            p.valor = p.valor.substr(1);
        }
        while (p.valor.charAt(p.valor.length - 1) === " " || p.valor.charAt(p.valor.length - 1) === "    ") {
            p.valor = p.valor.substr(0, p.valor.length - 1);
        }
        if (p.valor === "")
            continue;

        if (p.valor.charAt(0) === "/" && p.tipo === 0) {
            p.tipo = -1;
            p.valor = p.valor.substr(1);
        }
        var k = p.valor.split(" ");
        if (k.length > 1 && p.tipo === 0) {
            if (k[0] === "!--" || k[0] === "?php" || k[0] === "?")
                continue;
            p.valor = k[0];
            for (var j = 1; j < k.length; j++) {
                var l = k[j].split('=');
                if (l.length === 2) {
                    p.atributos[l[0]] = l[1].split("<space>").join(" ");
                } else {
                    p.atributos[l[0]] = true;
                }
            }
        }
        refineCompile[refineCompile.length] = p;
    }
    var k = -1;
    var elemento = null;
    var pilha = [];
    for (var i = 0; i < refineCompile.length; i++) {
        var e = refineCompile[i];
        if (e.tipo === 0) {
            if (elemento === null) {
                elemento = e;
            } else {
                pilha[pilha.length - 1].filhos[pilha[pilha.length - 1].filhos.length] = e;
            }
            pilha[pilha.length] = e;
        } else if (e.tipo === 1) {
            pilha[pilha.length - 1].filhos[pilha[pilha.length - 1].filhos.length] = e;
        } else if (e.tipo === -1) {

            var n = 1;

            while (n <= pilha.length && pilha[pilha.length - n].valor !== e.valor)
                n++;

            if (n <= pilha.length) {
                pilha[pilha.length - n].fechamento = e;
                pilha.length -= n;
            }

        }
    }
    return elemento;

}

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

    json = json.split("\n").join(" ").split("\r").join(" ").split("\\").join(" ");

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

function millisToTime(ms) {

    var s = parseInt(ms / 1000);

    var segundos = s % 60;
    s -= segundos;
    s /= 60;
    var minutos = s % 60;
    s -= minutos;
    s /= 60;
    var horas = s % 24;
    s -= horas;
    s /= 24;

    var str = "";

    if (s > 0) {
        str += s + " Dias ";
    }

    str += horas + ":";
    str += minutos + ":";
    str += segundos;

    return str;

}

function createAssinc(lista, cols, rows, maxPage) {

    var listar = {
        filtro: "",
        ordem: "",
        por_pagina: rows,
        por_coluna: cols,
        quantidade:0,
        pontos_meio:false,
        numero_paginas:0,
        elementos: [],
        primeiros:[],
        ultimos:[],
        pagina_mu:1,
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
        attListMU:function(){
            this.pagina = this.pagina_mu-1;
            this.attList();
        },
        attList: function () {

            var este = this;

            lista.getCount(este.filtro, function (r) {
                //----------------------------
                
                este.pagina_mu = este.pagina+1;
                
                este.quantidade = r.qtd;
                
                var np = Math.ceil(r.qtd / (este.por_pagina * este.por_coluna));
                este.numero_paginas = np;
                este.pagina = Math.max(Math.min(este.pagina, np - 1), 0);
                este.pagina_mu = este.pagina+1;
                
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
                            
                            var len = Math.floor(maxPage/2);
                            
                            var dir = (este.pagina >= np/2);
                            
                            este.ultimos = [];
                            este.primeiros = [];
                            este.pontos_meio = false;
                            
                            var i = este.pagina-(este.pagina%(len-1));
                            
                            if(dir){
                                
                                var i = np-1-este.pagina;
                                
                                if(i%(len-1)===0){
                                    i += (len-1);
                                }else{
                                    i += (len-1)-(i%(len-1));
                                }
                                
                                i = Math.max(np-i-1,0);
                                
                            }
                            
                            for(var j=i;j<i+len && j<np;j++){
                                var p = {numero: j, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: este.pagina == j};
                                if(dir){
                                    este.ultimos[este.ultimos.length] = p;
                                }else{
                                    este.primeiros[este.primeiros.length] = p;
                                }
                            }
                            
                            if(dir){
                                
                                for(var j=0;j<len && j<i;j++){
                                    
                                    este.pontos_meio = true;
                                    
                                    var p = {numero: j, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: false};
                                    
                                    este.primeiros[este.primeiros.length] = p;
                                    
                                }
                               
                            }else{
                                
                                for(var j=np-1;j>=np-len && j>=i+len;j--){
                                    
                                    este.pontos_meio = true;
                                    
                                    var p = {numero: j, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: false};
                                    
                                    este.ultimos[este.ultimos.length] = p;
                                    
                                }
                                
                                for(var j=0;j<Math.floor(este.ultimos.length/2);j++){
                                    var k = este.ultimos[j];
                                    este.ultimos[j] = este.ultimos[este.ultimos.length-1-j];
                                    este.ultimos[este.ultimos.length-1-j] = k;
                                }
                                

                            }

                            if(este.ultimos.length>0 && este.primeiros.length>0 && este.pontos_meio){

                                var n1 = este.primeiros[este.primeiros.length-1].numero;
                                var n2 = este.ultimos[0].numero;

                                if(n2-n1===1){
                                    este.pontos_meio = false;
                                }

                            }
                            
                            
                            if (typeof este["posload"] !== 'undefined') {
                                este["posload"](els);
                            }


                        });


                //-----------------------------

            });



        }
    }



    return listar;

}

function assincFuncs(lista, base, campos, filtro, initialOrder) {


    var ini = true;

    if (initialOrder === false) {

        ini = initialOrder;

    }

    if (ini) {

        var ordemInicial = "";
        if (campos[0].indexOf('.') == -1) {

            ordemInicial += base + "." + campos[0] + " DESC";

        } else {

            ordemInicial += campos[0] + " DESC";

        }
        lista.ordem = ordemInicial;

    }

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
        numero_paginas:0,
        pontos_meio:false,
        primeiros:[],
        ultimos:[],
        pagina_mu:1,
        prev:function(){
            this.pagina = Math.max(0,this.pagina-1);
            this.attList();
        },
        next:function(){
            this.pagina = Math.min(this.numero_paginas,this.pagina+1);
            this.attList();
        },
        attListMU:function(){
            this.pagina = this.pagina_mu-1;
            this.attList();
        },
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

            este.numero_paginas = np;
            este.pagina_mu = este.pagina+1;
            //=========================================

            var len = Math.floor(4/2);
                            
                            var dir = (este.pagina >= np/2);
                            
                            este.ultimos = [];
                            este.primeiros = [];
                            este.pontos_meio = false;
                            
                            var i = este.pagina-(este.pagina%(len-1));
                            
                            if(dir){
                                
                                var i = np-1-este.pagina;
                                
                                if(i%(len-1)===0){
                                    i += (len-1);
                                }else{
                                    i += (len-1)-(i%(len-1));
                                }
                                
                                i = Math.max(np-i-1,0);
                                
                            }
                            
                            for(var j=i;j<i+len && j<np;j++){
                                var p = {numero: j, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: este.pagina == j};
                                if(dir){
                                    este.ultimos[este.ultimos.length] = p;
                                }else{
                                    este.primeiros[este.primeiros.length] = p;
                                }
                            }
                            
                            if(dir){
                                
                                for(var j=0;j<len && j<i;j++){
                                    
                                    este.pontos_meio = true;
                                    
                                    var p = {numero: j, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: false};
                                    
                                    este.primeiros[este.primeiros.length] = p;
                                    
                                }
                               
                            }else{
                                
                                for(var j=np-1;j>=np-len && j>=i+len;j--){
                                    
                                    este.pontos_meio = true;
                                    
                                    var p = {numero: j, ir: function () {
                                        este.pagina = this.numero;
                                        este.attList();
                                    }, isAtual: false};
                                    
                                    este.ultimos[este.ultimos.length] = p;
                                    
                                }
                                
                                for(var j=0;j<Math.floor(este.ultimos.length/2);j++){
                                    var k = este.ultimos[j];
                                    este.ultimos[j] = este.ultimos[este.ultimos.length-1-j];
                                    este.ultimos[este.ultimos.length-1-j] = k;
                                }
                                

                            }

                            if(este.ultimos.length>0 && este.primeiros.length>0 && este.pontos_meio){

                                var n1 = este.primeiros[este.primeiros.length-1].numero;
                                var n2 = este.ultimos[0].numero;

                                if(n2-n1===1){
                                    este.pontos_meio = false;
                                }

                            }

            //=========================================

        }
    }

    listar.attList();

    return listar;

}

var requests = [];
var jsrequests = [];

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

function encode64SPEC(val) {

    var chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#";

    var res = "";

    for (var i = 0; i < val.length; i += 3) {
        var k = 0;

        var u = 0;
        for (; u < 3 && (i + u) < val.length; u++)
            k = k << 8 | val.charCodeAt(i + u);
        for (var a = u; a < 3; a++)
            k = k << 8;

        for (var j = 0; j < 4; j++) {
            if (j > u) {
                res += "*";
            } else {
                res += chrArr.charAt((((k >> ((3 - j) * 6)) & 63)));
            }
        }
    }

    return res;

}

function decode64SPEC(val) {

    var chrArr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#";
    var invMap = {};
    for (var i = 0; i < chrArr.length; i++) {
        invMap["c" + chrArr.charCodeAt(i)] = i;
    }

    var res = "";

    for (var i = 0; i < val.length; i += 4) {
        var k = 0;

        var x = 0;
        for (var u = 0; u < 4 && (i + u) < val.length; u++) {

            if (val.charAt(i + u) != '*') {
                if (typeof invMap["c" + val.charCodeAt(i + u)] === 'undefined') {
                    return "";
                }
                k = k << 6 | invMap["c" + val.charCodeAt(i + u)];
                x += 6;
            } else {
                k = k << 6;
            }
        }

        for (var j = 0; j < 3 && x >= 8; j++, x -= 8) {
            res += String.fromCharCode((k >> (2 - j) * 8) & 255);
        }
    }

    return res;
}

var ids = [];
var id = 0;

var teste = false;

function jsBaseService(obj, ab) {

    var abt = true;

    if (ab === false) {

        abt = ab;

    }

    var idt = ++id;

    var params = {c: encode64SPEC(obj.query)};

    if (typeof obj["o"] !== 'undefined') {
        params["o"] = encode64SPEC(paraJson(obj["o"]));
    }
    var p = $.post('php/controler/crt.php', params).done(function (resp) {

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
            var d = resp;
            while (d.length > 1) {
                if (d.charCodeAt(0) === 13 || d.charCodeAt(0) === 10) {
                    d = d.substr(1);
                    continue;
                }
                break;
            }
            obj.sucesso(paraObjeto(decode64SPEC(d)));
        }
    }).fail(function (resp) {
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
            var d = resp;
            while (d.length > 1) {
                if (d.charCodeAt(0) === 13 || d.charCodeAt(0) === 10) {
                    d = d.substr(1);
                    continue;
                }
                break;
            }
            obj.falha(paraObjeto(decode64SPEC(d)));
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

    for (var i = 0; i < jsrequests.length; i++) {
        if (abt) {
            jsrequests[i].abort();
            ids[i] = 0;
        }
    }

    jsrequests = [];
    ids[ids.length] = idt;
    jsrequests[jsrequests.length] = p;

}


function baseService(http, q, obj, get, cancel, noloading) {

    var idt = ++id;

    if (noloading !== true) {

        noloading = false;

    }

    var p = q.defer();

    if (teste) {

        document.write("c=" + encode64SPEC(obj.query) + ((typeof obj["o"] !== 'undefined') ? ("&o=" + encode64SPEC(paraJson(obj.o))) : "") + "<hr>");

    }



    http({
        url: 'php/controler/crt.php',
        method: ((get == null) ? "POST" : "GET"),
        data: "c=" + encode64SPEC(obj.query) + ((typeof obj["o"] !== 'undefined') ? ("&o=" + encode64SPEC(paraJson(obj.o))) : ""),
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
        if (m == 0 && !noloading) {
            loading.close();
        }

        if (typeof obj["sucesso"] !== 'undefined') {
            var d = exx.data;
            while (d.length > 1) {
                if (d.charCodeAt(0) === 13 || d.charCodeAt(0) === 10) {
                    d = d.substr(1);
                    continue;
                }
                break;
            }



            obj.sucesso(paraObjeto(decode64SPEC(d)));
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
        if (m == 0 && !noloading) {
            loading.close();
        }

        if (typeof obj["falha"] !== 'undefined') {
            obj.falha(paraObjeto(decode64SPEC(exx.data)));
        }

    })

    var m = 0;
    for (var i = 0; i < ids.length; i++) {
        if (ids[i] > m) {
            m = ids[i];
        }
    }

    if (m == 0 && !noloading) {
        loading.show();
    }

    for (var i = 0; i < requests.length; i++) {
        if (cancel) {
            requests[i].resolve();
            ids[i] = 0;
        }
    }
    requests = [];

    if (!noloading)
        ids[ids.length] = idt;
    if (!noloading)
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

    if (xml.toLowerCase().indexOf('<?xml version="1.0" encoding="utf-8"?>') < 0) {
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

    var upStr = function (str, obj, fn) {

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

        var toui8 = function (s) {
            var s = unescape(encodeURIComponent(s));
            var buf = new ArrayBuffer(s.length);
            var vi = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) {
                vi[i] = s.charCodeAt(i);
            }
            return vi;
        }

        var bytes = toui8(str);
        var ext = "txt";

        var nome = "str_" + getRandom(40) + "." + ext;
        var buffer = 3 * 1000;

        obj.total += (bytes.length / buffer);

        f(bytes, buffer, 0, nome);

    }


    this.upload = function (arquivos, fn) {

        var obj = {total: 0, atual: 0, qtdArquivos: arquivos.length, arquivos: [], qtdFalhas: 0};

        for (var i = 0; i < arquivos.length; i++) {

            up(arquivos[i], obj, fn);

        }

    }

    this.uploadStr = function (arquivos, fn) {

        var obj = {total: 0, atual: 0, qtdArquivos: arquivos.length, arquivos: [], qtdFalhas: 0};

        for (var i = 0; i < arquivos.length; i++) {

            upStr(arquivos[i], obj, fn);

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
        templateUrl: 'cronometroooo.html',
        link: function (scope, element, attrs) {

            $interval(function () {

                scope.model -= 1000;

            }, 1000);

        }
    };
})

var mask = function (str, msk) {



    var k = [];
    for (var i = 0; i < msk.length; i++) {
        var c = msk.charAt(i);
        if (c === "x") {
            k[i] = null;
        } else {
            k[i] = c;
            str = str.split(c).join("");
        }
    }


    var ret = "";
    for (var i = 0, j = 0; i < str.length; i++) {
        var c = str.charAt(i);
        var m = null;
        if (i + j < k.length) {
            m = k[i + j];
        }

        if (m === null) {
            ret += c;
        } else if (c === m) {
            ret += c;
        } else {
            if (str.length >= i) {
                ret += m + c;
            }
        }
        if (m !== null) {
            j++;
        }
    }

    ret = ret.substr(0, msk.length);

    return ret;

}


rtc.directive('telefone', function ($timeout) {
    return {
        restrict: 'E',
        scope: {
            model: '='
        },
        templateUrl: 'txtTelefone.html',
        link: function (scope, element, attrs) {
            var rep = function (str) {
                if (str.indexOf('(11)9') >= 0) {
                    return mask(str, "(xx)xxxxx-xxxx");
                } else {
                    return mask(str, "(xx)xxxx-xxxx");
                }
            }
            scope.adjust = function () {
                scope.model = rep(scope.model);
            }

            $timeout(function () {
                scope.adjust();
            }, 3000);

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

function formatTextArea(str) {
    return str.split("\n").join(" <br> ");
}

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

                //Nomes dos grupos devem condizer com a da classe Email.php, acoplado :(, por????m infelizmente n????o vai dar tempo de tomar uma abordagem mais correta;
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
            refresh: '=?',
            maxWidth: '@?'
        },
        transclude: true,
        templateUrl: 'calendario5.html',
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


                scope.dia_i = {dia:0};
                scope.mes_i = {mes:0};
                scope.ano_i = {ano:0};

                scope.dia_f = {dia:0};
                scope.mes_f = {mes:0};
                scope.ano_f = {ano:0};


                if (typeof scope.maxWidth === 'undefined') {

                    scope.maxWidth = 800;

                }
                scope.botao = (typeof scope["botao"] === 'undefined') ? false : scope.botao;
                scope.tem_confirma = scope.confirma !== undefined;
                scope.dsp = !scope.botao;
                scope.trocar = function () {
                    
                    var rgn = function(k){
                        
                        var e = document.getElementById(k.attr('id'));
                        e.setSelectionRange(0,k.val().length);
                        
                    }
                    
                    scope.dsp = !scope.dsp;

                    if (scope.dsp) {
                        focoAtual = scope.idUnico;
                    }
                    setTimeout(function(){
                        
                        rgn($("#di"+scope.idUnico).focus().keyup(function(){
                            
                            if($(this).val().length === 2){
                            
                                rgn($("#mi"+scope.idUnico).focus());
                                
                            }
                            
                        }).click(function(){
                            
                            rgn($(this));
                            
                        }));
                        
                       $("#mi"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 2){
                            
                                rgn($("#ai"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                        
                       $("#ai"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 4){
                            
                                rgn($("#hi"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        }) 
                       
                       $("#hi"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 2){
                            
                                rgn($("#mmi"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                       
                       $("#mmi"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 2){
                            
                                rgn($("#df"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                       
                       $("#df"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 2){
                            
                                rgn($("#mf"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                       
                       $("#mf"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 2){
                            
                                rgn($("#af"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                       
                       $("#af"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 4){
                            
                                rgn($("#hf"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                       
                       $("#hf"+scope.idUnico).keyup(function(){
                           
                           if($(this).val().length === 2){
                            
                                rgn($("#mmf"+scope.idUnico).focus());
                                
                            }
                            
                       }).click(function(){
                            
                            rgn($(this));
                            
                        })
                        
                        
                        $("#mmf"+scope.idUnico).click(function(){
                            
                            rgn($(this));
                            
                        })
                        
                    },100)
                    
                    scope.$apply();
                    
                    

                }
                scope.foco = function () {

                    return focoAtual === scope.idUnico;

                }
                $(window).resize(function () {

                    scope.$apply();

                })
                scope.responsividade = function () {

                    var w = $(window).width();

                    if (w < parseInt(scope.maxWidth + "")) {

                        return false;
                    }
                    return true;

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

                        var d = new Date(parseInt(scope.model + ""));
                        d.setHours(scope.hora_model.hora);
                        d.setMinutes(scope.minuto_model.minuto);
                        scope.model = d.getTime();

                    }

                    if (typeof scope["inicio"] !== "undefined") {

                        var d = new Date(parseInt(scope.inicio + ""));

                        d.setHours(scope.hora_inicio.hora);
                        d.setMinutes(scope.minuto_inicio.minuto);
                        scope.inicio = d.getTime();

                    }

                    if (typeof scope["fim"] !== "undefined") {

                        var d = new Date(parseInt(scope.fim + ""));
                        d.setHours(scope.hora_fim.hora);
                        d.setMinutes(scope.minuto_fim.minuto);
                        scope.fim = d.getTime();

                    }


                }

                scope.trocaData = function () {

                    if (scope.intervalo) {

                        var dt = new Date();
                        dt.setDate(scope.dia_i.dia);
                        dt.setMonth(scope.mes_i.mes - 1);
                        dt.setYear(scope.ano_i.ano);

                        

                        var dtf = new Date();
                        dtf.setDate(scope.dia_f.dia);
                        dtf.setMonth(scope.mes_f.mes - 1);
                        dtf.setYear(scope.ano_f.ano);
                        
                        if(dt.getTime()>dtf.getTime()){
                            return;
                        }

                        scope.inicio = dt.getTime();

                        scope.fim = dtf.getTime();

                    } else {

                        var dt = new Date();
                        dt.setDate(scope.dia_i.dia);
                        dt.setMonth(scope.mes_i.mes - 1);
                        dt.setYear(scope.ano_i.ano);

                        scope.model = dt.getTime();

                    }


                    scope.attCalendario();

                    $timeout(function () {

                        scope.change();

                    }, 100)

                }

                scope.attCalendario = function () {

                    if (typeof scope["model"] === 'undefined') {
                        if (typeof scope["inicio"] === 'undefined' || typeof scope["fim"] === 'undefined') {
                            return;
                        }
                    }

                    scope.elementos = [];
                    var cmp = new Date(parseFloat(scope.model + ""));
                    var inicio = new Date(parseFloat(scope.inicio + ""));
                    var fim = new Date(parseFloat(scope.fim + ""));
                    var data = new Date(parseFloat(scope.initDate + ""));
                    var clone = new Date(parseFloat(scope.initDate + ""));

                    if (scope.intervalo) {

                        scope.dia_i.dia = inicio.getDate();
                        scope.mes_i.mes = inicio.getMonth() + 1;
                        scope.ano_i.ano = inicio.getFullYear();


                        scope.dia_f.dia = fim.getDate();
                        scope.mes_f.mes = fim.getMonth() + 1;
                        scope.ano_f.ano = fim.getFullYear();

                    } else {

                        scope.dia_i.dia = cmp.getDate();
                        scope.mes_i.mes = cmp.getMonth() + 1;
                        scope.ano_i.ano = cmp.getFullYear();

                    }

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

                scope.prevMonth = function (m) {
                    var dt = new Date(parseFloat(scope.initDate + ""));
                    if (dt.getMonth() > 0) {
                        dt.setMonth(dt.getMonth() - m);
                        dt.setDate(1);
                    } else {
                        dt.setYear(dt.getFullYear() - 1);
                        dt.setMonth(11);
                        dt.setDate(1);
                    }
                    scope.initDate = dt.getTime();
                    scope.attCalendario();
                }

                scope.nextMonth = function (m) {
                    var dt = new Date(parseFloat(scope.initDate + ""));
                    dt.setMonth(dt.getMonth() + m);
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
                            scope.hora_model.hora = new Date(parseFloat(scope.model + "")).getHours();
                            scope.minuto_model.minuto = new Date(parseFloat(scope.model + "")).getMinutes();
                        }

                        if (typeof scope["inicio"] !== 'undefined') {
                            scope.hora_inicio.hora = new Date(parseFloat(scope.inicio + "")).getHours();
                            scope.minuto_inicio.minuto = new Date(parseFloat(scope.inicio + "")).getMinutes();
                        }

                        if (typeof scope["fim"] !== 'undefined') {
                            scope.hora_fim.hora = new Date(parseFloat(scope.fim + "")).getHours();
                            scope.minuto_fim.minuto = new Date(parseFloat(scope.fim + "")).getMinutes();
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

rtc.directive('ngRightClick', function ($parse) {
    return function (scope, element, attrs) {
        var fn = $parse(attrs.ngRightClick);
        element.bind('contextmenu', function (event) {
            scope.$apply(function () {
                event.preventDefault();
                fn(scope, {$event: event});
            });
        });
    };
});

var scrolls = [];
rtc.directive('grafico', function ($sce, $timeout) {
    return {
        restrict: 'E',
        scope: {
            eixoY: '@',
            eixoX: '@',
            pontos: '=',
            decimal: '=',
            maxBars: '=',
            uniqueId: '=',
            legenda: '=',
            fixedMax: '=?'
        },
        templateUrl: 'grafico.html',
        link: function (scope, element, attrs) {

            function lk() {

                if (typeof scope.decimal === 'undefined') {

                    scope.decimal = false;

                }

                scope.pt = scope.pontos.length;

                if (typeof scope.maxBars !== 'undefined') {

                    scope.pt = scope.maxBars;

                }

                scope.np = parseInt(Math.max(1, scope.pt));


                scope.ymark = [];
                scope.scroll = 2;

                var a = null;
                for (var i = 0; i < scrolls.length; i++) {
                    if (scrolls[i].id === scope.uniqueId) {
                        a = scrolls[i];
                        scope.scroll = a.valor;
                    }
                }

                if (a === null) {
                    a = {id: scope.uniqueId, valor: scope.scroll};
                    scrolls[scrolls.length] = a;
                }

                scope.spacing = 0.5;
                scope.max = 0;
                var setMax = false;
                scope.min = 0;
                var setMin = false;
                var stoped = true;



                $(document).mouseup(function () {

                    stoped = true;

                })

                scope.addScroll = function () {

                    stoped = false;
                    var fn = function () {
                        if (scope.scroll + 2 > 3) {
                            stoped = true;
                            return;
                        }
                        scope.scroll += 2;
                        a.valor = scope.scroll;
                        if (!stoped) {
                            $timeout(fn, 20);
                        }
                    }

                    fn();
                }

                scope.removeScroll = function () {
                    stoped = false;
                    var fn = function () {

                        scope.scroll -= 2;
                        a.valor = scope.scroll;
                        if (!stoped) {
                            $timeout(fn, 20);
                        }
                    }
                    fn();
                }


                for (var i = 0; i < scope.pontos.length; i++) {

                    scope.pontos[i].numero = i;
                    scope.pontos[i].nome = $sce.trustAsHtml(scope.pontos[i].nome);

                    if (scope.pontos[i].valor > scope.max || !setMax) {
                        scope.max = scope.pontos[i].valor;
                        setMax = true;
                    }
                    if (scope.pontos[i].valor < scope.min || !setMin) {
                        scope.min = scope.pontos[i].valor;
                        setMin = true;
                    }
                }

                if (typeof scope["fixedMax"] !== 'undefined') {

                    scope.max = scope.fixedMax;

                }


                var itv = Math.abs(scope.max) / Math.min(scope.pontos.length, 12);

                if (!scope.decimal) {

                    itv = Math.ceil(itv);

                }

                if (itv === 0) {
                    scope.ymark = [0];
                } else {

                    for (var i = scope.min, j = 0; i <= scope.max; i += itv, j++) {
                        scope.ymark[scope.ymark.length] = {valor: i, numero: j};
                    }

                }

                scope.percent = function (ponto) {

                    var x = ponto.valor;


                    return ((x - scope.min) / (scope.max - scope.min)) * 100;

                }

            }

            lk();

            scope.$watchCollection(function () {
                return scope.pontos;
            }, function () {

                lk();

            }, true)


        }
    };
})


rtc.directive('paginacao', function () {
    return {
        restrict: 'E',
        scope: {
            assinc: '='
        },
        templateUrl: 'paginacao.html',
        link: function (scope, element, attrs) {
            

        }
    };
})

rtc.directive('myEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});