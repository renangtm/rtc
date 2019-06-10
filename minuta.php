<!doctype html>
<html lang="en" ng-app="appRtc">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <script src="js/angular.min.js"></script>
        <script src="js/rtc.js?125"></script>
        <script src="js/filters.js?125"></script>
        <script src="js/services.js?125"></script>
        <script src="js/controllers.js?125"></script>  
		<script src="https://www.rtcagro.com.br/assets/vendor/jquery/jquery-3.3.1.min.js"></script>    

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://www.rtcagro.com.br/assets/vendor/bootstrap/css/bootstrap.min.css">
        <link href="https://www.rtcagro.com.br/assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/libs/css/style.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        
        <link rel="stylesheet" type="text/css" href="https://www.rtcagro.com.br/assets/vendor/datatables/css/buttons.bootstrap4.css">
        <link rel="stylesheet" type="text/css" href="https://www.rtcagro.com.br/assets/vendor/datatables/css/select.bootstrap4.css">
        

        <?php

        	include("includes.php");

        	$con = new ConnectionFactory();

        	$notas = Utilidades::base64decodeSPEC($_GET['notas']);

        	$id_empresa = Utilidades::base64decodeSPEC($_GET['id_empresa']);


        	$notas = explode(';',$notas);

        	$empresa = new Empresa(intval($id_empresa.""),$con);

        	$in_notas = "(-1";

        	foreach($notas as $key=>$value){
        		$in_notas .= ",$value";
        	}

        	$in_notas .= ")";

        	$notas = $empresa->getNotas($con,0,100,"nota.id IN $in_notas");

        	$agrupadas = array();

            $logos = array();

        	foreach($notas as $key=>$value){

        		$ps = $con->getConexao()->prepare("SELECT frete,id_logistica FROM pedido WHERE id=(SELECT id_pedido FROM nota WHERE id=$value->id)");
        		$ps->execute();
        		$ps->bind_result($frete,$id_logistica);
        		if($ps->fetch()){
        			$value->frete = $frete;

                    if($id_logistica > 0){

                        $value->id_empresa=$id_logistica;

                    }   

        		}else{
        			$value->frete = 0;
                    $value->empresa->logo = null;
        		}
        		$ps->close();

        		$value->produtos = $value->getProdutos($con);
        		$value->total = 0;
        		$value->volumes = 0;
        		$value->peso = 0;

        		foreach($value->produtos as $key2=>$value2){
        			$value->total += $value2->valor_total;

        			$value->volumes += $value2->quantidade/max($value2->produto->grade->gr[0],1);
        			$value->peso += $value2->quantidade*$value2->produto->peso_bruto;
        		}

        	
        		$hash = $value->transportadora->id."-";

        		if($value->saida){
        			$hash .= $value->cliente->id;
        		}else{
        			$hash .= $value->fornecedor->id;
        		}

        		if(!isset($agrupadas[$hash])){


        			$agrupadas[$hash] = array();

        		}

        		$agrupadas[$hash][] = $value;

        	}

            foreach($notas as $key=>$value){

                if(isset($value->id_empresa)){

                    $value->empresa = new Logistica($value->id_empresa,$con);

                }

                $l = $value->empresa;

                if(!isset($logos[$l->id])){

                    $logos[$l->id] = $l->getLogo($con);

                }


                $value->empresa->logo = $logos[$l->id];

            }

        ?>
        <style>
		@media print{    
			.no-print, .no-print *{
				display: none !important;
			}
		}
	</style>
    </head>
    <body>
		<div class="no-print" style="width:800px;margin: 20px;">
			<input style="text-align:right" type="button" value="Imprimir" onclick="parent.window.focus();window.print();" />
		</div>	
		<?php foreach($agrupadas as $key=>$value){

			$nf = $value[0];
			$pessoa = ($nf->saida?$nf->cliente:$nf->fornecedor);


			$frete = 0;

			foreach($value as  $key2=>$value2){
				$frete += $value2->frete;
			}

		 ?>
		<div style="display: block;margin-bottom:20px">
        <div style="width:800px;border: 1px solid black;padding:20px;margin: 20px;width: auto;">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h4><strong>Minuta para Despacho de Mercadoria</strong></h4><br>
                        <table style="width: 400px;">
                            <tr>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" width="120px">Transportadora: </td>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" ><? echo $nf->transportadora->razao_social; ?> </td>
                            </tr>
                            <tr>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);">Redespacho: </td>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" ></td>
                            </tr>
                            <tr>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);">Destinatário: </td>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" ><?

                                	echo (isset($pessoa->razao_social)?$pessoa->razao_social:$pessoa->nome);

                                 ?> </td>
                            </tr>
                            <tr>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);">Endereço:</td>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" ><?php echo $pessoa->endereco->rua; ?> </td>
                            </tr>
                            <tr>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);">Cidade: </td>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" ><?php echo $pessoa->endereco->cidade->nome; ?></td>
                            </tr>
                            <tr>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);">UF: </td>
                                <td style="margin: 0px; text-size-adjust: none; font-size: 14px; font-family: arial, &quot;helvetica neue&quot;, helvetica, sans-serif; line-height: 21px; color: rgb(51, 51, 51);" ><?php echo $pessoa->endereco->cidade->estado->sigla; ?></td>
                            </tr>
                            
                        </table>
                        <br>
                       <table width = "450" border = "1">
								<tr>
									<th style="text-align:center;">Nota Fiscal</th>
									<th style="text-align:center;">Valor da Nota Fiscal</th>
									<th style="text-align:center;">Quantidade</th>
									<th style="text-align:center;">Peso </th>
								</tr>	
								<?php foreach($value as $key2=>$nota){ ?>
                                <tr>
                                    <td align="center"><?php echo $nota->numero; ?></td>
                                    <td align="center">R$ <?php echo round($nota->total,2); ?></td>
                                    <td align="center"><?php echo round($nota->volumes,2); ?></td>
                                    <td align="center"><?php echo round($nota->peso,2); ?></td>
                                </tr>
                            	<?php } ?>




                            </table>


                    </div>
                    <div class="col">
                        <div class="row" style="margin-left:15px;">
							<table>
                            <tr>
                                <td><img src="data:image/png;base64, <?php echo $nf->empresa->logo->logo; ?>" alt="logistic" class="logistic-xxl" ><br><br></td>
                            </tr>
                            
							<tr>
                                <td><?php echo $nf->empresa->endereco->rua.",".$nf->empresa->endereco->numero; ?></td>
                            </tr>
							<tr>
                                <td><?php echo $nf->empresa->endereco->bairro; ?></td>
                            </tr>
							<tr>
                                <td>CEP <?php echo $nf->empresa->endereco->cep->valor; ?></td>
                            </tr>
							<tr>
                                <td><?php echo $nf->empresa->endereco->cidade->nome; ?></p></td>
                            </tr>
							<tr>
                                <td>
								<div class="form-group">
                                <div class="form-row">

                                    <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                        <input type="radio" id="customRadioInline<?php echo $nf->id; ?>" name="<?php echo $nf->id; ?>b" class="custom-control-input ng-pristine ng-untouched ng-valid ng-not-empty" value="false">
                                        <label class="custom-control-label" for="customRadioInline<?php echo $nf->id; ?>"><strong>PAGO</strong></label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline" style="margin-top: 5px;">
                                        <input type="radio" id="customRadioInline<?php echo $nf->id; ?>b" name="<?php echo $nf->id; ?>b" class="custom-control-input ng-pristine ng-untouched ng-valid ng-not-empty" checked="" value="true">
                                        <label class="custom-control-label" for="customRadioInline<?php echo $nf->id; ?>b"><strong>A PAGAR</strong></label>
                                    </div>

                                </div>
                            </div>
								</td>
                            </tr>
					<tr>
                                <td><strong>Valor do Frete: </strong> <?php echo ($frete>0?round($frete,2):"_____________"); ?> </td>
                            </tr>
<tr>
                                <td><strong> Data: </strong> <?php echo date('d/m/Y',microtime(true)); ?></td>
                            </tr>
<tr>
                                <td><strong>Horas: </strong><?php echo date('H:i',microtime(true)); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Placa: </strong>______________________</td>
                            </tr>
<tr>
                                <td><strong>Nome: </strong>______________________</td>
                            </tr>
<tr>
                                <td><strong>RG:</strong> __________________________</td>
                            </tr>
                            <tr>
                                <td><strong>Assinatura:</strong> __________________________</td>
                            </tr>
                    </table>    
          </div>
      </div>
  </div>
</div>
</div>

   	</div>
   <?php } ?>
    </body>
</html>