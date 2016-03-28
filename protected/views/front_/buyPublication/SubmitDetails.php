<?php
/* @var $this BuyPublicationController 
 * @var $cart_info array
 */
?>
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
								<div class="step active">
									<div class="num">2</div>
									<div class="title lh-center">Submit Details</div>
								</div>
							</li>
							<li>
								<div class="step">
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
                    <?php if ($cart_info['count'] == 1) {?>
                    <?php if (!Yii::app()->user->isCHidden('buy-publications-submit-details-one-advice')) {?>
					<div class="advice-block" id="buy-publications-submit-details-one-advice">
						<div class="title">
							<span>
								<img src="img/content/advice-tt-icon.png" alt="">
								Advice:
							</span>
						</div>
						<p class="text"><?php echo PagesContent::model()->getContent('buy-publications-submit-details-one-advice');?></p>
						<div class="close"></div>
					</div>
                    <?php }?>
                    <?php }else{?>
                    <?php if (!Yii::app()->user->isCHidden('buy-publications-submit-details-advice')) {?>
					<div class="advice-block" id="buy-publications-submit-details-advice">
						<div class="title">
							<span>
								<img src="img/content/advice-tt-icon.png" alt="">
								Advice:
							</span>
						</div>
						<p class="text"><?php echo PagesContent::model()->getContent('buy-publications-submit-details-advice');?></p>
						<div class="close"></div>
					</div>
                    <?php }?>
                   <?php }?>
					<div class="main clearfix">

						<!-- OUTPUT BLOCK -->
						<div class="output">
							<hr>
							<div class="caption-block">
								<h1 class="left">Submit your details:</h1>
								<div class="sort-butt right">
									<h3>Time Interval:</h3>
									<div id="time-interval" class="drop-list-wrap">
										<div class="drop-list">
											<span class="current">1</span>
                                            <?php if ($cart_info['count'] > 1) {?>
											<ul>
												<li class="active">1</li>
												<li>2</li>
												<li>3</li>
												<li>4</li>
												<li>5</li>
												<li>6</li>
												<li>7</li>
											</ul>
											<span class="arrow"></span>
                                            <?php }?>
										</div>
									</div>
									
									<span>business days 								
                                <div class="what-is">
									<div class="what-is-popup">
										<div class="h4">Time Interval</div>
										<p><?php echo PagesContent::model()->getContent('buy-publications-submit-details-time-interval-help');?></p>
										<div class="close"></div>
									</div>
								</div></span>
								</div>
							</div>
                           
							<ul class="goods-list">                            
                            <?php $this->renderPartial('_cart_items', array('cart_info'=>$cart_info, 'time_interval'=>$time_interval)); ?>
    						</ul>
							<div class="button">
								<a href="<?php echo $this->createUrl('BuyPublication/ChooseResource');?>" class="butt back">Back</a>
								<a href="" class="butt accept" id="submit_details_button">accept and Pay</a>
							</div>

						</div>
						<!-- OUTPUT BLOCK END -->
						
					</div>
				</div>