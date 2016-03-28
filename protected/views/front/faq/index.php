<?php
/* @var $this FaqController */
?>
<section class="content">
				<div class="container">
					<div class="main clearfix">
						<div class="caption-block">
							<div class="title">
								<h1><strong>F</strong>requently <strong>A</strong>sked <strong>Q</strong>uestions</h1>
							</div>
                            <form action="<?php echo $this->createUrl('faq/');?>" method="get">
                            <input type="hidden" name="r" value="faq">
							<div class="search">
								<div class="input-line right-butt">
									<input type="text" placeholder="Search on the F.A.Q." name="search" value="<?php echo !empty($_GET['search']) ? CHtml::encode($_GET['search']) : ''?>">
									<span id="faq_search_but"><img src="<?php echo Yii::app()->request->baseUrl; ?>/img/content/search-ic.png" alt=""></span>
								</div>
							</div>
                            </form>
						</div>
						<div class="output">
							<ul class="faq-list">
                                <?php foreach($faq as $f) {?>
								<li>
                                    <h2><?php echo $f->title; ?></h2>
                                    <p><?php echo $f->answer; ?></p>
								</li>
                                <?php }?>
							</ul>
							<ul class="pagination">
                                <?php $this->widget('ext.PostLinkPager.PostLinkPager', array(
                                    'pages' => $pager,
                                    'cssFile' => '',
                                ))?>
							</ul>
						</div>
						<div class="right-side">
							<ul class="list-menu">
                                <?php foreach (FaqCategory::model()->findAll(array('order'=>'title')) as $c){?>
                                <li class="<?php echo (!empty($_GET['cid']) && $_GET['cid'] == $c->id ? 'active' : ''); ?>"><a href="<?php echo $this->createUrl('faq/index', array('cid' => $c->id)); ?>"><?php echo $c->title; ?> <span>(<?php echo $c->categoryCount; ?>)</span></a></li>
                                <?php }?>
							</ul>
						</div>
					</div>
				</div>
			</section>
<?php
    Yii::app()->clientScript->registerScript('faq_script',"
    $('#faq_search_but').click(function(e){
        e.preventDefault();
        $(this).closest('form').submit();
    });
    
    ",CClientScript::POS_READY);
?>
