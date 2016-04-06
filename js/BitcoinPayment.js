var BitcoinPayment = (function() {
	function BitcoinPayment() {
        $('#bitcoinPaid').click(function(e){
            e.preventDefault();
            checkPayment();
        });
	}
    
	BitcoinPayment.prototype.submit = function () {
        $('.bitcoin_modal_wrap').removeClass('hide');
	}
    
    function checkPayment () {
        $.post('/buyPublication/paymentCheck', {
            'payment': 'Bitcoin'
        }, function(data){
            if (data.result) {
                location.replace('/buyPublication/PaymentResult?payment=Bitcoin');
            } else {
                $(".bitcoin_modal_message").html(data.message);
                setTimeout('$(".bitcoin_modal_message").html("")', 2000);
            }
        }, 'json');
    }
    
    return BitcoinPayment;
}());