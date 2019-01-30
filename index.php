<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - RTC (Reltrab Cliente) - WEB</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
	.splash-description {
		margin-top: 25px;
		padding-bottom: 0px;
	}
	a:hover {
		color: #4aaf51;
		text-decoration: none;
	}
	.splash-container {
		max-width: 500px;
		padding: 35px;
	}
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="index.html"><img class="logo-img" src="assets/images/logo.png" alt="logo"></a><span class="splash-description text-left">Bem vindo ao RTC.</span></div>
            <div class="card-body">
                <form>
                    <div class="form-group">
						<div class="input-group">
							<span class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i></span></span>
							<input class="form-control form-control-lg" id="username" type="text" placeholder="Insira aqui seu número de usuário" autocomplete="off">
						</div>	
                    </div>
                    <div class="form-group">
						<div class="input-group">
							<span class="input-group-prepend"><span class="input-group-text"><i class="fa fa-lock"></i></span></span>
							<input class="form-control form-control-lg" id="password" type="password" placeholder="Insira aqui sua senha">
						</div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Entrar</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0 text-center">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link" href="#" data-toggle="modal" data-target="#senha" onclick="limpaCamposEsqueceuSenha();">Esqueceu a senha?</a>
                </div>
            </div>
        </div>
    </div>
	
	
<!-- Modal ESQUECEU SUA SENHA -->
	
	           <div class="modal fade" id="senha" tabindex="-1" role="dialog" aria-labelledby="senha" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
					<h4 class="modal-title" id="modalRecuperaLabel">Esqueceu sua senha?</h4>
                  	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
					</button>
                  </div>
				  <div>
                  <div class="modal-body"><br>
                        <div id="respostaCliente1" class="alert alert-danger" role="alert" style="display: none;">Email inválido.</div>
						<p>Nós só precisamos do seu endereço de e-mail registrado para enviar sua senha redefinida.</p>
						
                      <div class="form-group row">
                        <label for="recipient-name" class="col-sm-2 form-control-label normal align-middle" style="margin-top: 10px; padding-left: 40px;">Email:</label>
                        <div class="col-sm-9">
                        	<input type="text" class="form-control form-control-lg" id="txtEmail" placeholder="Insira aqui seu e-mail" style="text-align:center">
                        </div>
                      </div>
					  <br> 				  

                  </div>
                  <div class="modal-footer" style="text-align:center;">
							<button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
							<button id="btRecuperar" class="btn btn-primary">Resetar senha</button>
				  </div>
				  </div>				  
                </div>
                  
                </div>
              </div>

  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
	
	<script type="text/javascript">
	
		function limpaCamposEsqueceuSenha(){
						
					$("#txtEmail").val(""); 
					$("#respostaCliente1").css('display','none');
					
		}
		
		function is_email(email){
				er = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2}/;
					  
				if(er.exec(email)){
						  return true;
				} else {
						  return false;
				}
		}
		
		$('#btRecuperar').click(function() {

				var email = $("#txtEmail").val();
				
				if(email == ""){
					$("#respostaCliente1").removeClass( "alert-success" ).addClass( "alert-danger" );
					$("#respostaCliente1").css('display','block');
					$("#respostaCliente1").html("Preencha todos os dados corretamente.");
					return false;
				}else{
					if(!is_email(email)){
						$("#respostaCliente1").removeClass( "alert-success" ).addClass( "alert-danger" );
						$("#respostaCliente1").css('display','block');
						$("#respostaCliente1").html("Email inválido.");
						return false;
					
					}else{
						$("#respostaCliente1").removeClass( "alert-danger" ).addClass( "alert-success" );
						$("#respostaCliente1").css('display','block');
						$("#respostaCliente1").html("Senha enviada para seu email");

						$.post('crt_recuperar.php',{email:email}).done(function(e){

							alert(e);

						})

						return false;
					}	
				}	
			});
			
	</script>
</body>
 
</html>