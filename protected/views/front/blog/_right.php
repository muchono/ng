<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/blog.js',CClientScript::POS_END);?>
                        <div class="right-side">
                            <div class="search-input">
							<div class="input-line right-butt">
                                <form id="search_form" action="<?php echo $this->createUrl('')?>" method="get">
                                <input type="hidden" name="r" value="blog">
                                <input type="text" name="search" value="<?php echo !empty($_GET['search']) ? CHtml::encode($_GET['search']) : ''?>" placeholder="Search on the blog">
                                </form>
								<span id="search_but"><img src="<?php echo Yii::app()->getBaseUrl(true)?>/img/content/search-ic.png" alt=""></span>
							</div>
								<div class="error-message"></div>
							</div>
                            <?php if ($this->showSubscribe()) {?>
							<div class="subscribe-block">
								<h3>Subscribe to SEO blog</h3>
								<input type="text" id="blog_subscribe_input">
                                <div id="blog_subscribe_errors" class="error-message"></div>
								<a href="" id="blog_subscribe" class="butt">Subscribe</a>
							</div>
                            <?php }?>
							<h3 class="text-center">Follow Netgeron Blog</h3>
							<div class="text-center">
								<ul class="social">
									<li class="fb"><a href="https://www.facebook.com/netgeron" target="_blank"></a></li>
									<li class="gp"><a href="https://www.google.com/+Netgeron" target="_blank"></a></li>
									<li class="tw"><a href="https://twitter.com/netgeron" target="_blank"></a></li>
									<li class="rss"><a href="<?php echo $this->createUrl('blog/rss');?>" target="_blank"></a></li>
								</ul>
							</div>
							<div class="banner-block">
								<?php echo PagesContent::model()->getContent('BlogBannerTop');?>
							</div>
							<div class="h4">Explore Posts by Category</div>
							<select id="categories_select" data-placeholder="Select a Category">
								<option value=""></option>
                                <?php foreach (PostCategory::model()->findAll() as $pc){?>
								<option value="<?php echo $pc->id?>" <?php echo !empty($_GET['cid']) && $_GET['cid'] == $pc->id ? 'selected' : ''?>><?php echo $pc->title?></option>
                                <?php }?>
							</select>
							<div class="h4">Popular Posts</div>
							<ol>
                                <?php foreach(Post::model()->findPopular() as $pp){?>
								<li><a href="<?php echo $this->createUrl('/'.$pp->url_anckor);?>"><?php echo $pp->title?></a></li>
                                <?php }?>
							</ol>
							<div class="banner-block">
                                <?php echo PagesContent::model()->getContent('BlogBannerBottom');?>
							</div>
						</div>