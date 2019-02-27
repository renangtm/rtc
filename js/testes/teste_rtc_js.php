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
            
            function htmlToJson(html){
                
                var j = 1;
                var tbl = [];
                var spec = [];
                
                var a = 0;
                var b = 0;
                for(var i=0;i<html.length;i++){
                    
                    var c = html.charAt(i);
                    
                    if(a === 1){
                        
                        if(b%2===1){
                            tbl[j] += c;
                        }else{
                            spec[j].atributos[spec[j].atributos.length-1] += c;
                        }
                    }
                    
                    if(c === "<" && a === 0){
                        
                        a=1;
                        b=0;
                        j++;
                        
                        tbl[j] = "";
                        spec[j] = {entrada:true,atributos:[]};
                        
                        continue;
                        
                    }
                    
                    if(a > 0 && c === "/"){
                        
                        if(html.charAt(i+1) === ">"){
                            
                            a = 0;
                            
                        }
                        
                    }else if (a > 0 && c === ">"){
                        
                        a = 0;
                        
                    }else if(a > 0 && c === "\""){
                        
                        b++;
                        if(b%2===1){
                            
                            spec[j].atributos[spec[j].atributos.length] = "";
                            
                        }
                        
                    }
                    
                    
                }
                
            }
            
            document.write(htmlToJson('<html><table><td>Notificacao:</td> <td style="margin frfrfr"></td></table></html>'));
            
            
        </script>
        
    </body>
</html>
