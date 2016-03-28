$(document).ready(function() {
	customCheckRadio();
	customSelect();
	accountDropMenu();
	tabsLiveReportInit();
	choosePayment();
    initWhatISPopup();
    initAdvice();
    initFooter();
});

function initFooter() {
    $('#footer_subscribe_but').on('click', function(e){
        e.preventDefault();
        subscribe($('#footer_subscribe_input').val(), subscriberFooterRes);
    }); 
}

function subscriberFooterRes(res) {
    if (res.errors) {
        $('#footer_subscribe_errors').html(res.errors);
    } else {
        $('#footer_subscribe_errors').html('E-mail was added.');
        $('#footer_subscribe_but').hide();
    }
}

function accountDropMenu() {
	var accDropDown = $('.acc-drop-down');
	var accButton = $('.acc');
    $('.cc-drop-down-header').on("click", function(e) {
        e.preventDefault();
    });
	accButton.on("click", function(e) {
		//e.preventDefault();
		if($(this).hasClass('active')) {
			accDropDown.slideUp(400, function() {
				accButton.removeClass("active");
			});
			return;
		}
		$(this).addClass("active");
		accDropDown.slideDown(400);
	});
}

function customCheckRadio() {
	$('input[type="checkbox"], input[type="radio"]').iCheck({
		checkboxClass: 'icheckbox',
		radioClass: 'iradio'
	});
}

function customSelect() {
	$('select').chosen({
		disable_search: true,
		placeholder_text_single: "Select a Category",
		placeholder_text_multiple: "asdas"
	});
}



function tabsLiveReportInit() {
	$( "#tabs" ).tabs();
	$( "#tabs li" );
}

function choosePayment() {
	var radioButton = $(".choose-payment .radio-cell .iCheck-helper");
	var logo = radioButton.parents("tr").find(".logo")
	radioButton.on("click", function() {
		var currentButton = $(this);
		var currentLogo = currentButton.parents("tr").find(".logo")
		if(currentLogo.hasClass("active")) {
			return
		} else {
			logo.removeClass("active");
			currentLogo.addClass("active");
		}
	});
}

function subscribe(email, callback)
{
    var data = 'email='+email;
    $.ajax({
        type: 'POST',
        url: '/blog/subscribe',
        data: data,
        success:function(data){
                callback(data);
        },
        error: function(data) { // if error occured
            alert("Error occured. Please try again");
        },
        dataType:'json'
    });
}

function initWhatISPopup()
{
    $('.what-is').on('click', function() {
        $('.what-is-popup:hidden', $(this)).show();
    });
    $('.what-is-popup .close').on('click', function(e) {
        e.stopPropagation();
        $(this).closest('.what-is-popup').hide();
    });
}

function initAdvice()
{
    $('.advice-block .close').on('click', function(e) {
        var advice = $(this).closest('.advice-block');
        advice.hide('slow');
        $.ajax({
            type: 'GET',
            url: '/front/HideContent?href='+advice.attr('id'),
            success:function(data){
            },
            error: function(data) { // if error occured
                alert("Error occured. Please try again");
            }
        });        
    });    
}
