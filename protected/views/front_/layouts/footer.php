			<footer>
				<div class="footer-bar">
					<div class="container">
						<div class="description">
							<div class="footer-logo">
								<img src="img/content/logo-footer.png" alt="Netgeron">
							</div>
							<p>Netgeron - is not the market. This is a marketing company that has a well-established contacts with journalists and writers around the world. This allows us to write and publish articles on such prestigious sites as Forbes, CNN, Buzzfeed.</p>
						</div>
						<div class="fresh-blog">
							<div class="h4">Fresh From The Blog</div>
							<ul>
                                <?php foreach(Post::model()->getFresh() as $p){?>
								<li>
                                    <a href="<?php echo $this->createUrl('blog/post', array('href'=>$p->url_anckor)); ?>">
                                        <p class="blog-text"><?php echo $p->title; ?></p>
										<p class="date"><?php echo $p->date; ?></p>
									</a>
								</li>
                                <?php }?>
							</ul>
						</div>
						<div class="newsletter">
							<div class="h4">Newsletter</div>
							<form action="">
                                <span id="footer_subscribe_errors"></span>
								<input id="footer_subscribe_input" type="text" placeholder="Your Email">
								<input id="footer_subscribe_but" type="button" value="Sign up">
							</form>
							<div class="h4">Follow Us</div>
							<ul class="social">
								<li class="fb">
									<a href=""></a>
								</li>
								<li class="gp">
									<a href=""></a>
								</li>
								<li class="tw">
									<a href=""></a>
								</li>
								<li class="yt">
									<a href=""></a>
								</li>
								<li class="rss">
									<a href=""></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="wrap">
					<div class="container">
						<nav class="foot-nav">
							<ul>
                                <li><a href="<?php echo $this->createUrl('front/'); ?>">Home</a></li>
								<li><a href="<?php echo $this->createUrl('front/howitworks'); ?>">How it works</a></li>
								<li><a href="<?php echo $this->createUrl('front/about'); ?>">About</a></li>
								<li><a href="<?php echo $this->createUrl('blog/'); ?>">Blog</a></li>
								<li><a href="<?php echo $this->createUrl('front/contact'); ?>">Contact</a></li>
							</ul>
						</nav>
						<div class="copy">
                            <p>Copyright © <?php echo date("Y"); ?> Netgeron. All rights reserved.</p>
						</div>
					</div>
				</div>
			</footer>