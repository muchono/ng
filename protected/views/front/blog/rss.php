<?php
/**
 * @var $this BlogController
 * @var $posts Post[]
 */

?>
<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<rss version="2.0">

<channel>
  <title>Netgeron SEO blog</title>
  <link>http://www.netgeron.com/blog.html</link>
  <description>Netgeron SEO blog</description>
  <?php foreach ($posts as $p) {?>
  <item>
    <title><?php echo $p->title;?></title>
    <link><?php echo $this->createAbsoluteUrl('blog/post', array('href'=>$p->url_anckor))?></link>
    <description><![CDATA[<img src="<?php echo Yii::app()->getBaseUrl(true) . '/' . $p->getImageName('thumb')?>" /><br/>]]><![CDATA[<?php echo $p->brief;?>]]></description>
  </item>
  <?php }?>
</channel>

</rss> 