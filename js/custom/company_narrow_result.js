$(function(){
    $('.narrow-results').on('click',function(){
        var narrow_result = $(this).parent('.search-bar').find('.menu-container');
        $(narrow_result).toggleClass('active')
    });
    $('.narrow-results').on('tap',function(){
        var narrow_result = $(this).parent('.search-bar').find('.menu-container');
        $(narrow_result).toggleClass('active')
  	});
	$('.narrow-results').on('click',function(){
        var narrow_result = $(this).parent('.popup_information').find('.megamenu_container_vertical');
        $(narrow_result).toggleClass('active')
    });
	$('.narrow-results').on('tap',function(){
        var narrow_result = $(this).parent('.popup_information').find('.megamenu_container_vertical');
        $(narrow_result).toggleClass('active')
    });
});