var BitcoinPayment = (function() {
	function BitcoinPayment() {
        $('#bitcoinPaid').click(function(e){
            e.preventDefault();
            checkPayment();
        });
	}
    
	BitcoinPayment.prototype.submit = function () {
        $('.bitcoinModal').removeClass('hide');
	}
    
    function checkPayment () {
        $.post('/buyPublication/paymentCheck', {
            'payment': 'Bitcoin'
        }, function(data){
            if (data.result) {
                location.replace('/buyPublication/PaymentResult?payment=Bitcoin');
            }
        }, 'json');
    }
    
    return BitcoinPayment;
}());