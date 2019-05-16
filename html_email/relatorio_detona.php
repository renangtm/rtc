<!DOCTYPE html>
<?php

$p = $GLOBALS['obj'];
$logo = $p->empresa->getLogo(new ConnectionFactory());

?>
<html>
    <head>
        <style>
            table td{
                border:2px solid;
                padding:10px;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <table align="center" width="100%" style="font-family: arial, times, &quot;times new roman&quot;, serif; max-width: 800px; min-width: 600px; font-size: 14px; border: 2px solid rgb(65, 65, 65);" border="0" cellspacing="0" cellpadding="0" class="t">
            <tbody style="">
                <tr style="">
                    <td colspan="5" style="">
                        <img src="data:image/png;base64, <?php echo $logo->logo; ?>" style="height:70px;">
                        <hr>
                        <h3 style="">RELATORIO DO DIA <?php echo date('d/m/Y',$p->data/1000); ?> ---- ATUALIZADO DO RTC</h3>
                    </td>
                </tr>
                <tr style="">
                    <td style="">
                        <b style="">CODIGO</b>
                    </td>
                    <td style="">
                        <b style="">NOME</b>
                    </td>
                    <td style="">
                        <b style="">VALIDADE</b>
                    </td>
                    <td style="">
                        <b style="">QUANTIDADE</b>
                    </td>
                    <td style="">
                        <b style="">SITUACAO</b>
                    </td>
                </tr>
                <?php foreach($p->produtos as $key=>$value){ ?>
                <tr style="">
                    <td style=""><?php echo $value->codigo; ?></td>
                    <td style=""><?php echo $value->nome; ?></td>
                    <td style=""><?php echo date('d/m/Y',$value->validade/1000); ?></td>
                    <td style=""><?php echo $value->quantidade; ?></td>
                    <td style=""><?php echo $value->situacao; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </body>
</html>