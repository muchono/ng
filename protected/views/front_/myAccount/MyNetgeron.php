<?php
/* @var $this MyAccountController */
?>
<section class="content">
				<div class="container">
					<div class="main clearfix">

						<!-- OUTPUT BLOCK -->
						<div class="output">
							<h1>My Netgeron
								<nav class="right">
									<a href="<?php echo $this->createUrl('myAccount/Settings')?>">Settings</a>
									<a href="<?php echo $this->createUrl('BuyPublication/LiveReport')?>">Live Report</a>
									<a href="<?php echo $this->createUrl('myAccount/SignOut')?>">Sign Out</a>
								</nav>
							</h1>
							<div class="content-block clearfix">
								<div class="acc-wrap clearfix">
									<div class="static left">
										<h2>Account Statistics</h2>
										<div class="wrap">
											<div>Number of Orders: <span><?php echo count($orders)?></span></div>
											<div>Number of Posts: <span><?php echo $opcount?></span></div>
										</div>
									</div>
									<div class="info right">
										<h2>Account Information</h2>
										<div class="wrap">
                                            <?php if (!empty(Yii::app()->user->profile->billing)) {?>
											<?php if (!empty(Yii::app()->user->profile->billing->company_name)){?>
                                            <p><strong><?php echo Yii::app()->user->profile->billing->company_name?></strong></p>
                                            <?php }?>
											<?php if (!empty(Yii::app()->user->profile->billing->full_name)){?>                                            
											<p><strong><?php echo Yii::app()->user->profile->billing->full_name?></strong></p>
                                            <?php }?>
											<p><?php echo Yii::app()->user->profile->billing->countryInfo->country_name?></p>
											<p><?php echo Yii::app()->user->profile->billing->address?></p>
                                            <?php } else {?>
                                            No data
                                            <?php }?>
                                            
                                            <a class="butt" href="<?php echo $this->createUrl('myAccount/Settings')?>">edit info</a> 
                                            
										</div>
									</div>
								</div>
                                <?php if (!empty($orders)){?>
								<div class="my-order">
									<h2>My Orders</h2>
									<table>
										<thead>
											<tr>
												<th>Order ID</th>
												<th>Order Date</th>
												<th>Posts Number</th>
												<th>Total</th>
												<th>Status</th>
												<th>Invoices</th>
											</tr>
										</thead>
										<tbody>
                                            <?php foreach($orders as $o){?>
											<tr>
                                                <td><?php echo $o->id;?></td>
                                                <td><?php echo $o->time;?></td>
                                                <td><?php echo $o->products_count;?></td>
                                                <td>$<?php echo $o->total;?></td>
                                                <td><span class="<?php echo Order::$statuses_styles[$o->status];?>"><?php echo Order::$statuses[$o->status];?></span></td>
                                                <td><a href="<?php echo $this->createUrl('buyPublication/Invoice', array('order'=>$o->id)); ?>" target="_blank">View Invoice</a></td>
											</tr>
                                            <?php }?>
										</tbody>
									</table>
								</div>
                                <?php }?>
							</div>
						</div>
						<!-- OUTPUT BLOCK END -->
						
					</div>
				</div>
			</section>

