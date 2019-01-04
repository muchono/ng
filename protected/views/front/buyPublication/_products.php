<?php
/* @var $this BuyPublicationController */
/* @var $products Product[] 
 * @var $pager CPagination
 */
?>
    <?php if (empty($products)){?>
    <li>
    <br/><br/>
    <center> <div class="title">Nothing was found</div></center>
    </li>
    <?php } else foreach($products as $i=>$p) {?>
								<li class="product-li">
									<div class="goods">
										<table>
											<tr>
												<td class="one">
													<a href="<?php echo $p->url?>" target="_blank">
														<div class="goods-img">
                                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo Product::IMG_DIR.$p->image?>" alt="">
														</div>
													</a>
												</td>
												<td class="two separator">
													<div class="goods-detail">
														<h2><?php echo $p->title?></h2>
														<ul>
															<li><strong>URL:</strong> <a href="<?php echo $p->url?>" target="_blank"><?php echo $p->url?></a></li>
															<li class="separator"></li>
                                                            <li>
                                                                <strong>Category:</strong>
                                                                <?php if (!empty($filter['category'])) {?>
                                                                <?php foreach($p->categories as $c)
                                                                    if (in_array($c->id, $filter['category'])){?>
                                                                <span><a href="<?php echo $this->createUrl('buyPublication/ChooseResource',array('cid'=>$c->id));?>"><?php echo $c->title?></a></span>
                                                                <?php }?>
                                                               
                                                                <?php foreach($p->categories as $c)
                                                                    if (!in_array($c->id, $filter['category'])){?>
                                                                <span><a href="<?php echo $this->createUrl('buyPublication/ChooseResource',array('cid'=>$c->id));?>"><?php echo $c->title?></a></span>
                                                                <?php }?>
                                                                
                                                                <?php }else{?>

                                                                <?php foreach($p->categories as $c){?>
                                                                <span><a href="<?php echo $this->createUrl('buyPublication/ChooseResource',array('cid'=>$c->id));?>"><?php echo $c->title?></a></span>
                                                                <?php }?>
                                                                
                                                                <?php }?>
                                                            </li>                                                            
															<li>
																<strong>Traffic:</strong> <?php echo $p->traffic?> / month 
                                                                <a href="<?php echo $p->getSimilarWebLink(); ?>" target="_blank" class="traff-icon"></a>
															</li>
															<li>
																<strong>Age of Site:</strong> <?php echo $p->old?> years
															</li>
															<li>
																<strong>Alexa Rank:</strong> <?php echo $p->alexa_rank?>
															</li>
															<li>
																<strong>Domain Authority:</strong> <?php echo $p->da_rank?>
															</li>                                                            
															<li>
																<strong>Link:</strong> <?php echo $p->linkName?>
															</li>
															<li>
																<strong>Anchor:</strong> <?php echo $p->anchorName?>
															</li>
                                                            <?php if (trim($p->about)) {?>
															<li>
																<strong>About <?php echo $p->title?>:</strong>
																<p><?php echo $p->about?></p>

															</li>
                                                            <?php }?>
														</ul>
													</div>
												</td>
                                                <?php if($p->status != Product::UNAVAILABLE_STATUS){?>
												<td class="three middle separator">
													<div class="price-block">
														<span class="price">$<?php echo $p->price?></span>
														<span>per <br>Post</span>
													</div>
												</td>
												<td class="four middle text-center">
                                                    <div class="button-block<?php echo $p->isInCart ? ' hide' : '';?>">
                                                        <a href="<?php echo $p->id;?>" class="butt order">order now</a>
														<a href="<?php echo $p->id;?>" class="butt add">add to cart</a>
													</div>
                                                    <a href="<?php echo $this->createUrl('buyPublication/SubmitDetails'); ?>" class="added2cart<?php echo $p->isInCart ? '' : ' hide';?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/added-img.png" alt=""></a>
												</td>
                                                <?php }else{?>
												<td class="text-center middle">
													<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/unavailable-img.png" alt="">
													<div class="check-later">Please check later</div>
												</td>
                                                <?php }?>
											</tr>
										</table>
									</div>
                                    <?php if ($i == 0 && isset($set_pages_num) && $set_pages_num) {?>
                                    <script type="text/javascript">
                                    $('#pager_pages_num').val(<?php echo $pager->getPageCount();?>);
                                    </script>
                                    <?php }?>									
								</li>    
                                <?php }?>