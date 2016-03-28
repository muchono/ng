<?php
/**
 * @var $this BlogController
 * @var $post Post
 */
?>
<div class="container">
					<div class="main clearfix">
						<div class="output">
							<h2><?php echo $post->title;?></h2>
							<div class="post-bar">
								<span class="date"><?php echo Yii::app()->dateFormatter->formatDateTime($post->date, 'long', null)?></span>
								<span class="autor">
                                    <?php if (!$post->show_author) {?>
                                    <a href="<?php echo $this->createUrl('front/contact');?>" target="_blank">Netgeron team</a>
                                    <?php } else {?>
                                    <a href="#author"><?php echo $post->author_name?></a>
                                    <?php }?>
                                </span>
								<span class="category">
                                    <?php foreach($post->categories as $k=>$pc) {?>
                                    <a href="<?php echo $pc->link;?>"><?php echo $pc->title?></a><?php if ($k < count($post->categories)-1) {?>,<?php }?>
                                    <?php }?>
                                </span>
							</div>
							<div class="post-content">
								<img class="left" src="<?php echo $post->getImageName('post');?>" alt="<?php echo $post->title;?>">
                                <?php echo $post->content;?>
							</div>
                            <?php if ($post->show_author) {?>
                            <a name="author"></a>
							<div class="autor-block">
                                <?php if ($post->author_image) {?>
								<img class="left" src="<?php echo Post::IMG_AUTHOR_DIR.$post->author_image;?>" alt=""  width="80" height="80">
                                <?php }?>
								<p><strong>About <?php echo $post->author_name?></strong> - <?php echo $post->author_content?> </p>
							</div>
                            <?php }?>
							<div class="enjoy text-center">
								<h3>Enjoy this Post?</h3>
								<img src="img/content/enjoy-img.png" alt="">
							</div>
							<div class="comment-block">
								
							</div>
						</div>
                        <?php echo $this->renderPartial('_right'); ?>
					</div>
				</div>
