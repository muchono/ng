<?php
/* @var $this HelpController */
?>
<section class="content">
				<div class="container">
					<div class="main clearfix">
						<h1>Do you have any questions?</h1>
						<div class="half left">
							<div class="block faq">
                                <h2>Check <a href="<?php echo $this->createUrl('faq/')?>">F.A.Q.</a></h2>
								<p>where you can find answers for many question</p>
							</div>
							<div class="h4">Popular Questions:</div>
							<ul>
                                <?php foreach($faq as $f) {?>
								<li>
                                    <h3><?php echo $f->title; ?></h3>
                                    <p><?php echo $f->answer; ?></p>
								</li>
                                <?php }?>
							</ul>
							<a href="<?php echo $this->createUrl('faq/')?>" class="butt">More</a>
						</div>
						<div class="half right">
							<div class="block email">
								<h2>Email Support</h2>
								<p>Ask your question via Email</p>
							</div>
							<table>
								<tr>
									<td class="text-right">For presales questions:</td>
									<td><img src="img/content/email-1.png"></td>
								</tr>
								<tr>
									<td class="text-right">For support:</td>
									<td><img src="img/content/email-2.png"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</section>

