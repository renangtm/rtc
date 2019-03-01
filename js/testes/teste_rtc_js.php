<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>

        <meta charset="UTF-8">
        <title></title>

        <script type="text/javascript" src="../rtc.js"></script>

    </head>
    <body>

        <script>


            var xml = "<html><teste>1234<teste111></teste><teste1234>12344312</teste1234></html>";


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
                            k++;
                            break;
                        }
                    }
                    if (k % 2 === 0 && bb !== b && (b < 0 || bb >= 0)) {
                        preCompile[preCompile.length] = {valor: "", tipo: bb, atributos:{},filhos:[],fechamento:null};
                        b = bb;
                    } else if(k%2 === 0){
                        preCompile[preCompile.length - 1].valor += c;
                    }else{                     
                        preCompile[preCompile.length - 1].valor += (c !== " ")?c:"<space>";                       
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
                    if(k.length > 1 && p.tipo>0){                       
                        if(k[0] === "!--" || k[0] === "?php" || k[0] === "?")
                            continue;                       
                        p.valor = k[0];                      
                        for(var j=1;j<k.length;j++){
                            var l = k[j].split('=');
                            if(l.length === 2){
                                p.atributos[l[0]] = l[1].split("<space>").join(" ");
                            }else{
                                p.atributos[l[0]] = true;
                            }
                        }                        
                    }
                    refineCompile[refineCompile.length] = p;
                }     
                var k = -1;     
                var elemento = null;
                var pilha = [];
                for(var i=0;i<refineCompile.length;i++){
                    var e = refineCompile[i];
                    if(e.tipo === 0){
                        if(elemento === null){
                            elemento = e;
                        }else{
                            pilha[pilha.length-1].filhos[pilha[pilha.length-1].filhos.length] = e;
                        }
                        pilha[pilha.length] = e;
                    }else if(e.tipo === 1){
                        pilha[pilha.length-1].filhos[pilha[pilha.length-1].filhos.length] = e;
                    }else if(e.tipo === -1){
                        
                        var n = 1;
                        
                        while(n<=pilha.length && pilha[pilha.length-n].valor !== e.valor)
                            n++;
                        
                        if(n<=pilha.length){
                            pilha[pilha.length-n].fechamento = e;
                            pilha.length -= n;
                        }
                        
                    }
                }
                return elemento;
                
            }

            document.write(JSON.stringify(DOMToJson(xml)));

        </script>

    </body>
</html>
