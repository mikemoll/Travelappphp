$(document).ready(function(){	
	$('.containerButton .btnText, .btnImg, .btnE3x25, .btnD3x25, .btnC3x25').live('hover', function(){
			$(this).parent().parent().find('.btnE3x25').attr('class', 'btnE3x25Hover');
			$(this).parent().parent().find('.btnC3x25').attr('class', 'btnC3x25Hover');
			$(this).parent().parent().find('.btnD3x25').attr('class', 'btnD3x25Hover');	
	});
	$('.containerButton, .btnText').live('mouseout', function(){
			$(this).parent().parent().find('.btnE3x25Hover').attr('class', 'btnE3x25');
			$(this).parent().parent().find('.btnC3x25Hover').attr('class', 'btnC3x25');
			$(this).parent().parent().find('.btnD3x25Hover').attr('class', 'btnD3x25');	
	});
	
});