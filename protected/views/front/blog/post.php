<?php
/**
 * @var $this BlogController
 * @var $post Post
 */

?>
<div class="container">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1562953530658610&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

					<div class="main clearfix">
						<div class="output">
							<h1><?php echo $post->title;?></h1>
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
								<img class="left" src="<?php echo Yii::app()->getBaseUrl(true) . '/' .$post->getImageName('post');?>" alt="<?php echo $post->title;?>">
                                <?php echo $post->content;?>
							</div>
                            <?php if ($post->show_author) {?>
                            <a name="author"></a>
							<div class="autor-block">
                                <div class="autor-block-content">
                                <?php if ($post->author_image) {?>
								<img class="left" src="<?php echo Yii::app()->getBaseUrl(true) . '/' .Post::IMG_AUTHOR_DIR.$post->author_image;?>" alt=""  width="80" height="80">
                                <?php }?>
								<p><strong>About <?php echo $post->author_name?></strong> - <?php echo $post->author_content?> </p>
                                </div>
							</div>
                            <?php }?>
							<div class="enjoy text-center">
								<h3>Enjoy this Post?</h3>
                                <div class="social-list">
                                    <div class="post-social-elem fb-like left" data-href="<?php echo Yii::app()->request->requestUri?>" data-layout="box_count" data-action="like" data-show-faces="true" data-share="false"></div>

                                    <div class="post-social-elem twitersocial left">
                                    <a href="https://twitter.com/share" class="twitter-share-button"  data-count="vertical">Tweet</a>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                    </div>

                                    <div class="post-social-elem gsocial left"><script src="https://apis.google.com/js/platform.js" async defer></script>
                                    <g:plusone size="tall"></g:plusone>
                                    </div>

                                    <div class="post-social-elem pinsocial left"><a href="//ru.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-config="above" data-pin-color="white" data-pin-height="28"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_white_28.png" /></a>
                                    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>  
                                    </div>

                                    <div class="post-social-elem stumbsocial left">
                                   <!-- Place this tag where you want the su badge to render -->
                                   <su:badge layout="5"></su:badge>

                                   <!-- Place this snippet wherever appropriate -->
                                   <script type="text/javascript">
                                     (function() {
                                       var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
                                       li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
                                       var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
                                     })();
                                   </script>
                                   </div>

                                    <div class="post-social-elem redditsocial left">
                                   <script type="text/javascript" src="//www.redditstatic.com/button/button2.js"></script>
                                   </div>
                                </div>
							</div>
							<div class="comment-block">
<div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'netgeroncom'; // required: replace example with your forum shortname

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    								
							</div>
						</div>
                        <?php echo $this->renderPartial('_right'); ?>
					</div>
				</div>
