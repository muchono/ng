<?php
/* @var $this BuyPublicationController 
 * @var $pager CPagination
 * @var $filter array
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/search.js',CClientScript::POS_END);

?>
				<div class="container">
                    <?php $this->renderPartial('_steps', array('products'=>$products)); ?>
					<?php if (!Yii::app()->user->isCHidden('buy-publications-choose-resources-advice')) {?>
                    <div class="advice-block" id="buy-publications-choose-resources-advice">
						<div class="title">
							<span>
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/advice-tt-icon.png" alt="">
								Advice:
							</span>
						</div>
						<p class="text"><?php echo PagesContent::model()->getContent('buy-publications-choose-resources-advice');?></p>
						<div class="close"></div>
					</div>
                    <?php }?>
					<div class="main clearfix">
						<hr>
						<div class="left-side">
                        <?php $form=$this->beginWidget('CActiveForm', array(
                            'id'=>'search-form',
                        )); ?>                           
							<h3>Traffic</h3>
							<div id="traffic_value" class="slider-value"></div>
							<div id="traffic" class="slider"></div>
                            <?php echo CHtml::hiddenField('traffic', 0, array('id'=>'traffic_input'))?>
							<hr>
							<h3>Google PR</h3>
							<div id="google_pr_value" class="slider-value"></div>
							<div id="google_pr" class="slider"></div>
                            <?php echo CHtml::hiddenField('google_pr', 0, array('id'=>'google_pr_input'))?>
							<hr>
							<h3>Price</h3>
							<div id="price_value" class="slider-value"></div>
							<div id="price" class="slider"></div>
                            <?php echo CHtml::hiddenField('price', 0, array('id'=>'price_input'))?>
							<hr>
							<h3>Categories</h3>
							<ul class="categories_filter">
								<li>
                                    <?php echo CHtml::checkBox('category[]', false, array('value'=>'all'))?>
									<label for="all">All</label></li>
                                <?php foreach (ProductCategory::model()->sort_asc()->findAll() as $c) {?>
								<li>
                                    <?php echo CHtml::checkBox('category[]', !empty($filter['category']) && in_array($c->id, $filter['category']), array('value'=>$c->id))?>
									<label for="category_<?php echo $c->id?>"><?php echo $c->title?></label></li>
                                <?php }?>
							</ul>
                          
							<hr>
							<h3>Links 
								<div class="what-is">
									<div class="what-is-popup">
										<div class="h4">Links</div>
										<p><?php echo PagesContent::model()->getContent('buy-publications-choose-resources-links-help');?></p>
										<div class="close"></div>
									</div>
								</div>
							</h3>
							<ul class="links_filter">
                                <?php foreach (Product::$links as $kl=>$l) {?>
								<li>
									<?php echo CHtml::checkBox('link[]', false, array('value'=>$kl))?>
									<label for="nofollow"><?php echo $l?></label></li>
                                <?php }?>
							</ul>
							<hr>
                            <h3>Anchor/Keyword <div class="what-is">
                                    <div class="what-is-popup">
										<div class="h4">Anchor/Keyword</div>
										<p><?php echo PagesContent::model()->getContent('buy-publications-choose-resources-anchor-help');?></p>
										<div class="close"></div>                                
                                   </div>
                                   </div>
                            </h3>
							<ul class="anchors_filter">
								<li>
									<?php echo CHtml::checkBox('anchor[]', false, array('value'=>2))?>
									<label for="business">Business</label></li>
								<li>
									<?php echo CHtml::checkBox('anchor[]', false, array('value'=>3, 'id'=>'chb'))?>
									<label for="brand_name_url">Branded or naked Link URL</label></li>
							</ul>
							<hr>
							<h3>Select .edu or .gov</h3>
							<ul class="domain_zone_filter">
                            <?php foreach (Product::$domain_zone_filter as $dz) {?>                                
								<li>
									<?php echo CHtml::checkBox('domain_zone[]', false, array('value'=>$dz))?>
									<label for="<?php echo $dz?>">.<?php echo $dz?></label></li>
                            <?php }?>
							</ul>
							<hr>                            
                            <?php echo CHtml::hiddenField('pager_pages_num', $pager->getPageCount(), array('id'=>'pager_pages_num'))?>
                            <?php echo CHtml::hiddenField('pager_current_page', $pager->getCurrentPage()+1, array('id'=>'pager_current_page'))?>
                            <?php $this->endWidget(); ?>
						</div>
						<div class="output">
							<div class="caption-block">
								<h1 class="left"><?php echo $selected_category?></h1>
								<div class="sort-butt right">
									<h3>Sort by:</h3>
                                    <?php if ($filter['sort_by'] == 'sort_relevance') {?>
									<span class="butt active" id="sort_relevance">Relevance</span>
									<span class="butt no-active" id="sort_traffic">Traffic</span>
                                    <?php }else {?>
									<span class="butt no-active" id="sort_relevance" style="display: none">Relevance</span>
									<span class="butt active" id="sort_traffic">Traffic<i class="down"></i></span>                                    
                                    <?php }?>
									<span class="butt no-active" id="sort_da">DA</span>                                    
									<span class="butt no-active" id="sort_pr">PR</span>
									<span class="butt no-active" id="sort_price">Price</span>
								</div>
							</div>
                            <ul class="goods-list">
                            <?php $this->renderPartial('_products', array('products'=>$products, 'pager'=>$pager, 'filter'=>$filter)); ?>
                            </ul>
                            <div class="loader" id="loader_bottom" style="display: none">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/loader.gif" alt=""> <!-- Must be GIF animate -->
								<h5>Loading...</h5>
							</div>
						</div>
					</div>
                </div>