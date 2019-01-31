
rtc.service('acessoService', function ($http, $q) {
    this.getAcesso = function(fn){   
        baseService($http,$q,{
            query:"$r->usuario=$ses->get('usuario');$r->empresa=$ses->get('empresa');$r->logo=$r->empresa->getLogo($c)",
            sucesso:fn,
            falha:fn
        });   
    }
})

rtc.service('loginService', function ($http, $q) {
    this.login = function(usuario,senha,fn){   
        baseService($http,$q,{
            o:{u:usuario,s:senha},
            query:"$r->usuario=Sistema::logar($o->u,$o->s)",
            sucesso:fn,
            falha:fn
        });   
    }
    this.recuperar = function(email,fn){
        baseService($http,$q,{
            o:{email:email},
            query:"$u=Sistema::getUsuario(\"email.endereco='$o->email'\");if($u==null)throw new Exception('');$s=Sistema::getEmailSistema();$s->enviarEmail($u->email,'Recuperacao de Senha',Sistema::getHtml('rec_sen',$u))",
            sucesso:fn,
            falha:fn
        });   
    }
})


