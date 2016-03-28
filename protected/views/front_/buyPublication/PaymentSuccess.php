<?php
/**
 * @var $order Order 
 */
?>
<section class="content">
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
							<div class="succesful-block text-center">
								<h1>
									<img src="img/content/succs-v.png" alt="">
									<span>Thank you for your payment!</span>
								</h1>
							</div>
							<div class="order-info">
								<div class="h6">Your order was processed succesfully.</div>
								<div class="h6">Your order ID: <?php echo $order->id?></div>
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
												<span class="text">Time interval - <?php echo $order->time_interval?> business days </span>
												<span class="total right">Total:</span>
											</td>
											<td>
											<div class="price">$<?php echo $order->total?></div>
											</td>
										</tr>
									</tfoot>
									<tbody>
                                        <?php foreach($order->orderedProductsDetails as $i => $op){?>
										<tr>
											<td class="one">
												<div class="num"><?php echo $i + 1?></div>
											</td>
											<td class="two">
												<ul>
													<li>
														<strong>The post on <?php echo $op->product->title?> - <?php echo $op->product->url?></strong>
													</li>
													<li>with link: <?php echo $op->url?></li>
													<?php if (!empty($op->anchor)) {?><li>anchor: <?php echo $op->anchor?></li><?php }?>
												</ul>
											</td>
											<td class="three">
												<div class="price">$<?php echo $op->price?></div>
											</td>
										</tr>
                                        <?php }?>
									</tbody>
								</table>
							</div>
							<div class="button text-center">
                                <a href="<?php echo $this->createUrl('BuyPublication/LiveReport')?>" class="butt accept">Go  to  Live Report</a>
							</div>
						</div>
						<!-- OUTPUT BLOCK END -->
						
					</div>
				</div>
			</section>