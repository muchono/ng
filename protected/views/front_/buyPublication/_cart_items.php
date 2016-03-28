<?php
/**
 * @var @form CActiveForm 
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
                                'id'=>'cart-form',
                            )); ?>
                                <?php echo CHtml::hiddenField('time_interval', !empty($cart_info['items'][0]) ? $cart_info['items'][0]->time_interval : 1, array('id'=>'time_interval_field'))?>
                                <?php echo CHtml::hiddenField('action', '', array('id'=>'action_field'))?>
                                <?php foreach ($cart_info['items'] as $citem) {?>
								<li class="cart_item" id="item_<?php echo $citem->id?>">
                                    <?php echo $form->hiddenField($citem, '['.$citem->id.']id', array('class'=>'item_id'))?>
									<div class="num">
										<div class="drop-list-wrap">
											<div class="drop-list">
                                                <?php echo $form->hiddenField($citem, '['.$citem->id.']index', array('class'=>'item_position'))?>
												<span class="current"><?php echo $citem->index + 1?></span>
                                                <?php if ($cart_info['count'] > 1) {?>
												<div class="wrap hidden">
													<ul>
                                                        <?php for ($i=0;  $i<$cart_info['count']; $i++) {?>
                                                        <li <?php echo ($i == $citem->index) ? 'class="active"' : '' ?>><?php echo $i + 1;?></li>
                                                        <?php }?>
													</ul>
													<span class="arrow"></span>
												</div>
                                                <?php }?>
											</div>
										</div>
									</div>
									<div class="goods">
										<table>
											<tr>
												<td class="one">
													<a href="">
														<div class="goods-img">
															<img src="<?php echo Product::IMG_DIR . $citem->product->image?>" alt="">
														</div>
													</a>
												</td>
												<td class="two">
													<h2><span class="black-cl">The Post in</span> <?php echo $citem->product->title?></h2>
													<table>
														<tr>
															<td class="one">
																
															</td>
															<td class="two">
																<p class="text">Your link in this post:</p>
															</td>
														</tr>
														<tr>
															<td class="one">
																<strong>URL:</strong>
															</td>
															<td class="two">
                                                                <?php echo $form->textField($citem, '['.$citem->id.']url')?>
                                                                <?php echo $form->error($citem,'url'); ?>
															</td>
														</tr>
														<tr>
															<td class="one">
																<strong>Anchor:</strong>
															</td>
															<td class="two">
																<div class="anchor">
                                                                <?php if ($citem->product->isAnchorAvailable()) {?>
                                                                    <?php echo $form->textField($citem, '['.$citem->id.']anchor')?>
                                                                    <span class="what-is">
                                                                        <div class="what-is-popup">
                                                                            <div class="h4">Anchor</div>
                                                                            <p><?php echo PagesContent::model()->getContent('buy-publications-submit-details-anchor-help');?></p>
                                                                            <div class="close"></div>
                                                                        </div>
                                                                    </span>                                                                    

                                                                    <?php echo $form->error($citem,'anchor'); ?>                                                                
                                                                    
                                                                <?php } else {?>
                                                                    
                                                                    only brand/company name or URL
                                                                    <span class="what-is">
                                                                        <div class="what-is-popup">
                                                                            <div class="h4">Anchor</div>
                                                                            <p><?php echo PagesContent::model()->getContent('buy-publications-submit-details-anchor-help');?></p>
                                                                            <div class="close"></div>
                                                                        </div>
                                                                    </span> 
                                                                    
                                                                <?php }?>
																</div>                                                                
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<table class="comment">
														<tr>
															<td class="comment-caption">
																<strong>Comment (optional):</strong>
															</td>
															<td class="comment-area">
                                                                <?php echo $form->textArea($citem, '['.$citem->id.']comment');?>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<div class="close"></div>
									</div>
								</li>
                                <?php }?>
                            <?php $this->endWidget(); ?>
<?php
    Yii::app()->clientScript->registerScript('cart_ready_script',"
    $('#time_interval_field').val(".$time_interval.");
    selectDropList('#time-interval', ".$time_interval.");
    ",CClientScript::POS_READY);
?>