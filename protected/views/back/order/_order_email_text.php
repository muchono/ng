Hello <?php echo $order->user->name?>,

Thanks for using Netgeron,

Your order (Invoice #: <?php echo $order->id?>)  is completely done.
You can check links to ready publications your section Live Report:
<?php echo Yii::app()->getBaseUrl(true) . '/buyPublication/LiveReport'?>

Note: You got this message because you've ordered writing and placing publications on Netegron.

--
Best Regards,
Netgeron Administration