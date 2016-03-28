$(document).ready(function() {
    initCart();
	dropList(".drop-list-wrap");
    initSubmitDetails();
});

function initSubmitDetails() {
    $(".goods-list").on('click', '.close', function() {
        var parent = $(this).closest('.cart_item'); 
        parent.hide('slow');
        
        var item_id = $('.item_id', parent).val();
        var data = $('#cart-form').serialize()+'&delete=1&item_id='+item_id;
        $.ajax({
            type: 'POST',
            url: '/buyPublication/SubmitDetails',
            data: data,
            success:function(data){
                updateCart();
                $('.goods-list').html(data);
            },
            error: function(data) { // if error occured
                alert("Error occured. Please try again");
            },
            dataType:'html'
        });         
        
    });
    
    $('#submit_details_button').on('click', function(e) {
        e.preventDefault();
        $('#action_field').val('accept');
        $('#cart-form').submit();
    });
}

function selectDropList(select, val) {
    var drop = $(select);
    $('.current', drop).html(val);
    $('li', drop).each(function(i){
        $(this).removeClass('active');
        if (val == parseInt($(this).html())) {
            $(this).addClass('active');
        }
    });
}

function dropList(select) {
	$(".output").on('click', select + ' .arrow' + ', ' + select + ' .current', function() {
        var parent = $(this).closest(select);
		if($(this).hasClass('hide')) {
			$(this).on('click', function() {
				setTimeout(function() {
					$('ul', parent).slideUp(500, function() {
						$('.arrow, .current', parent).removeClass('hide');
						$('.wrap', parent).addClass('hidden');
					});
				}, 200);
			});
		} else {
			$('.wrap', parent).removeClass('hidden');
			setTimeout(function() {
				$('ul', parent).slideDown(500, function() {
					$('.arrow, .current', parent).addClass('hide');
				});
			}, 200);
		}
	});
	
	$(".output").on('click', select + ' li', function() {
        var parent = $(this).closest(select);
        var new_pos = $(this).html();
		$('.current', parent).html(new_pos);
		$('input', parent).val(new_pos-1);
		$('ul', parent).find("li").removeClass('active');
		$(this).addClass('active');
        if (parent.prop('id') != 'time-interval') {
            changePos(parent.closest('.cart_item'), new_pos-1);
        }else{
            $('#time_interval_field').val(new_pos);
        }
        $('ul', parent).slideUp(500, function() {
            $('.arrow, .current', parent).removeClass('hide');
            $('.wrap', parent).addClass('hidden');
        });
	});
}

function initCart()
{
    $('.cart a').on('click', function(e){
        if ($('.cart').hasClass('empty')) {
            e.preventDefault();            
        }
    });
}


/*
 * Change item position
 */
function changePos(item, new_pos)
{
    var item_id = $('.item_id' ,item).val();
    var data = $('#cart-form').serialize()+'&newpos4item=1&item_id='+item_id+'&newpos='+new_pos;
    $.ajax({
        type: 'POST',
        url: '/buyPublication/SubmitDetails',
        data: data,
        success:function(data){
            $('.goods-list').html(data);
        },
        error: function(data) { // if error occured
            //alert("Error occured. Please try again");
        },
        dataType:'html'
    });    
}

/**
 * Add To Cart
 */
function addToCart(pid, callback)
{
    var data='pid='+ pid;
    
    $.ajax({
        type: 'POST',
        url: '/cart/create',
        data: data,
        success:function(data){
            updateCart();
			if (callback) callback(data);
        },
        error: function(data) { // if error occured
            //alert("Error occured. Please try again");
        },
        dataType:'json'
    });
}


function updateCart()
{
    $.ajax({
        type: 'GET',
        url: '/front/GetCartInfo',
        success:function(data){
            $('.cart').removeClass('empty');
            $('.cart-text').html(data.text);
            if (!data.count) {
                $('.cart').addClass('empty');
            }
        },
        error: function(data) { // if error occured
            //alert("Error occured. Please try again");
        },
        dataType:'json'
    });        
}