<div class="bitcoin_modal_wrap hide">
  <div class="modal_body modal_payment_popup">
    <a href="#" class="modal_button_close close_modal">x</a>
    <img src="index.jpg" class="modal_logo">
    <div class="modal_content">
        <div>Please pay <b><?php echo $this->exchange($data['total'])?>BTC</b></div>
        <div>to the following address:</div>
        <div class="modal_content_center center">
            <div class="modal_payment_address center"><?php echo $this->getAddress(Yii::app()->user->profile->id);?></div>
            <div class="bitcoin_modal_message"></div>
            <p>After payment please confirm:</p>
            <a href="#" class="modal_button modal_button_green center" id="bitcoinPaid">Confirm</a>
        </div>
    </div>
  </div>
</div>