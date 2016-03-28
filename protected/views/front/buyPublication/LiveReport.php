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
								<div class="step">
									<div class="num">3</div>
									<div class="title">Choose Payment 
									<br>Method and Pay</div>
								</div>
							</li>
							<li>
								<div class="step active">
									<div class="num">4</div>
									<div class="title">Check Work Progress 
									<br>Through Live Report</div>
								</div>
							</li>
						</ul>
					</div>
                    <?php if (!Yii::app()->user->isCHidden('live-report-advice')) {?>
					<div class="advice-block" id="live-report-advice">
						<div class="title">
							<span>
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/advice-tt-icon.png" alt="">
								Advice:
							</span>
						</div>
						<p class="text"><?php echo PagesContent::model()->getContent('live-report-advice');?></p>
						<div class="close"></div>
					</div>
                    <?php }?>
					<div id="tabs" class="main clearfix">
						<hr>
						<div class="left-side">
							<h3>Your Orders</h3>
							<ul>
                                <?php foreach($report_data as $r){?>
								<li>
                                    <a href="#tabs-<?php echo $r['order']->id?>"><strong>ID: <?php echo $r['order']->id?></strong> - for <?php echo $r['order']->time?></a>
								</li>
                                <?php }?>
							</ul>
						</div>
						<div class="output">
							<div class="caption-block">
								<h1 class="left">Live Report</h1>
							</div>
							<div class="tabs-wrap">
                                <?php foreach($report_data as $r){?>
								<div id="tabs-<?php echo $r['order']->id?>">
									<div class="info clearfix">
										<div class="left-part">
											<ul>
												<li>Number of publications: <?php echo count($r['ordered_products']) ?></li>
                                                <?php foreach($r['statuses'] as $s=>$v) if ($v){?>
												<li class="<?php echo Order::$statuses_styles[$s] ?>"><?php echo Order::$statuses[$s] ?>: <?php echo $v ?></li>
                                                <?php }?>
											</ul>
										</div>
										<div class="right-part">
											<ul>
												<li>Time interval - <?php echo $r['order']->time_interval?> business days </li>
											</ul>
										</div>
									</div>
									<table>
										<thead>
											<tr>
												<td>№</td>
												<td>Source for publication</td>
												<td>Status</td>
											</tr>
										</thead>
										<tbody>
                                            <?php foreach($r['ordered_products'] as $i=>$op) { if (empty($op->product)) continue;?>
											<tr>
												<td class="num">
													<div><?php echo $i+1?></div>
												</td>
												<td class="source">
													<div>Post in <strong><?php echo $op->product->title;?></strong> for site: <?php echo $op->url?> </div>
												</td>
												<td class="status">
													<div class="<?php echo Order::$statuses_styles[$op->status]?>"><?php echo Order::$statuses[$op->status]?> 
                                                        <?php if ($op->status == Order::FINISH_STATUS){?>
                                                        - <a href="<?php echo $op->url_res?>" target="_blank">check post</a></div>
                                                        <?php }?>
												</td>
											</tr>
                                            <?php }?>
										</tbody>
									</table>
								</div>
                                <?php }?>
							</div>
						</div>
					</div>
				</div>
			</section>