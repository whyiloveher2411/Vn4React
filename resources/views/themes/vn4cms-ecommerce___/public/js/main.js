$(window).on('load',function(){
    $('.loading-page').fadeOut(0);
    $('.header-desktop .lang').select();

    if($('.home-slick1').length > 0){
    	$('.home-slick1').slick({
    		dots: true
    	});
    }
})