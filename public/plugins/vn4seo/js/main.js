
$('#seo_vn4 .menu-left li').click(function(event) {
	$(this).closest('#seo_vn4').find('.menu-left li.active').removeClass('active');
	$(this).addClass('active');

	$(this).closest('#seo_vn4').find('.content-right>.tab.active').removeClass('active');
	$(this).closest('#seo_vn4').find('.content-right>.tab.'+$(this).attr('aria-controls')).addClass('active');

});
$('#seo_vn4 .menu-left li a').click(function(event) {
	event.preventDefault();
});

$('#seo_vn4 .menu-top a').click(function(event) {
	event.preventDefault();

	$(this).closest('.menu-top').find('a.active').removeClass('active');
	$(this).addClass('active');

	$(this).closest('.tab').find('.content .active').removeClass('active');
	$(this).closest('.tab').find('.content .'+$(this).attr('aria-controls')).addClass('active');
});