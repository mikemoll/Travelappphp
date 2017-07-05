$(document).ready(function () {


   









    /**
     * Controle para que o menu não fique fixo caso ele sega maior do que a janela.
     * Pois se ele é fixo, ele sai pra fora da ela e não dá pra acessar os itens de baixo
     */
    $('.navbar-collapse').click(function () {
        setTimeout(togglePositionMenu(), 2000);
    });
    togglePositionMenu();
    function togglePositionMenu() {
        hM = $('.navbar-collapse').height();
        hW = $(window).height();
        console.log(hM + ' > ' + hW);
        if (hM > hW) {
            $('.navbar-collapse').css('position', 'relative');
        } else {
            $('.navbar-collapse').css('position', 'fixed');

        }

    }

    /**
     * Mostra e esconde o menu clicando no botao da esquerda
     */
    $('#burger').click(function () {
        var margin = $('#page-wrapper').css("padding-left");
        console.log(margin);
        if (margin === '20px') {
            $('#page-wrapper').css('padding', '0 20px 0 282px');
            $('.navbar-collapse').show();
        } else {
            $('#page-wrapper').css('padding', '0 20px 0 20px');
            $('.navbar-collapse').hide();
        }


    });

    /**
     * Frescurinha ao carregar a pagina
     */
    $("#page-wrapper").animate({
        opacity: 1,
        top: "+=50"
    }, 500, function () {
        // Animation complete.
        $('#page-wrapper').css('position', 'relative');
    });


});
