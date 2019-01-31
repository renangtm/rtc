var usuario = null;
var empresa = null;
var logo = null;

rtc.controller("crtProdutos", function ($scope, $controller, acessoService) {



})


rtc.controller("crtAcessos", function ($scope, $rootScope, acessoService) {

    $rootScope.usuario = null;
    $rootScope.empresa = null;
    $rootScope.logo = null;

    acessoService.getAcesso(function (r) {

        if (!r.sucesso || r.usuario == null || r.empresa == null) {

            window.location = "index.php";

        } else {

            $rootScope.usuario = r.usuario;
            $rootScope.empresa = r.empresa;
            $rootScope.logo = r.logo;

        }

    })

})

rtc.controller("crtLogin", function ($scope, loginService) {
    $scope.usuario = "";
    $scope.senha = "";
    $scope.email = "";
    $scope.logar = function () {
        loginService.login($scope.usuario, $scope.senha, function (r) {
            if (r.usuario == null || !r.sucesso) {
                msg.erro("Esse usuário não existe");
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