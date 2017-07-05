$(document).ready(function () {
    $('.campo-editavel').focus(function () {
        if ($(this).html() === '') {
            $(this).html('');
            $(this).attr('class', 'campo-editavel campo-editavel-escrevendo ');
        }
    });
    $('.campo-editavel').blur(function () {
        if ($(this).html() === '' || $(this).html() === '<br>') {
            $(this).attr('class', 'campo-editavel campo-editavel-vazio');
            $(this).attr('html', '');
        } else {
            $(this).attr('class', 'campo-editavel campo-editavel-preenchido');
        }
    });


    $('.diminuiFonte').click(function () {
        var id = $(this).attr('role');
        var fontSize = parseInt($('.tabelaLarga' + id).find('td').css('font-size'));
        console.log(fontSize);
        fontSize = fontSize - 1 + 'px';
        $('.tabelaLarga' + id).find('td').css('font-size', fontSize);
        $('.tabelaLarga' + id).find('th').css('font-size', fontSize);
    });
    $('.aumentaFonte').click(function () {
        var id = $(this).attr('role');
        var fontSize = parseInt($('.tabelaLarga' + id).find('td').css('font-size'));
        fontSize = fontSize + 1 + 'px';
        $('.tabelaLarga' + id).find('td').css('font-size', fontSize);
        $('.tabelaLarga' + id).find('th').css('font-size', fontSize);
    });

    $('.apagavel').css('cursor', 'pointer');
    $('.apagavel').click(function () {
        $(this).hide();
    })
});

function verifiCacamposEditaveis() {

    $('.campo-editavel').each(function () {
        if ($(this).html() === '') {
            $(this).focus();
            alert('Preencha todos os campos em Vermelho!')
            exit();
        }
    })
    print();
}
function mostrarColuna(i) {
    $('.tabelaLarga' + i + ' td,th').show();
}
function escondeColuna(numColuna, id) {
    $(id.parent().parent().parent()).find('td:nth-child(' + numColuna + '),th:nth-child(' + numColuna + ')').hide();
}

$(document).ready(function ()
{
    $('.tabelaRelatorio th').css('cursor', 'pointer');
    $('.tabelaRelatorio th').css('vertical-align', 'middle');
    $('.tabelaRelatorio th').prepend('<a class="imgClose"  title="Clique aqui para esconde essa coluna. Para mostrar todas a colunas novamente, clique em ' + "'" + 'Mostrar Colunas' + "'" + '"  href="#none" style="display:block;text-align:center"><i class="fa fa-times"></i><br></a>');
    $('.tabelaRelatorio th').hover(function () {
        $(this).find(".imgClose").show();
    }, function () {
        $(this).find(".imgClose").hide();
    });
    $(".imgClose").hide();
    $('.tabelaRelatorio th').attr('title', '');
    $('.imgClose').click(function () {
        val = $(this).parent();
        numColuna = $(val.parent()).find('th').index(val);
        escondeColuna(numColuna + 1, val);
    });
    
    $('.esconder').click(function () {
        $(this).hide();
        $(this).next().hide();
    });
});

