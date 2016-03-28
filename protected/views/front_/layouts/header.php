			<header>
				<div class="container">
					<div class="logo">
						<a href="<?php echo $this->createUrl('front/');?>">
							<img src="img/content/logo.png" alt="netgeron">
						</a>
					</div>
					<?php if (Yii::app()->user->isGuest){?>
					<nav class="main-nav">
						<ul>
                            <li <?php echo $this->page == 'home' ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('front/');?>">Home</a></li>
							<li <?php echo $this->page == 'hit' ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('front/howitworks');?>">How it works</a></li>
							<li <?php echo $this->page == 'about' ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('front/about');?>">About</a></li>
							<li <?php echo in_array($this->page, array('blog','blog post')) ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('blog/');?>">Blog</a></li>
							<li <?php echo $this->page == 'for_writers' ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('front/forwriters');?>">For Writers and Sites Owners</a></li>
						</ul>
					</nav>
					<div class="control-pane">
						<div class="login">
							<a target="_blank" href="<?php echo $this->createUrl('login/');?>">Login</a>
						</div>
						<div class="sign-up">
                            <form action="<?php echo $this->createUrl('register/');?>" method="post" target="_blank">
							<input type="submit" value="Sign up">
                            </form>
						</div>
					</div>
					<?php } else {?>
					<nav class="main-nav">
						<ul>
							<li <?php echo in_array($this->page, array('choose-resource','choose-payment','choose-payment succesful', 'choose-payment not-succesful', 'live-report', 'details one', 'details more')) ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('buyPublication/');?>">Buy Publications</a></li>
							<li <?php echo in_array($this->page, array('blog','blog post')) ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('blog/');?>">Blog</a></li>
							<li <?php echo in_array($this->page, array('faq','faq post')) ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('faq/');?>">F.A.Q.</a></li>
							<li <?php echo $this->page == 'help' ? 'class="active"' : ''?>><a href="<?php echo $this->createUrl('help/');?>">Help</a></li>
						</ul>
					</nav>                    
					<div class="control-pane">
						<div class="acc">
							<a href="" class="cc-drop-down-header">My Account</a>
							<ul class="acc-drop-down">
								<li><a href="<?php echo $this->createUrl('myAccount/MyNetgeron');?>">My Netgeron</a></li>
								<li><a href="<?php echo $this->createUrl('myAccount/Settings');?>">Settings</a></li>
								<li><a href="<?php echo $this->createUrl('buyPublication/LiveReport');?>">Live Report</a></li>
								<li class="separator"></li>
								<li class="out"><a href="<?php echo $this->createUrl('myAccount/SignOut');?>">Sign Out</a></li>
							</ul>
						</div>
						<?php $cart = $this->getCartInfo();
                        ?>
                        <div class="cart <?php echo $cart->count ? '' : 'empty'?>">
                            <a href="<?php echo $this->createUrl('buyPublication/SubmitDetails');?>">
								<span>
									<img src="img/content/cart-ic.png" alt="">
								</span>
								<span class="cart-text"><?php echo $cart->text?></span>
							</a>
						</div>
					</div>                        
                    <?php }?>
				</div>
			</header>