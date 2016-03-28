$(document).ready(function() {
	init();
});

function init()
{
    $('#categories_select').on('change', function(e){
        location.replace('/blog?cid='+$(this).val());
    });
    
    $('#search_but').on('click', function(e){
        $('#search_form').submit();
    });
    
    $('#blog_subscribe').on('click', function(e){
        e.preventDefault();
        subscribe($('#blog_subscribe_input').val(), subscriberBlogRes);
    });    
}

function subscriberBlogRes(res)
{
    if (res.errors) {
        $('#blog_subscribe_errors').html(res.errors);
    } else {
        $('#blog_subscribe_errors').removeClass('error-message');
        $('#blog_subscribe_errors').addClass('success-message text-center');
        $('#blog_subscribe').hide();
        $('#blog_subscribe_errors').html('Subscribed');
    }
}