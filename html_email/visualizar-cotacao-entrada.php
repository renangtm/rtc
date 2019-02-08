<!DOCTYPE html>
<?php
    
    $p  = $GLOBALS['obj'];
  
    $logo = $p->empresa->getLogo(new ConnectionFactory());
   
    
?>
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
                    <th style="text-align:center;" id="logoEmpresa"><img src="data:image/png;base64, <?php echo $logo->logo; ?>" alt="" title=""></th>
                    <th style="padding:15px; width:65%;text-align:center;"><p class="text-center" style="font-size:14px;"><strong id="infoEmpresa"><?php echo $p->empresa->nome; ?>, Tel: <?php echo $p->empresa->telefone->numero; ?>, <?php echo $p->empresa->endereco->cidade->nome; ?> - <?php echo $p->empresa->endereco->cidade->estado->sigla; ?></strong>,<br>
                            <strong id="infoEmpresa2"><?php echo $p->empresa->endereco->bairro; ?>, <?php echo $p->empresa->endereco->rua; ?> <?php echo $p->empresa->endereco->cep->valor; ?>, <?php echo $p->empresa->email->endereco; ?></strong></p>
                    </th>
                </tr>
            </table>	
            <br>
            <table style="width:100%; border: 1px solid black;">
                <tr style="background-color:#ccc;">
                    <th style="padding:10px; border: 1px solid black;">Cotacao de compra - nº <strong id="idPedido"><?php echo $p->id; ?></strong>&nbsp&nbsp&nbsp&nbsp<a href="http://192.168.18.121:888/novo_rtc_web/resposta_cotacao.php?cotacao=<?php echo $p->id; ?>&empresa=<?php echo $p->empresa->id; ?>" style="font-weight:bold;font-size:20px;color:#ffc108;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black">CLIQUE AQUI PARA RESPONDER</a></th>
                </tr>
                <tr>
                    <td style="padding:10px;">
                        <table>
                            <tr>
                                <td width="100px">Vendedor:</td>
                                <td id="nomeUsuario"><?php echo $p->usuario->nome; ?></td>
                            </tr>
                            <tr>
                                <td>Fornecedor:</td>
                                <td id="nomeCliente"><?php echo $p->fornecedor->razao_social; ?></td>
                            </tr>
                            <tr>
                                <td>CPF/CNPJ:</td>
                                <td id="cnpjCliente"><?php echo $p->fornecedor->cnpj->valor; ?></td>
                            </tr>
                            <tr>
                                <td>Endereço:</td>
                                <td id="ruaCliente"><?php echo $p->fornecedor->endereco->rua; ?></td>
                            </tr>
                            <tr>
                                <td>Cidade:</td>
                                <td id="cidadeCliente"><?php echo $p->fornecedor->endereco->cidade->nome; ?></td>
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
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Quantidade <?php echo $p->tratar_em_litros?'Lt/Kg':'Emb' ?></td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Valor</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Total</td>
                </tr>
                <?php

                foreach ($p->produtos as $key => $value) {
                    ?>
                    <tr id="produto">
                        <td data-tipo="nome" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $value->produto->nome; ?></td>
                        <td data-tipo="quantidade" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $p->tratar_em_litros?($value->quantidade*$value->produto->quantidade_unidade):$value->quantidade; ?></td>
                        <td data-tipo="valor" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $p->tratar_em_litros?$value->valor:$value->valor/$value->produto->quantidade_unidade; ?> R$</td>
                        <td data-tipo="total" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $value->quantidade * ($value->valor); ?></td>
                    </tr>

    <?php

}
?>  

            </table>
            <br><br><br><br>
            <table style="width:100%;">
                <tr>
                    <td class="text-center" style="padding:10px;">Prazo: <strong id="prazo"><?php echo $p->prazo; ?></strong></td>
                    <td class="text-center" style="padding:10px;">Alicota ICMS: <strong id="alicota">--------</strong></td>
                    <td class="text-center" style="padding:10px;">Valor ICMS: <strong id="icms">---------</strong></td>
                </tr>
            </table>
            <br>
            <br>
            <table style="width:100%;">
                <tr>
                    <th colspan="6" class="text-center" style="padding:10px; border: 1px solid black;">Observações</th>
                </tr>
                <tr>
                    <td class="text-center" style="padding:10px; border: 1px solid black;" id="observacoes"><?php echo $p->observacao; ?></td>
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
                        <p id="nomeUsuario2"><?php echo $p->usuario->nome; ?></p>
                    </th>
                </tr>
            </table>

        </section>

    </body>

</html>