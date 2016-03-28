<?php
/**
 * @var $this BuyPublicationController
 * @var $form CActiveForm
 * @var $user_billing UserBilling
 */
?>
<section class="content">
    <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'choose-pyment-form',
                            )); ?>
				<div class="container">
					<div class="steps">
						<ul>
							<li>
								<div class="step">
									<div class="num">1</div>
									<div class="title">Choose Resources 
									<br>for Publications</div>
								</div>
							</li>
							<li>
								<div class="step">
									<div class="num">2</div>
									<div class="title lh-center">Submit Details</div>
								</div>
							</li>
							<li>
								<div class="step active">
									<div class="num">3</div>
									<div class="title">Choose Payment 
									<br>Method and Pay</div>
								</div>
							</li>
							<li>
								<div class="step">
									<div class="num">4</div>
									<div class="title">Check Work Progress 
									<br>Through Live Report</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="main clearfix">

						<!-- OUTPUT BLOCK -->
						<div class="output">
							<hr>
							<div class="caption-block">
								<h1>Choose payment method:</h1>
							</div>
							<div class="payment-block">
								<div class="item">
									<table>
										<tr>
											<td class="logo-cell">
												<div class="logo <?php echo ($user_billing->payment == 'PayPal' ? 'active' : '')?>">
													<div class="pp"></div>
												</div>
											</td>
											<td class="radio-cell">
												<div class="radio-check">
                                                    <input type="radio" name="UserBilling[payment]" value="PayPal" <?php echo ($user_billing->payment == 'PayPal' ? 'checked' : '')?>>
												</div>
											</td>
										</tr>
                                        <!--
										<tr>
											<td class="logo-cell">
												<div class="logo <?php echo ($user_billing->payment == 'TwocheckoutPayment' ? 'active' : '')?>">
													<div class="card"></div>
												</div>
											</td>
											<td class="radio-cell">
												<div class="radio-check">
													<input type="radio" name="UserBilling[payment]" value="TwocheckoutPayment" <?php echo ($user_billing->payment == 'TwocheckoutPayment' ? 'checked' : '')?>>
												</div>
											</td>
										</tr>                                  
                                        -->
										<tr>
											<td class="logo-cell">
												<div class="logo <?php echo ($user_billing->payment == 'Webmoney' ? 'active' : '')?>">
													<div class="wm"></div>
												</div>
											</td>
											<td class="radio-cell">
												<div class="radio-check">
                                                    <input type="radio" name="UserBilling[payment]" value="Webmoney"<?php echo ($user_billing->payment == 'Webmoney' ? 'checked' : '')?>>
												</div>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="caption-block">
								<h2>Billing information:</h2>
							</div>
							<div class="billing-block">
								<div class="line clearfix">
									<div class="wrapper left">
										<label for="full-name">Full Name</label>
                                        <?php echo $form->textField($user_billing, 'full_name')?>
                                        <div class="error-message"><?php echo $form->error($user_billing, 'full_name'); ?></div>
										<span>(for individuals only)</span>
									</div>
									<div class="or left">OR</div>
									<div class="wrapper right">
										<label for="company_name">Company Name</label>
                                        <?php echo $form->textField($user_billing, 'company_name')?>
                                        <div class="error-message"><?php echo $form->error($user_billing, 'company_name'); ?></div>
										<span>(for legal entities only)</span>
									</div>
								</div>
								<div class="line">
									<div class="wrapper">
										<label>Country</label>
                                        <?php echo $form->dropDownList($user_billing, 'country', CHtml::listData(Countries::model()->findAll(), 'id', 'country_name'))?>
									</div>
								</div>
								<div class="line">
									<div class="wrapper">
										<label for="address">Address</label>
                                        <?php echo $form->textField($user_billing, 'address')?>
                                        <div class="error-message"><?php echo $form->error($user_billing, 'address'); ?></div>
									</div>
								</div>
								<div class="line">
									<div class="wrapper">
										<label for="zip-post">Zip/Postal Code</label>
                                        <?php echo $form->textField($user_billing, 'zip')?>
                                        <div class="error-message"><?php echo $form->error($user_billing, 'zip'); ?></div>
									</div>
								</div>
								<div class="line">
									<div class="wrapper">
										<label for="city">City</label>
                                        <?php echo $form->textField($user_billing, 'city')?>
                                        <div class="error-message"><?php echo $form->error($user_billing, 'city'); ?></div>
									</div>
								</div>
							</div>
							<div class="caption-block">
								<h2>Please check and approve:</h2>
							</div>
							<div class="order-info">
								<div class="h6">Order Information.</div>
								<table>
									<thead>
										<tr>
											<td>№</td>
											<td>Products Info</td>
											<td>Price</td>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<td colspan="2">
												<span class="text">Time interval - <?php echo $cart_info['items'][0]['time_interval']?> business days </span>
												<span class="total right">Total:</span>
											</td>
											<td>
											<div class="price">$<?php echo $cart_info['total']?></div>
											</td>
										</tr>
									</tfoot>
									<tbody>
                                        <?php foreach($cart_info['items'] as $i=>$item) {?>
										<tr>
											<td class="one">
												<div class="num"><?php echo $i + 1?></div>
											</td>
											<td class="two">
												<ul>
													<li>
														<strong>The post on <?php echo $item->product->title?> - <?php echo $item->product->url?></strong>
													</li>
													<li>with link: <?php echo $item->url?></li>
													<?php if (!empty($item->anchor)) {?>
                                                    <li>anchor: <?php echo $item->anchor?></li>
                                                    <?php }?>
												</ul>
											</td>
											<td class="three">
												<div class="price">$<?php echo $item->product->price?></div>
											</td>
										</tr>
                                        <?php }?>
									</tbody>
								</table>
							</div>
							<div class="terms text-center">
                                <?php echo $form->checkBox($user_billing, 'agreed')?>      
                                <span>I have read and agree to the <a href="<?php echo $this->createURL('front/terms'); ?>" target="_blank">Terms of Use</a></span>
                                <div class="error-message"><?php echo $form->error($user_billing, 'agreed'); ?></div>
							</div>
							<div class="button">
                                <a href="<?php echo $this->createUrl('BuyPublication/SubmitDetails');?>" class="butt back">Back</a>
								<a href="" class="butt accept">accept and Pay</a>
							</div>
						</div>
						<!-- OUTPUT BLOCK END -->
						
					</div>
				</div>
            <?php $this->endWidget(); ?>
			</section>
<?php
    Yii::app()->clientScript->registerScript('choose_payment_script',"
    $('.butt.accept').click(function(e){
        e.preventDefault();
        $('#choose-pyment-form').submit();
    });
    
    ",CClientScript::POS_READY);
?>