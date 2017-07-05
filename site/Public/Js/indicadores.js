/**
 * Script para a página de indicadores
 */

//$(document).ready(function () {
$('.btn-historico-click > #btnHistorico').live('click', function () {
//        $(this).appendTo().html('<i class="fa fa-spinner spinner" ></i>');
    $(this).parent().find('.fa-spinner').show();
//        $('#' + rel).find('.tab').html('<i class="fa fa-spinner spinner" ></i>');
//        $('#' + rel).slideToggle('swing',function (){
//        });
//        $('#' + rel).parent().find('.indicadores-atuais').slideToggle();
//        toggleIndicadorAtual($('#' + rel));
});
$('.btn-fechar-historico').live('click', function () {
    $(this).hide();
    $(this).parent().find('.historico').slideUp('swing');
    $(this).parent().find('.indicadores-atuais').slideDown('swing');
});
$('#btnFiltros').live('click', function () {
    $('#filtros').slideDown();
    $(this).hide();
});

$('.card').live('hover', function () {
    $(this).find('.show-on-hover-card').fadeIn("fast");
});
$('.card').live('mouseleave', function () {
    $(this).find('.show-on-hover-card').fadeOut("slow");
});
$('.link-mais-info').live('click', function () {
    $(this).parent().parent().find('#info').toggle();
});


$('.linhaTecnicoEficiencia').live('click',function () {
    $(this).hide();
});

//});

//function toggleIndicadorAtual(obj) {
////    console.log(obj);
//    size = obj.parent().find('.huge').css('font-size');
////    console.log(size);
//    if (parseInt(size) > 12) {
//        obj.parent().find('.huge').css('font-size', '12px');
//        obj.parent().find('.fa').css('display', 'none');
//    } else {
//        obj.parent().find('.huge').css('font-size', 'auto');
//        obj.parent().find('.fa').css('display', 'block');
//    }
//
//}
