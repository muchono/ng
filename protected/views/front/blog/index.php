<?php
/* @var $this BlogController */
?>
				<div class="container">
					<div class="main clearfix">
						<div class="output">
							<h1><strong>Netgeron</strong> SEO blog</h1>
							<ul class="post-list">
                                <?php foreach($posts as $p){?>
								<li>
                                    <h2><a href="<?php echo $this->createUrl('/'.$p->url_anckor)?>"><?php echo $p->title?></a></h2>
									<div class="post-content">
										<img class="left" src="<?php echo Yii::app()->getBaseUrl(true) . '/' . $p->getImageName('thumb')?>" alt="">
										<p><?php echo $p->brief?></p>
									</div>
								</li>
                                <?php }?>
							</ul>
                            <?php $this->widget('ext.PostLinkPager.PostLinkPager', array(
                                'pages' => $pager,
                                'cssFile' => '',
                                'htmlOptions' => array('class' => 'pagination'),
                            ))?>
						</div>
                        <?php echo $this->renderPartial('_right'); ?>
					</div>
				</div>
