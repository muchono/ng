<?php
/* @var $this BuyPublicationController */
/* @var $products Product[] 
 * @var $pager CPagination
 */
?>
    <?php foreach($products as $p) {?>
								<li>
									<div class="goods">
										<table>
											<tr>
												<td class="one">
													<a href="">
														<div class="goods-img">
                                                            <img src="<?php echo Product::IMG_DIR.$p->image?>" alt="">
														</div>
													</a>
												</td>
												<td class="two separator">
													<div class="goods-detail">
														<h2><?php echo $p->title?></h2>
														<ul>
															<li><strong>URL:</strong> <a href="<?php echo $p->url?>"><?php echo $p->url?></a></li>
															<li class="separator"></li>
															<li>
																<strong>Category:</strong>
                                                                <?php foreach($p->categories as $c){?>
																<span><a href="<?php echo $this->createUrl('buyPublication/ChooseResource',array('cid'=>$c->id));?>"><?php echo $c->title?></a></span>
                                                                <?php }?>
															</li>
															<li>
																<strong>Traffic:</strong> <?php echo $p->traffic?> / month 
																<a href="" class="traff-icon"></a>
															</li>
															<li>
																<strong>Age of Site:</strong> <?php echo $p->old?> years
															</li>
															<li>
																<strong>Google PR:</strong> <?php echo $p->google_pr?>
															</li>
															<li>
																<strong>Alexa Rank:</strong> <?php echo $p->alexa_rank?>
															</li>
															<li>
																<strong>Link:</strong> <?php echo $p->linkName?>
															</li>
															<li>
																<strong>Anchor:</strong> <?php echo $p->anchorName?>
															</li>
															<li>
																<strong>About <?php echo $p->title?>:</strong>
																<p><?php echo $p->title?></p>

															</li>
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
													<a href="" class="added2cart<?php echo $p->isInCart ? '' : ' hide';?>"><img src="img/content/added-img.png" alt=""></a>
												</td>
                                                <?php }else{?>
												<td class="text-center middle">
													<img src="img/content/unavailable-img.png" alt="">
													<div class="check-later">Please check later</div>
												</td>
                                                <?php }?>
											</tr>
										</table>
									</div>
								</li>    
                                <?php }?>
<script type="text/javascript">
/*<![CDATA[*/
<?php if(isset($set_pages_num) && $set_pages_num){?>
    $('#pager_pages_num').val(<?php echo $pager->getPageCount()?>);
<?php }?>
/*]]>*/
</script>