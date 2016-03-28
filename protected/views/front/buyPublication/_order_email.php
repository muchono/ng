<?php
/* @var $this UserController */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width"/>
		<style type="text/css">
			
		</style>
		<style type="text/css">

			body {
				margin: 0;
			}

		</style>
	</head>
<body>
	<div bgcolor="#f4f4f4" marginwidth="0" marginheight="0" style="margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;background-color:#f7f7f7;background-image:none;background-repeat:repeat;overflow:hidden;">

		<table style="border-spacing:0" width="700" align="center" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td style="font-size:0;line-height:0;border-collapse:collapse" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td style="padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;text-align:left;border-collapse:collapse" valign="middle">
						<a href="#" style="display:inline-block;color:#3686be" target="_blank">
							<img src="<?php echo Yii::app()->getBaseUrl(true);?>/img/email/logo.png" alt="alt text" height="34" width="182" border="0" class="CToWUd"></a>
					</td>
					<td style="padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;text-align:right;font-family:Helvetica,Arial,sans-serif;font-size:12px;border-collapse:collapse" valign="middle">
					</td>
				</tr>
				<tr>
					<td style="font-size:0;line-height:0;border-collapse:collapse" height="15">&nbsp;</td>
				</tr>
			</tbody>
		</table>

		<table style="background-color:#ffffff;background-image:none;background-repeat:repeat;border-width:1px;border-style:solid;border-color:#d2d2d2;border-spacing:0;margin-bottom:40px;" width="700" align="center" border="0" cellpadding="0" cellspacing="0">

			<tbody>
				<tr>
					<td style="border-collapse:collapse"></td>
				</tr>

				<tr>
					<td style="border-collapse:collapse">
						<table style="border-spacing:0" width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td style="border-collapse:collapse">

										<table style="border-spacing:0" width="100%" border="0" cellpadding="0" cellspacing="0">

											<tbody>
												<tr>
													<td style="padding-top:20px;padding-bottom:0;padding-right:40px;padding-left:40px;font-family:sans-serif;font-size:20px;line-height:27px;border-collapse:collapse">
                                                        <h3 style="font-weight:bold;font-size:30px;color:#333333;line-height:36px;margin-top:27px;margin-bottom:35px;">Order #<?php echo $order->id; ?></h3>
													</td>
												</tr>

												<tr>
													<td style="padding-top:0;padding-bottom:0;padding-right:40px;padding-left:40px;font-family:sans-serif;font-size:20px;line-height:27px;border-collapse:collapse">
														<a href="#" style="color:#3686be" target="_blank"></a>
													</td>
												</tr>

												<tr>
													<td style="padding-top:20px;padding-bottom:20px;padding-right:40px;padding-left:40px;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#333;border-collapse:collapse">
														<p>
															Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. 
														</p>
														<p>
															<b/>Total: $<?php echo $order->total; ?><b/>
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>

								<tr>
									<td style="text-align:center;padding-top:35px;padding-bottom:0px;padding-right:0px;padding-left:0px;font-family:sans-serif;font-size:12px;line-height:20px;color:#616161;border-collapse:collapse">
										© Netgeron Company
										<br>
										<a style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:12px;line-height:20px;color:#616161;border-collapse:collapse;text-decoration:underline;" href="<?php echo Yii::app()->getBaseUrl(true);?>">www.netgeron.com</a>
										<p></p>
									</td>
								</tr>
								<tr>
									<td style="text-align:center;padding-top:0px;padding-bottom:26px;padding-right:0px;padding-left:0px;font-family:sans-serif;font-size:12px;line-height:18px;color:#888888;border-collapse:collapse">
										<a href="#" style="color:#3686be;text-decoration:none;" target="_blank">
											<img src="<?php echo Yii::app()->getBaseUrl(true);?>/img/email/fb.png" height="59" width="59" class="CToWUd"></a>
										&nbsp;
										<a href="#" style="color:#3686be;text-decoration:none;" target="_blank">
											<img src="<?php echo Yii::app()->getBaseUrl(true);?>/img/email/gp.png" height="59" width="59" class="CToWUd"></a>
										&nbsp;
										<a href="#" style="color:#3686be;text-decoration:none;" target="_blank">
											<img src="<?php echo Yii::app()->getBaseUrl(true);?>/img/email/tw.png" height="59" width="59" class="CToWUd"></a>
										&nbsp;
										<a href="#" style="color:#3686be;text-decoration:none;" target="_blank">
											<img src="<?php echo Yii::app()->getBaseUrl(true);?>/img/email/rss.png" height="59" width="59" class="CToWUd"></a>
									</td>
								</tr>

							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>