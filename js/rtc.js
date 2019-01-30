
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
