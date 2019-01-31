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
    <body class="A4">
        <input type="button" value="Imprimir" onclick="parent.window.focus();window.print();" />

        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-10mm">

            <!-- Write HTML just like a web page -->
            <table style="width:100%;">
                <tr>
                    <th style="text-align:center;"><img src="assets/images/logo_agrofauna_pedido.png" class="product-image" style="width:110%;margin-bottom: 20px;"></th>
                    <th style="padding:15px; width:65%;text-align:center;"><p class="text-center" style="font-size:14px;">SÃO JOSE DO RIO PRETO - SP, Rua Professor cavaleiro Salem,<br>
                            1136, CEP: 07195201, Telefone: 0000-0000</p>
                    </th>
                </tr>
            </table>	
            <br>
            <table style="width:100%; border: 1px solid black;">
                <tr style="background-color:#ccc;">
                    <th style="padding:10px; border: 1px solid black;">Dados da Cotação - nº 104759</th>
                </tr>
                <tr>
                    <td style="padding:10px;">
                        <table>
                            <tr>
                                <td width="100px">Vendedor:</td>
                                <td> 22 - CRISTINIS</td>
                            </tr>
                            <tr>
                                <td>Cliente:</td>
                                <td>Brasil Agro Comercio de Insumos Ltda</td>
                            </tr>
                            <tr>
                                <td>CPF/CNPJ:</td>
                                <td>10.446.322/0001-12</td>
                            </tr>
                            <tr>
                                <td>Endereço:</td>
                                <td>Fua Coutinho Cavalcanti</td>
                            </tr>
                            <tr>
                                <td>Cidade:</td>
                                <td>SP - SAO JOSE DO RIO PRETO</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <table style="width:100%;border: 1px solid black;">
                <tr>
                    <th colspan="6" class="text-center" style="background-color:#ccc;padding:10px; border: 1px solid black;">Produtos</th>
                </tr>
                <tr>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Produto</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Quantidade</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Valor</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Total</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Validade</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">Lote Fabricante</td>
                </tr>
                <tr>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">3403 - Rival 200 EC (Gl 5L)</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">4</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">300.1</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">1200.42</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
                </tr>
                <tr>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">3403 - Rival 200 EC (Gl 5L)</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">4</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">300.1</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">1200.42</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
                </tr>
                <tr>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">3403 - Rival 200 EC (Gl 5L)</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">4</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">300.1</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">1200.42</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
                </tr>
            </table>
            <br><br><br><br>
            <table style="width:100%;">
                <tr>
                    <td class="text-center" style="padding:10px;">Prazo: 30 dias</td>
                    <td class="text-center" style="padding:10px;">Alicota ICMS: 18.0</td>
                    <td class="text-center" style="padding:10px;">Valor ICMS: 0.0</td>
                </tr>
            </table>
            <br>
            <table style="width:100%">
                <tr>
                    <th width="50%" class="text-center" style="padding:10px; border: 1px solid black;background-color:#ccc;">Frete</th>
                    <th width="50%" class="text-center" style="padding:10px; border: 1px solid black;background-color:#ccc;">Redespacho</th>
                </tr>
                <tr>
                    <td width="50%" style="padding:10px; border: 1px solid black;">
                        <table>
                            <tr>
                                <td width="150px">Tipo de Frete:</td>
                                <td> Pago pelo cliente</td>
                            </tr>
                            <tr>
                                <td>Transportadora:</td>
                                <td>TRANSPORTE ANDORINHA</td>
                            </tr>
                            <tr>
                                <td>Contato:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Valor:</td>
                                <td>0.0</td>
                            </tr>
                        </table>

                    </td>
                    <td width="50%" style="padding:10px; border: 1px solid black;">
                        <table>
                            <tr>
                                <td width="150px">Tipo de Frete:</td>
                                <td> Pago pelo cliente</td>
                            </tr>
                            <tr>
                                <td>Transportadora:</td>
                                <td>-------</td>
                            </tr>
                            <tr>
                                <td>Contato:</td>
                                <td>-------</td>
                            </tr>
                            <tr>
                                <td>Valor:</td>
                                <td>0.0</td>
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
                    <td class="text-center" style="padding:10px; border: 1px solid black;">-------</td>
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
                        <p>22 - CRISTINIS</p>
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
