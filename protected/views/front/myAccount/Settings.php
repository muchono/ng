<?php
/* @var $this MyAccountController */

?>
<section class="content">
        <?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'settings-form',
                            )); ?>
				<div class="container">
					<div class="main clearfix">

						<!-- OUTPUT BLOCK -->
						<div class="output">
							<h1>My Netgeron
								<nav class="right">
									<a href="<?php echo $this->createUrl('myAccount/MyNetgeron')?>">My Netgeron</a>
									<a href="<?php echo $this->createUrl('BuyPublication/LiveReport')?>">Live Report</a>
									<a href="<?php echo $this->createUrl('myAccount/SignOut')?>">Sign Out</a>
								</nav>
							</h1>
							<div class="content-block clearfix">
								<div class="email-pass-block">
									<h2>Edit Email &amp; Password</h2>
									<div class="line">
										<div class="wrapper">
											<label for="email">Email</label>
											<?php echo $form->textField($user, 'email')?>
                                            <div class="error-message"><?php echo $form->error($user, 'email'); ?></div>
										</div>
									</div>
									<div class="line">
										<div class="wrapper">
											<label for="password">Password</label>
											<?php echo $form->passwordField($user, 'password')?>
                                            <div class="error-message"><?php echo $form->error($user, 'password'); ?></div>
										</div>
									</div>
									<div class="line">
										<div class="wrapper">
											<label for="password-conf">Confirm Password</label>
											<?php echo $form->passwordField($user, 'password_confirm')?>
                                            <div class="error-message"><?php echo $form->error($user, 'password_confirm'); ?></div>
										</div>
									</div>
									<div class="line">
										<div class="wrapper">
											<?php echo $form->checkbox($user, 'subscribe')?> - Subscribe to Newsletters
                                        </div>
									</div>                                    
								</div>
								<div class="billing-block">
									<h2>Edit Billing Information</h2>
									<div class="line clearfix">
										<div class="wrapper left">
											<label for="full-name">Full Name</label>
											<?php echo $form->textField($user_billing, 'full_name')?>
											<span>(for individuals only)</span>
                                            <div class="error-message"><?php echo $form->error($user_billing, 'full_name'); ?></div>
										</div>
										<div class="or left">OR</div>
										<div class="wrapper right">
											<label for="full-name">Company Name</label>
											<?php echo $form->textField($user_billing, 'company_name')?>
											<span>(for legal entities only)</span>
                                            <div class="error-message"><?php echo $form->error($user_billing, 'company_name'); ?></div>
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
									<div class="button text-center">
										<a href="" class="butt accept">Save Information</a>
									</div>
								</div>
							</div>
						</div>
						<!-- OUTPUT BLOCK END -->
						
					</div>
				</div>
            <?php $this->endWidget(); ?>
			</section>
<?php
    Yii::app()->clientScript->registerScript('settings_script',"
    $('.butt.accept').click(function(e){
        e.preventDefault();
        $('#settings-form').submit();
    });
    
    ",CClientScript::POS_READY);
?>
