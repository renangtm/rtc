//@author Renan Gonçalves Teixeira Miranda
function toJson(xml,offset){
        var chs = ["<",">","</","/>"];
        var mtg = "";
        var obj = {};
        var buff = "";
        var a  = -1;
        var primitive = false;
        var fech = false;
        for(;offset<xml.length;offset++){
                var aux_offset = offset;
                for(var j=0;j<chs.length;j++){
                    var k = aux_offset;
                    try{
                        for(;xml.charAt(k)==chs[j].charAt(k-aux_offset) && (k-aux_offset)<chs[j].length && k<xml.length;k++);
                    }catch(ex){}
                    if((k-aux_offset)==chs[j].length){
                        a=j;
                        offset=k;
                    }
                }
            if(a==-1){
                buff+=xml.charAt(offset);
                primitive=true;
            }else if(a==0){
                buff+=xml.charAt(offset);
            }else if(a==1){
                if(fech){
                    if(buff==mtg){
                        return [obj,offset];
                    }
                    offset--;
                    fech = false;
                }else{            
                    if(mtg==""){
                        var ps = buff.split(" ");
                        for(var d=1;d<ps.length;d++){
                            var ll = ps[d].split("=",2);
                            obj[ll[0]]=ll[1].substr(1,ll[1].length-2);
                        }
                        buff = ps[0];
                        mtg = buff;
                        offset--;
                        a=-1;
                    }else{
                        var bl = buff.length;
                        buff = buff.split(" ")[0];
                        if(obj[buff] != undefined){
                            if(!Array.isArray(obj[buff])){
                                obj[buff] = [obj[buff]];
                            }
                        }
                        var res = xmlParaJsonObject(xml,offset-bl-2);
                        offset = res[1]-1;
                        if(Array.isArray(obj[buff])){
                            obj[buff][obj[buff].length] = res[0];
                        }else{
                            obj[buff] = res[0];
                        }
                    }
                    while((offset+1)<xml.length && xml.charAt(offset+1)==" ")offset++;
                }
                buff="";
            }else if(a==2){
                if(primitive){
                    return [buff,offset-chs[2].length];
                }
                fech = true;
                offset--;
                a=0;
            }else if(a==3){
                offset--;
                buff="";
            }
        }
        return [obj,offset];
    }