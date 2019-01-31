
rtc.controller("crtProdutos", function ($scope,culturaService,pragaService, produtoService, baseService, categoriaProdutoService,receituarioService) {

    $scope.produtos = createAssinc(produtoService, 1, 3, 10);
    $scope.produtos.attList();
    assincFuncs(
            $scope.produtos,
            "produto",
            ["id", "nome", "estoque","disponivel", "transito", "valor_base", "ativo","classe_risco"]);

    $scope.produto = {};
    $scope.produto_novo = {};
    $scope.receituario = {};

    $scope.categorias = [];
    
    $scope.deletarProduto = function(){
        
        baseService.delete($scope.produto,function(r){
            
            if(r.sucesso){
                
                msg.alerta("Deletado com sucesso");
                $scope.produtos.attList();
                
            }else{
                
                msg.erro("Problema ao deletar");
                
            }
            
            
            
        });

    }
    
    $scope.mergeProduto = function(){
        
        baseService.merge($scope.produto,function(r){
            
            if(r.sucesso){
                
                msg.alerta("Operação efetuada com sucesso");
                $scope.produto = r.o;
                $scope.produtos.attList();
                
            }else{
                
                msg.erro("Problema ao efetuar operação");
                
            }
            
            
            
        });
        
    }
    
    $scope.deleteReceituario = function(rec,produto){
        
        baseService.delete(rec,function(r){
            
            if(r.sucesso){
                
                msg.alerta("Deletado com sucesso");
                $scope.getReceituario(produto);
                
            }else{
                
                msg.erro("Problema ao deletar");
                
            }
            
            
            
        })
        
    }

    $scope.getReceituario = function(p){
       
       produtoService.getReceituario(p,function(r){
          
          p.receituario = r.receituario; 
          
       });
        
    }
    
    $scope.novoProduto = function(){
        
        $scope.produto = angular.copy($scope.produto_novo);
        
    }
    
    $scope.setProduto = function(produto){
     
        $scope.produto = produto;
    }

    produtoService.getProduto(function (p) {
        $scope.produto_novo = p.produto;
        $scope.receituario.produto = $scope.produto;
    })
    
     receituarioService.getReceituario(function (p) {
        $scope.receituario = p.receituario;
        $scope.receituario.produto = $scope.produto;
    })

    categoriaProdutoService.getElementos(function (f) {
        $scope.categorias = createList(f.elementos, 1, 10);
    })


})

rtc.controller("crtLogin", function ($scope, loginService) {
    $scope.usuario = "";
    $scope.senha = "";
    $scope.email = "";
    $scope.logar = function () {
        loginService.login($scope.usuario, $scope.senha, function (r) {
            if (r.usuario == null || !r.sucesso) {
                msg.erro("Esse usuÃ¡rio nÃ£o existe");
            } else {
                window.location = "index_em_branco.php";
            }
        });
    };

    $scope.recuperar = function () {

        loginService.recuperar($scope.email, function (r) {
            if (r.sucesso) {

                msg.alerta("Senha enviada para o email");

            } else {

                msg.erro("Falha ao recuperar, provavelmente esse email nao esta cadastrado");

            }

        });

    }

})