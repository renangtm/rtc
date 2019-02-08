<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }
  body.A4 .sheet {
    width: auto;
    height: auto;
  }
  
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4" id="corpo">
<input type="button" value="Imprimir" onclick="parent.window.focus();window.print();" />

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">

    <!-- Write HTML just like a web page -->
	<table style="width:100%;">
		<tr>
			<th style="text-align:center;" id="logoEmpresa"></th>
			<th style="padding:15px; width:65%;text-align:center;"><p class="text-center" style="font-size:14px;"><strong id="infoEmpresa"></strong>,<br>
				<strong id="infoEmpresa2"></strong></p>
			</th>
		</tr>
	</table>	
	<br>
    <table style="width:100%; border: 1px solid black;">
					  <tr style="background-color:#ccc;">
						<th style="padding:10px; border: 1px solid black;">Dados da cotacao - nº <strong id="idPedido"></strong></th>
					  </tr>
					  <tr>
						<td style="padding:10px;">
							<table>
								<tr>
									<td width="100px">Vendedor:</td>
									<td id="nomeUsuario"> </td>
								</tr>
								<tr>
									<td>Cliente:</td>
									<td id="nomeCliente"></td>
								</tr>
								<tr>
									<td>CPF/CNPJ:</td>
									<td id="cnpjCliente"></td>
								</tr>
								<tr>
									<td>Endereço:</td>
									<td id="ruaCliente"></td>
								</tr>
								<tr>
									<td>Cidade:</td>
									<td id="cidadeCliente"></td>
								</tr>
							</table>
						</td>
					  </tr>
					</table>
					<br>
					<table id="produtos" style="width:100%;border: 1px solid black;">
					  <tr>
						<th colspan="5" class="text-center" style="background-color:#ccc;padding:10px; border: 1px solid black;">Produtos</th>
					  </tr>
					  <tr>
						<td class="text-center" style="padding:10px; border: 1px solid black;">Produto</td>
						<td class="text-center" style="padding:10px; border: 1px solid black;">Quantidade</td>
						<td class="text-center" style="padding:10px; border: 1px solid black;">Valor</td>
						<td class="text-center" style="padding:10px; border: 1px solid black;">Total</td>
						<td class="text-center" style="padding:10px; border: 1px solid black;">Validade</td>
					  </tr>
					  <tr id="produto">
						<td data-tipo="nome" class="text-center" style="padding:10px; border: 1px solid black;"></td>
						<td data-tipo="quantidade" class="text-center" style="padding:10px; border: 1px solid black;"></td>
						<td data-tipo="valor" class="text-center" style="padding:10px; border: 1px solid black;"></td>
						<td data-tipo="total" class="text-center" style="padding:10px; border: 1px solid black;"></td>
						<td data-tipo="validade" class="text-center" style="padding:10px; border: 1px solid black;"></td>
					  </tr>

					</table>
					<br><br><br><br>
					<table style="width:100%;">
					  <tr>
						<td class="text-center" style="padding:10px;">Prazo: <strong id="prazo"></strong></td>
						<td class="text-center" style="padding:10px;">Alicota ICMS: <strong id="alicota"></td>
						<td class="text-center" style="padding:10px;">Valor ICMS: <strong id="icms"></strong></td>
					  </tr>
					</table>
					<br>
					
					<br>
					<table style="width:100%;">
					  <tr>
						<th colspan="6" class="text-center" style="padding:10px; border: 1px solid black;">Observações</th>
					  </tr>
					  <tr>
						<td class="text-center" style="padding:10px; border: 1px solid black;" id="observacoes"></td>
					  </tr>  
					</table>
					<table style="width:100%;">
					  <tr>
						<th style="padding:10px;">
							<br>
							<p>Favor retornar pedido carimbado e assinado</p>
							<p>Não aceitamos devolução de mercadoria</p>
							<p>Fica condicionado ao comprador consultar o fabricante do produto sobre<br>
							possível restrições de comercialização em seu estado.</p>
						</th>
					  </tr>
					</table>
					<table style="width:100%;">
					  <tr>
						<th class="text-center"  style="padding:10px;">
							<p>Atenciosamente,</p>
							<p id="nomeUsuario2"></p>
						</th>
						<th class="text-center" style="padding:10px;">
							<p>_____________________________</p>
							<p>Carimbo e assinatura</p>
						</th>
					  </tr>
					</table>

  </section>

</body>

</html>