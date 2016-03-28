Hello <?php echo $user->name?>,

Thanks for using Netgeron,

This is a payment receipt for Invoice <?php echo $order->id; ?> sent on <?php echo date('m/d/Y', $order->timeInt()); ?>

Amount: $<?php echo $order->total; ?> USD
Invoice #: <?php echo $order->id; ?>
Total Paid: $<?php echo $order->total; ?> USD
Status: Paid

You may review your invoice history at any time by logging in to your client area.

Note: This email will serve as an official receipt for this payment.

--
Best Regards,
Netgeron Administration