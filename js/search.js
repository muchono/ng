$(document).ready(function() {
	sliderInit("#traffic", "#traffic_value", ['Any Traffic','250K >','500K >','1M >','2M >','5M >','10M >','25M >', '50M >']);
	sliderInit("#google_pr", "#google_pr_value", ['Any PR','PR1 >','PR2 >','PR3 >','PR4 >','PR5 >','PR6 >', 'PR7 >', 'PR8 >' ]);
	sliderInit("#price", "#price_value",['Any Price','Under $100','Under $200','Under $400','Under $800','Under $1600']);
    searchActionsInit();
    sortInit();
    initPageLoader();
    initAddToCart();
});

/**
 * Init page loader
 */
var loading = false;
function initPageLoader()
{
	$(window).scroll( function(){
		/* Check the location of the desired element */
        if (!loading) {
            if (parseInt($('#pager_pages_num').val()) > parseInt($('#pager_current_page').val())) {
                var last_product = $('.goods:last');
                if (last_product.length) {
                    var bottom_of_object = last_product.position().top + last_product.outerHeight() + 150/* additional space for loader */;
                    var bottom_of_window = $(window).scrollTop() + $(window).height();
                    if( bottom_of_window > bottom_of_object) {
                        loading = true;
                        $('#loader_bottom').show(0, function(){
                            $('#pager_current_page').val(parseInt($('#pager_current_page').val()) + 1);
                            sendForm('search-form', appendResCallback);
                        });
                    }
                }
            } else {
                /* last page loaded, stop loading */
                loading = true;
            }
        }
	});
}

/**
 * Send filter data
 */
function sendForm(form_id, callback)
{
    var form = $("#"+form_id);
    var data=form.serialize() + '&sort_by='+getSortOrder();
    
    $.ajax({
        type: 'POST',
        url: form.attr('action'),
        data: data,
        success:function(data){
                callback(data);
        },
        error: function(data) { // if error occured
            //alert("Error occured. Please try again");
        },
        dataType:'html'
    });
}

/**
 * Send filtered data
 */
function sendFormFilter()
{
    /* start from first page */
    $('#pager_current_page').val(1);
    loading = false;
    
    sendForm('search-form', showResCallback);
}

/**
* Show filter request result
*/
function showResCallback(res)
{
    $('.goods-list').html(res);
}

/**
* Append request result
*/

function appendResCallback(res)
{
    $.each($(res), function(k,v){
        if ($(v).is('.product-li')){
            $(v).css('display', 'none').appendTo($('.goods-list')).slideDown();
        }
    });
    
    $('#loader_bottom').hide();

    loading = false;
}

/**
 * Init JUI slider
 */
function sliderInit(id1, id2, values) 
{
	$(id1).slider({
		min: 0,
        max: values.length - 1, 
        step: 1,
        change: function( event, ui ) {
            sendFormFilter();
        },
		slide: function( event, ui ) {
			$(id2).text(values[ui.value]);
            $(id1+'_input').val(values[ui.value]);
		}
	});
	$(id2).text( values[$(id1).slider( "value" )] );
    $(id1+'_input').val(values[$(id1).slider( "value" )]);
}

function updateSearchTitle()
{
    var title = 'All Resources';
    var selected = $('.categories_filter input:checked');

    if (typeof(selected.val()) != 'undefined' && selected.val() != 'all') {
      title = $('.categories_filter label[for=category_'+ selected.val() +']').html();
    }
    

    $('h1.left').html(title);
}

/**
 * Init search form elements
 */
function searchActionsInit()
{
    // init categories filter
    $('.categories_filter input').on('ifClicked', function(event){
        //no selected category
        if ($(this).is(':checked')){
            $(this).iCheck('uncheck');
            updateSearchTitle();
            sortReset(0);
            sendFormFilter();            
            
        }
        $('.categories_filter input').iCheck('uncheck');
    });
    
    $('.categories_filter input').on('ifChecked', function(event){
        updateSearchTitle();
        sortReset(1);
        sendFormFilter();
    });
    
    //init links filter
    $('.links_filter input').on('ifChanged', function(event){
        sendFormFilter();
    });
    
    //init anchors filter
    $('.anchors_filter input').on('ifChanged', function(event){
        sendFormFilter();
    });
    
    //init domain filter
    $('.domain_zone_filter input').on('ifChanged', function(event){
        sendFormFilter();
    });    
}

function sortReset(category_selected)
{
    $('.sort-butt .active').removeClass('active').addClass('no-active').find('i').remove();
    if (category_selected) {
        $('#sort_relevance').removeClass('no-active').addClass('active').show();
    } else {
        $('#sort_relevance').hide();
        $('#sort_traffic').removeClass('no-active').addClass('active').append('<i class="down"></i>');
    }
}
/**
 * Sort buttons init
 */
 function sortInit()
 {
    //sort init
    $('.sort-butt span').click(function(){
        var send = true;
        //if not selected
        if (!$(this).hasClass('active')) {
            $('.sort-butt .active').removeClass('active').addClass('no-active').find('i').remove();
            $(this).removeClass('no-active').addClass('active');
            if ($(this).attr('id') != 'sort_relevance') {
                $(this).append('<i class="down"></i>');
            }
        } else {
            if ($(this).attr('id') != 'sort_relevance') {
                var sort_mark = $('i', this);
                if (sort_mark.hasClass('down')) {
                    sort_mark.removeClass('down').addClass('up');
                } else {
                    sort_mark.removeClass('up').addClass('down');
                }
            } else send = false;
        }
        
        if (send) sendFormFilter();
    }); 
 }

/**
 * Get active sort order
 */
 function getSortOrder()
{
    var s = $('.sort-butt .active');
    var sort_by = s.attr('id');
    if (typeof($('i', s)).attr('class') != 'undefined') {
        sort_by = sort_by + '_' + $('i', s).attr('class');
    }
    return sort_by;
}

function initAddToCart()
{
    $('.goods-list').on('click', '.butt', function(event){
        if ($(this).hasClass('order')) {
            event.preventDefault();
            addToCart($(this).attr('href'), function(data){
				trackIt();
                location.replace('/buyPublication/SubmitDetails');
            });
        }
        if ($(this).hasClass('add')) {
            event.preventDefault();
            addToCart($(this).attr('href'), function(data){
				trackIt();
            });
            $(this).closest('.button-block').addClass('hide');
            $(this).closest('td').find('.added2cart').removeClass('hide');
        }
    });
}

function trackIt() {
	mt('send', 'pageview', {page_url: 'http://www.netgeron.com/add-to-cart/'});
}
