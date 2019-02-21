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
                    <th style="padding:10px; border: 1px solid black;">Dados do pedido - nº <strong id="idPedido"><?php echo $p->id; ?></strong></th>
                </tr>
                <tr>
                    <td style="padding:10px;">
                        <table>
                            <tr>
                                <td width="100px">Vendedor:</td>
                                <td id="nomeUsuario"><?php echo $p->usuario->nome; ?></td>
                            </tr>
                            <tr>
                                <td>Cliente:</td>
                                <td id="nomeCliente"><?php echo $p->cliente->razao_social; ?></td>
                            </tr>
                            <tr>
                                <td>CPF/CNPJ:</td>
                                <td id="cnpjCliente"><?php echo $p->cliente->cnpj->valor; ?></td>
                            </tr>
                            <tr>
                                <td>Endereço:</td>
                                <td id="ruaCliente"><?php echo $p->cliente->endereco->rua; ?></td>
                            </tr>
                            <tr>
                                <td>Cidade:</td>
                                <td id="cidadeCliente"><?php echo $p->cliente->endereco->cidade->nome; ?></td>
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
                <?php
                $valor_icms = 0;
                $valor_total = 0;
                $base_calculo = 0;
                foreach ($p->produtos as $key => $value) {
                    ?>
                    <tr id="produto">
                        <td data-tipo="nome" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $value->produto->nome; ?></td>
                        <td data-tipo="quantidade" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $value->quantidade; ?></td>
                        <td data-tipo="valor" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo ($value->valor_base + $value->icms + $value->ipi + $value->juros + $value->frete); ?> R$</td>
                        <td data-tipo="total" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo $value->quantidade * ($value->valor_base + $value->icms + $value->ipi + $value->juros + $value->frete); ?></td>
                        <td data-tipo="validade" class="text-center" style="padding:10px; border: 1px solid black;"><?php echo date('d/m/Y',$value->validade_minima); ?></td>
                    </tr>

    <?php
    $valor_icms += $value->icms;
    $valor_total += $value->quantidade * ($value->valor_base + $value->icms + $value->ipi + $value->juros + $value->frete);
    $base_calculo += $value->base_calculo;

    $alicota = round($valor_icms * 100 / $base_calculo, 2);
}
?>  

            </table>
            <br><br><br><br>
            <table style="width:100%;">
                <tr>
                    <td class="text-center" style="padding:10px;">Prazo: <strong id="prazo"><?php echo $p->prazo; ?></strong></td>
                    <td class="text-center" style="padding:10px;">Alicota ICMS: <strong id="alicota"><?php echo $alicota; ?></strong></td>
                    <td class="text-center" style="padding:10px;">Valor ICMS: <strong id="icms"><?php echo $valor_icms; ?></strong></td>
                </tr>
            </table>
            <br>
            <table style="width:100%">
                <tr>
                    <th width="100%" class="text-center" style="padding:10px; border: 1px solid black;background-color:#ccc;">Frete</th>
                </tr>
                <tr>
                    <td width="100%" style="padding:10px; border: 1px solid black;">
                        <table>
                            <tr>
                                <td width="150px">Tipo de Frete:</td>
                                <td id="tipoFrete"><?php echo $p->incluir_frete ? "CIF" : "FOB"; ?></td>
                            </tr>
                            <tr>
                                <td>Transportadora:</td>
                                <td id="nomeTransportadora"><?php echo $p->transportadora->razao_social; ?></td>
                            </tr>
                            <tr>
                                <td>Contato:</td>
                                <td id="contatoTransportadora"><?php echo $p->transportadora->email->endereco; ?></td>
                            </tr>
                            <tr>
                                <td>Valor:</td>
                                <td id="valorFrete"><?php echo $p->frete; ?></td>
                            </tr>
                        </table>

                    </td>

                </tr>
            </table>  
            <br>
            <table style="width:100%;">
                <tr>
                    <th colspan="6" class="text-center" style="padding:10px; border: 1px solid black;">Observações</th>
                </tr>
                <tr>
                    <td class="text-center" style="padding:10px; border: 1px solid black;" id="observacoes"><?php echo $p->observacoes; ?></td>
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
                    <th class="text-center" style="padding:10px;">
                        <p>_____________________________</p>
                        <p>Carimbo e assinatura</p>
                    </th>
                </tr>
            </table>

        </section>

    </body>

</html>