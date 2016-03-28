<html>
<head>
<style>
body {font-family: sans-serif;
    font-size: 10pt;
}
p {    margin: 0pt;
}
td { vertical-align: top; }
.items td {
    border: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
    text-align: center;
    border: 0.1mm solid #000000;
}
.items td.blanktotal {
    background-color: #FFFFFF;
    border: 0mm none #000000;
    border-top: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
}
.items td.totals {
    text-align: right;
    border: 0.1mm solid #000000;
}
</style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="30%" style="color:#0000BB; background-color: #212427">&nbsp;&nbsp;<img src="<?php echo Yii::app()->getBasePath(true) . '/../img/content/logo.png'; ?>"></td>
    <td style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;"><?php echo $order->id; ?></span></td>
</tr>
<tr>
<td style="color:#0000BB;"><br />NETGERON d.o.o.<br />Tehnološki park 024<br />1000 Ljubljana<br />Slovenia <br /></td>
<td width="70%" style="text-align: right;"></td>
</tr>

</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Netgeron.com
</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<div style="text-align: right">Date: <?php echo date('jS F Y')?></div>

<table width="100%" style="font-family: serif;" cellpadding="10">
<tr>
<td width="45%"></td>
<td width="10%">&nbsp;</td>
<td width="45%" style="border: 0.1mm solid #888888;"><span style="font-size: 7pt; color: #555555; font-family: sans;">INVOICE TO:</span><br /><?php echo !empty($order->user->billing->company_name) ? $order->user->billing->company_name . "<br/>": ''; ?><?php echo !empty($order->user->billing->full_name) ? $order->user->billing->full_name . "<br/>": ''; ?> <?php echo $order->user->billing->address; ?>, <?php echo $order->user->billing->city; ?>, <?php echo $order->user->billing->countryInfo->country_name; ?><br /><?php echo $order->user->billing->zip; ?></td>
</tr>
</table>
<br/>
<h3>Order Details:</h3>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
<thead>
<tr>
<td width="30%">Site</td>
<td width="40%">For</td>
<td width="20%">Anchor</td>
<td width="10%">Price</td>
</tr>
</thead>
<tbody>
<!-- ITEMS HERE -->
<?php foreach ($order->orderedProductsDetails as $p) {?>
<tr>
    <td align="center"><?php echo $p->product->title; ?></td>
<td align="center"><?php echo $p->url; ?></td>
<td align="center"><?php echo $p->anchor; ?></td>
<td align="right">$<?php echo $p->price; ?></td>
</tr>
<?php }?>
<!-- END ITEMS HERE -->
<tr>
<td class="blanktotal" colspan="2" rowspan="1"></td>
<td class="totals">TOTAL:</td>
<td class="totals">$<?php echo $order->total; ?></td>
</tr>
</tbody>
</table>
</body>
</html>