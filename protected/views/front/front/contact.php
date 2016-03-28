<section class="content">
    <div class="container">
					<div class="main clearfix">

						<!-- OUTPUT BLOCK -->
						<div class="output">
							<h1>Contact us</h1>
							<div class="content-block clearfix">
								<div class="left-side">
                                    <?php if (!empty($_GET['sent'])){?>
                                    Thank you. The email has been sent.
                                    <?php } else {?>
                                    <?php $form=$this->beginWidget('CActiveForm', array(
                                        'id'=>'contact-form',
                                        'enableAjaxValidation'=>true,
                                    )); ?>
						
									<h2><?php echo $form->labelEx($model,'name'); ?></h2>
                                    <?php echo $form->textField($model,'name'); ?>
                                    <div class="error-message"><?php echo $form->error($model,'name'); ?></div>
                                    
									<h2><?php echo $form->labelEx($model,'email'); ?></h2>
                                    <?php echo $form->textField($model,'email'); ?>                                
                                    <div class="error-message"><?php echo $form->error($model,'email'); ?></div>
									<h2><?php echo $form->labelEx($model,'subject'); ?></h2>
                                    <?php echo $form->dropDownList($model, 'subject', $model->subjectList, array('empty'=>'Select Subject')); ?>
                                    <div class="error-message"><?php echo $form->error($model,'subject'); ?></div>
									<h2><?php echo $form->labelEx($model,'message'); ?></h2>
                                    <div class="error-message"><?php echo $form->error($model,'message'); ?></div>
                                    <?php echo $form->textArea($model, 'message'); ?>
                                    <div class="g-recaptcha" data-sitekey="6LfMmQMTAAAAAKK6Uvp4m4UEfr2NCikXA6GIKTd6"></div>
                                    <div class="error-message"><?php echo $form->error($model,'verifyCode'); ?></div>
									<div class="button text-center">
										<a href="" id="contact" class="butt accept">Submit message</a>
									</div>
                                    <?php $this->endWidget(); ?>
                                    <?php }?>
								</div>
								<div class="right-side">
									<div class="address-block">
										<!--<address>
											<strong>NETGERON d.o.o.</strong><br>
											Tehnološki park 024<br>
											1000 Ljubljana<br>
											Slovenia
										</address>-->
										<address>
											<table>
												<tbody><tr>
													<td><span><strong>Email:</strong></span></td>
													<td><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/emails.png" alt=""></td>
												</tr>
											</tbody></table>
										</address>
									</div>
								</div>
							</div>
						</div>
						<!-- OUTPUT BLOCK END -->
						
					</div>
				</div>
    </section>
<?php
    Yii::app()->clientScript->registerScriptFile('https://www.google.com/recaptcha/api.js');
    
    Yii::app()->clientScript->registerScript('contact_script',"
    $('#contact').click(function(e){
        e.preventDefault();
        $('#contact-form').submit();
    });
    ",CClientScript::POS_READY);
?>
