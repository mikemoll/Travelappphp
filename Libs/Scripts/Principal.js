$(document).ready(function () {


    $('.btn-file :file').on('fileselect', function (event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' arquivos selecionados' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }

    });


    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-br-pre": function (a) {
            if (a == null || a == "") {
                return 0;
            }
            var brDataEHora = a.split(' ');
            var brDatea = brDataEHora[0].split('/');
//            console.log(brDatea[2] + brDatea[1] + brDatea[0]);
            return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
        },
        "date-br-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "date-br-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

    $("body").delegate(".datepicker", "focusin", function () {
        times = $(this).attr('data-times-focused');
        if (typeof times == 'undefined') {
            $(this).datepicker( );
            $(this).attr('data-times-focused', '1');

        }
    });

    $("body").delegate("[data-alternative-field]", "change", function () {
        aternativeField = $(this).attr('data-alternative-field');
        valor = $(this).val( );
        $('#' + aternativeField).datepicker('update', valor);
    });


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

    $("body").delegate("[maxlength]", "keyup", function () {
        var maxLength = $(this).attr('maxlength');
        var id = $(this).attr('id');
        var length = $(this).val().length;
        var length = maxLength - length;
        $('#chars' + id + '').text(length);
    });
});

$(document).on('change', '.btn-file :file', function () {
    var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
});
