var BitcoinPayment = (function() {
    var intervalID = 0;

	function BitcoinPayment() {
        $('#bitcoinPaid').click(function(e){
            e.preventDefault();
            checkPayment();
        });
        $('#bitcoinBack').click(function(e){
            e.preventDefault();
            clearInterval(intervalID);
            $('.bitcoin_modal_wrap').addClass('hide');
            $(".bitcoin_modal_message").html("&nbsp;")
        });        
	}
    
	BitcoinPayment.prototype.submit = function () {
        $('.bitcoin_modal_wrap').removeClass('hide');
        intervalID = setInterval(function(){ 
        $.get('/buyPublication/paymentCheck');
        }, 20000);
	}
    
    function checkPayment () {
        $.post('/buyPublication/paymentCheck', {
            'payment': 'Bitcoin'
        }, function(data){
            if (data.result) {
                $('#choose-pyment-form').submit();
            } else {
                $(".bitcoin_modal_message").html(data.message);
                $("#bitcoin_modal_price").html(data.to_pay);
                setTimeout('$(".bitcoin_modal_message").html("&nbsp;")', 8000);
            }
        }, 'json');
    }
    
    return BitcoinPayment;
}());