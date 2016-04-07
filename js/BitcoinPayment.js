var BitcoinPayment = (function() {
	function BitcoinPayment() {
        $('#bitcoinPaid').click(function(e){
            e.preventDefault();
            checkPayment();
        });
        $('#bitcoinBack').click(function(e){
            e.preventDefault();
            $('.bitcoin_modal_wrap').addClass('hide');
            $(".bitcoin_modal_message").html("&nbsp;")
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
                $("#bitcoin_modal_price").html(data.to_pay);
                setTimeout('$(".bitcoin_modal_message").html("&nbsp;")', 3000);
            }
        }, 'json');
    }
    
    return BitcoinPayment;
}());