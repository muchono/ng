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

        <table width="100%" style="margin:0 auto;" style="table-layout: fixed;" border="0" cellpadding="0" cellspacing="0">
            <tr><td align="center">
		<table style="border-spacing:0" width="700" align="center" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td style="font-size:0;line-height:0;border-collapse:collapse" height="20">&nbsp;</td>
				</tr>
				<tr>
					<td style="padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;text-align:left;border-collapse:collapse" valign="middle">
						<a href="#" style="display:inline-block;color:#3686be" target="_blank">
							<img src="<?php echo Yii::app()->getBaseUrl(true);?>/img/email/logo.png" alt="" height="34" width="182" border="0" class="CToWUd"></a>
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
													<td style="padding-top:0;padding-bottom:0;padding-right:40px;padding-left:40px;font-family:sans-serif;font-size:20px;line-height:27px;border-collapse:collapse">
														<a href="#" style="color:#3686be" target="_blank"></a>
													</td>
												</tr>

												<tr>
													<td style="padding-top:20px;padding-bottom:20px;padding-right:40px;padding-left:40px;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#333;border-collapse:collapse">
														<p>
															Hello <?php echo $user->name?>,<br/>
<br/>
Thank you for joining Netgeron, your email: <?php echo $user->email?><br/>
<br/>
To verify your email address and continue, please click the following link:<br/>
<a href="<?php echo $url;?>"><?php echo $url;?></a><br/>
<br/>
Don't forget to visit our blog where we share various different information and secrets of search engine promotion and not only:<br/>
<a href="http://www.netgeron.com/blog">http://www.netgeron.com/blog</a><br/>
<br/>
--<br/>
Best Regards,<br/>
Netgeron Administration<br/>
														</p>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
<?php echo $this->renderPartial('//layouts/footer_mail'); ?>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
            </td></tr>
		</table>
	</div>
</body>
</html>