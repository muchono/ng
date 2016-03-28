<footer>
				<div class="footer-bar">
					<div class="container">
						<div class="description">
							<div class="footer-logo">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/logo-footer.png" alt="Netgeron">
							</div>
							<p id="footer_dex_text">
                                <?php if ($this->add_footer_text) {?>
                                <?php echo $this->getFooterDescText();?>
                                <?php }?>
                            </p>
						</div>
						<div class="fresh-blog">
							<div class="h4">New On The Blog</div>
							<ul>
                                <?php foreach(Post::model()->getFresh() as $p){?>
								<li>
                                    <a href="<?php echo $this->createUrl('/'.$p->url_anckor); ?>">
                                        <p class="blog-text"><?php echo $p->title; ?></p>
										<p class="date"><?php echo $p->date; ?></p>
									</a>
								</li>
                                <?php }?>
							</ul>
						</div>
						<div class="newsletter">
                             <?php if ($this->showSubscribe()) {?>
							<div class="h4">Newsletter</div>
							<form action="">
                                <div class="newsletter-form">
                                    <input id="footer_subscribe_input" type="text" placeholder="Your Email">
                                    <input id="footer_subscribe_but" type="button" value="Sign up">
                                </div>
								<div id="footer_subscribe_errors" class="error-message"></div>
							</form>
                             <?php }?>
							<div class="h4">Follow Us</div>
							<ul class="social">
								<li class="fb">
									<a href="https://www.facebook.com/netgeron" target="_blank"></a>
								</li>
								<li class="gp">
									<a href="https://plus.google.com/115118741689279716854/" target="_blank"></a>
								</li>
								<li class="tw">
									<a href="https://twitter.com/netgeron" target="_blank"></a>
								</li><!--
								<li class="yt">
									<a href="" target="_blank"></a>
								</li>-->
								<li class="rss">
									<a href="<?php echo $this->createUrl('blog/rss');?>" target="_blank"></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="wrap">
					<div class="container">
						<nav class="foot-nav">
							<ul>
                                <li><a href="/">Home</a></li>
								<li><a href="<?php echo $this->createUrl('/howitworks'); ?>">How it works</a></li>
								<li><a href="<?php echo $this->createUrl('/about'); ?>">About</a></li>
								<li><a href="<?php echo $this->createUrl('blog/'); ?>">Blog</a></li>
								<li><a href="<?php echo $this->createUrl('/privacy'); ?>">Privacy Policy</a></li>
								<li><a href="<?php echo $this->createUrl('/terms'); ?>">Terms of Use</a></li>
								<li><a href="<?php echo $this->createUrl('/contact'); ?>">Contact</a></li>
							</ul>
						</nav>
						<div class="copy">
                            <p>Copyright © <?php echo date("Y"); ?> Netgeron. All rights reserved.</p>
						</div>
					</div>
				</div>
			</footer>
<?php
if (!$this->add_footer_text) {
    Yii::app()->clientScript->registerScript('footer_script',"
    $.get('".$this->createUrl('front/FooterDescText')."', function( data ) {
        $('#footer_dex_text').html(data);
    });
    ",CClientScript::POS_READY);
}
?>