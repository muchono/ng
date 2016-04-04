<div class="bitcoinModal hide">
Summ:
<input type="text" value="<?php echo $this->exchange($data['total'])?>" id="bitcoinSumm"/>
Address: <?php echo $this->getAddress(Yii::app()->user->profile->id);?>
<a href="" id="bitcoinPaid">Paid</a>
</div>