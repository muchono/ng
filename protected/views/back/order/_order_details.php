<?php 
$p = $data->getProductsList();
foreach ($p as $k=>$d) {?>
<div class="order-details-item left">
    <?php echo CHtml::link($d['title'], array('product/update', 'id' => $d['product_id']), array('target' => '_blank'));?> for 
    <?php echo CHtml::link(substr(str_replace('https://', '',$d['url']),0,63 - strlen($d['title'])).(strlen(str_replace('https://', '',$d['url'])) > 60 - strlen($d['title']) ? '...' : ''), $d['url'], array('target' => '_blank'));?>
    <span class="<?php echo Order::$statuses_styles[$d['status']]?>"><?php echo $d['status_name']?></span>
</div>
<?php if (count($p) != $k+1){?>

<?php }?>
<?php }?>