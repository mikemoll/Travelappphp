$.fn.menu = function(settings) {
	var defauls = {
		velocidade: 150,
		wSubmenu: 150
	}
	params = $.extend(defauls, settings)
	$this = $(this);
	$(this).css('zIndex', parseInt(new Date().getTime()/1000))
	$(this).find('li:last-child').css('borderBottom', '1px solid #ccc').css('borderRight', '1px solid #ccc')
    $(this).find('li').hover(function(){
    	$(this).parent().parent().css('zIndex', parseInt(new Date().getTime()/1000))
    	$(this).find('ul li').css('width', params.wSubmenu)
        $(this).find('ul ul').css('left', $(this).find('ul').width() - 2)
        $(this).find('ul li:last-child').css('borderBottom', '1px solid #ccc')
        $(this).find('ul:first').css({visibility: "visible", display: "none"}).show(params.velocidade);
    	}, function(){$(this).find('ul:first').css({visibility: "hidden"});
    });
}