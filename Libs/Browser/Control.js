/**
 * Biblioteca de funções para manipulação do Browser
 * 
 * @author Ismael Sleifer Web Designer <ismaelsleifer@gmail.com>
 * @author Leonardo Andriolli Danieli <leonardo@4coffee.com.br>
 */

// #################### variaveis globais ##########################

var pressedKey = false;

// #################################################################

/**
 * Retorna um valor para o z-index sendo este retornado o z-index mais alto
 */
function getMaxZindex() {
    retorno = parseInt(new Date().getTime() / 1000);
    return retorno;
}
function marcaObrig() {
    $('*[obrig]').css('borderRight', '2px solid #c10005');
    $(".select2-hidden-accessible").each(function () {
        obrig = $(this).attr('obrig');
        id = $(this).attr('id');
        if (obrig == 'obrig') {
            $("span[aria-labelledby='select2-" + id + "-container']").parent().parent().css('border-right', '2px solid rgb(193, 0, 5)')
        }
    });
}

function desmarcaCheckedGrid() {
    var chks = $('input[id *= "chklstTodos"]');
    $.each(chks, function (i, obj) {
        obj.checked = false;
    });
}

function setConfirm(title, text, w, h, obj, event) {
    html = '<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alert" aria-hidden="true">' +
            '<div class="modal-dialog" role="document">' +
            '<div class="modal-content">' +
            '   <div class="modal-header">' +
            '      <h5 class="modal-title" id="exampleModalLabel">' + title + '</h5>' +
            '     <button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '        <span aria-hidden="true">&times;</span>' +
            '   </button>' +
            '    </div>' +
            '   <div class="modal-body">' +
            text +
            ' </div>' +
            ' <div class="modal-footer">' +
            '   <button type="button" class="btn btn-default" data-dismiss="modal">No</button>' +
            '   <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnConfirmYes"  >Yes</button>' +
            ' </div>' +
            ' </div>' +
            '</div>' +
            '</div>';
    if ($('#alertModal').length === 0) {
        $("body").append(html);
    }
    $('#alertModal').modal( );
    $('#alertModal').on('click', '#btnConfirmYes', function () {
        msg = obj.attr('msg');
        obj.removeAttr('msg');
        ajaxRequest(obj, event);
        obj.attr('msg', msg);
        return false;
    });
}


function setAlert(title, text, w, h) {

    html = '<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alert" aria-hidden="true">' +
            '<div class="modal-dialog" role="document">' +
            '<div class="modal-content">' +
            '   <div class="modal-header">' +
            '      <h5 class="modal-title" id="exampleModalLabel">' + title + '</h5>' +
            '     <button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
            '        <span aria-hidden="true">&times;</span>' +
            '   </button>' +
            '    </div>' +
            '   <div class="modal-body">' +
            '  ' +
            text +
            ' </div>' +
            ' </div>' +
            '</div>' +
            '</div>';
    if ($('#alertModal').length == 0) {
        $("body").append(html);
    }
    $('#alertModal').modal();
}

function addToolTip(obj) {
    var pos = $('#' + obj.id).position();
    var html = '';
    if ($('#' + obj.id + '_msg').html() == null) {
        html = '<div id="' + obj.id + '_msg" onClick="$(' + "'" + '#' + obj.id + '_msg' + "'" + ').remove()"' +
                'style="z-index:1000;position:absolute;top:' + (pos.y + 20) + ';left:' + (pos.x) + ';margin-top:5px;' +
                'padding:2px;border:1px solid #CD0A0A;font-size: 11px;background:#FEF1EC">' + obj.val + '<spam >' +
                '<font color="red">X</font></spam></div>';
        $('#' + obj.id).after(html);
    } else {
        $('#' + obj.id + '_msg').html(obj.val);
    }
}
function setDataForm(obj) {
    var idForm = '';
    if (obj.idForm != '') {
        idForm = '#' + obj.idForm;
    }
    $.each(obj.fieldValues, function (y, values) {
        var tipo;
        if (values.type != '') {
            tipo = values.type;
        } else {
            tipo = $(idForm + ' #' + values.idField).attr('type');
            console.log('tipo: ' + tipo);
            if (typeof tipo == 'undefined') {
                tipo = $(' #' + values.idField).prop("tagName");
                console.log('tipo2: ' + tipo);
            }
        }
        console.log(idForm + ' #' + values.idField);
        tipo = tipo.toLowerCase();
        switch (tipo) {
            case "number":
            case "text":
            case "hidden":
            case "password":
                $(idForm + ' #' + values.idField).val(values.fieldValue);
                break;
            case "textarea":
                tipo = $(idForm + ' #' + values.idField).attr('data-editor');
                if (typeof tipo != 'undefined') {
                    if (tipo.substr(0, 7) == 'tinymce' && typeof tinymce != 'undefined') {
                        console.log('tinymce');
                        tinymce.get(values.idField).setContent(values.fieldValue);
                    }
                } else {
                    $(' #' + values.idField).val(values.fieldValue);
                }
                break;
            case "checkbox":
                if ($(idForm + ' #' + values.idField).attr('value') == values.fieldValue) {
                    $(idForm + ' #' + values.idField).attr('checked', 'checked');
                } else {
                    $(idForm + ' #' + values.idField).removeAttr('checked');
                }
                break;
            case "select-one":
                console.log(values.fieldValue);
                if (Array.isArray(values.fieldValue)) {
                    for (var i in values.fieldValue) {
                        $(idForm + ' #' + values.idField).find('option[value=' + values.fieldValue[i] + ']').attr('selected', 'selected');
                    }
                    $(idForm + ' #' + values.idField).trigger("change");
                } else {
                    $(idForm + ' #' + values.idField).find('option[value=' + values.fieldValue + ']').attr('selected', 'selected');
                }
                break;
            case "select":
                var option = '';
                var values2 = [];
                for (var i in values.fieldValue) {
                    values2.push({key: i, value: values.fieldValue[i]});
                }
                values2.sort(function (a, b) {
                    return a.value.localeCompare(b.value);
                });
                console.log(values2);
                $.each(values2, function (i, val2) {
//                    console.log(val.key);
                    i = val2.key;
                    val = val2.value;
                    if (typeof val == 'object') {
                        option += '<optgroup id="' + values.idField + '-optgroup-' + i + '" label="' + i + '">';
                        $.each(val, function (i, val2) {
                            option += '<option value="' + i + '" label="' + i + '">' + val2 + '</option>';
                        });
                        option += '</optgroup>';
                    } else {
                        $('#' + values.idField).append($('<option>').text(val).attr('value', i));
//                        option += '<option value="' + i + '" label="' + val + '">' + val + '</option>';
                    }
                });
//                    exit();
//                $('#' + values.idField).html(option);
                break;
            default:
                $(idForm + ' #' + values.idField).val(values.fieldValue);
                break;
        }
    });
}
function resetForm(obj) {
    $('[select2]').empty().trigger("change");
    $('#' + obj.idForm)[0].reset();

}

function validaForm(obj) {
    eval('json = ' + obj.json + ';');
    var ret = '';
    $.each(json, function (i, o) {
        label = 'field "' + $('label[for="' + i + '"]').html() + '" ';
        if (label == undefined) {
            label = 'field "' + $('#"' + i + '"').attr('id') + '" ';

        }
        if (o.isEmpty != undefined) {
            ret += 'The ' + label + ' should be informed.';
        } else if (o.notAlnum != undefined) {
            ret += 'The ' + label + ' can\'t have alphanumeric values.';
        } else if (o.stringLengthTooLong != undefined) {
            ret += 'Number of characters exceeded for the ' + label + '.';
        } else if (o.stringLengthTooShort != undefined) {
            ret += 'Number of characters too short for the ' + label + '.';
        }
        ret += '<br/>';
        $('#' + i).css('outline', '1px solid red');

    });
    setAlert('Check these fields', ret, 300, 180);
}

$(document).ready(function (p) {

//    $('.page-container ').append('<div id="memory-usage" class="memory-usage">');
    /**
     * função que verifica o tamanho maximo de caracteres no textarea
     */
    $("body").on("keyup", "[maxlength]", function () {
        var maxLength = $(this).attr('maxlength');
        var id = $(this).attr('id');
        var length = $(this).val().length;
        var length = maxLength - length;
        $('#chars' + id + '').text(length);
    });

    /**
     * remove modal from DOM after it is hidden
     */
    $('body').on('hidden.bs.modal', ".modal", function () {
        $(this).remove();
        reativaBtnClicado();
    });
    
    $("body").on('change', '.btn-file :file', function () {
        var input = $(this),
                numFiles = input.get(0).files ? input.get(0).files.length : 1,
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    $("body").on("focusin", ".datepicker", function () {
        times = $(this).attr('data-times-focused');
        if (typeof times == 'undefined') {
            $(this).datepicker( );
            $(this).attr('data-times-focused', '1');

        }
    });

    $("body").delegate("change", "[data-alternative-field]", function () {
        aternativeField = $(this).attr('data-alternative-field');
        valor = $(this).val( );
        $('#' + aternativeField).datepicker('update', valor);
    });


//    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
//        "date-br-pre": function (a) {
//            if (a == null || a == "") {
//                return 0;
//            }
//            var brDataEHora = a.split(' ');
//            var brDatea = brDataEHora[0].split('/');
////            console.log(brDatea[2] + brDatea[1] + brDatea[0]);
//            return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
//        },
//        "date-br-asc": function (a, b) {
//            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
//        },
//        "date-br-desc": function (a, b) {
//            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
//        }
//    });

    $('.btn-file').on('fileselect', ':file', function (event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' arquivos selecionados' : label;

        if (input.length) {
            input.val(log);
        } else {
            if (log)
                alert(log);
        }

    });
    /**
     * cancela todos os submits dos fomulario
     */
// $('body').on('submit','form', function(){
//	 return false;
// });
//    $('body').on("submit","form", function (event) {
//        event.preventDefault();
//    });

//    $('form').bind('submit', function (e) {
//        e.preventDefault();
//    });
//    $("select[select2]").select2({width: '100%', selectOnClose: true});




//    $("select[data-select2-ajaxload]").select2({width: '100%', selectOnClose: true,
//        ajax: {
//            url: function (params) {
//                return cBaseUrl + $(this).attr('data-select2-ajaxload') + "/" + $(this).attr('id') + "change/controlValue/";
//            },
//            dataType: 'json',
//            delay: 250,
//            data: function (params) {
//                return params.term;
////                return {
////                    q: params.term, // search term
////                    page: params.page
////                };
//            },
//            processResults: function (data, params) {
//
//                return {
//                    results: data
//                };
//            },
//            cache: true
//        }
//        , placeholder: ''
//        , allowClear: true
//        , minimumInputLength: 3
//    });
//    $("select[select2]").attr('data-times-focused', '1');
//
//    $('.select2-selection').on('focus', function () {
//
//        id = $(this).attr('aria-labelledby');
//        if (typeof id !== 'undefined') {
//            id = id.split("-");
//            $('#' + id[1]).select2('open');
//        }
//    });

    marcaObrig();

    /**
     * função usada nos grids para marcar e desmarcar todos os checkbox
     */
    $('input[id *= "chklstTodos"]').on('click', function () {
        var col = $('input[col=' + $(this).attr('col') + ']');
        if ($(this).attr('checked')) {
            $.each(col, function (i, obj) {
                obj.checked = true;
            });
        } else {
            $.each(col, function (i, obj) {
                obj.checked = false;
            });
        }
    });
    $('*[event*="load"]').each(function () {
        ajaxRequest($(this), 'load');
    });

    var test = function (a) {
        ajaxRequest(a, 'load');
    };
    $('form[data-request-on-form-create="1"]').each(function () {
        delay = $(this).attr('data-request-on-form-create-delay');
        if (delay != '') {
            setTimeout(test, delay, $(this));
        } else {
            ajaxRequest($(this), 'load');
        }
    });
//    setTimeout(test, 500, "works");



    $('body').on('blur', '*[event*="blur"]', function () {
        ajaxRequest($(this), 'blur');
    });
    $('body').on('change', '*[event*="change"]', function () {
        ajaxRequest($(this), 'change');
    });
    $('body').on('click', '[event*="click"]', function (e) {
        ajaxRequest($(this), 'click');
    });
    $('body').on('dblclick', '*[event*="dblclik"]', function () {
        ajaxRequest($(this), 'dblclick');
    });
    $('body').on('focus', '*[event*="focus"]', function () {
        ajaxRequest($(this), 'focus');
    });
    $('body').on('hover', '*[event*="hover"]', function () {
        ajaxRequest($(this), 'hover');
    });
    $('body').on('focusout', '*[event*="out"]', function () {
        ajaxRequest($(this), 'focusout');
    });
    $('body').on('keydown', '*[event*="keydown"]', function () {
        ajaxRequest($(this), 'keydown');
    });
    $('body').on('keypress', '*[event*="keypress"]', function () {
        ajaxRequest($(this), 'keypress');
    });
    $('body').on('keyup', '*[event*="keyup"]', function () {
        ajaxRequest($(this), 'keyup');
    });
    $('body').on('mousedown', '*[event*="mousedown"]', function () {
        ajaxRequest($(this), 'mousedown');
    });
    $('body').on('mousemove', '*[event*="mousemove"]', function () {
        ajaxRequest($(this), 'mousemove');
    });
    $('body').on('mouseout', '*[event*="mouseout"]', function () {
        ajaxRequest($(this), 'mouseout');
    });
    $('body').on('mouseover', '*[event*="mouseover"]', function () {
        ajaxRequest($(this), 'mouseover');
    });
    $('body').on('mouseup', '*[event*="mouseup"]', function () {
        ajaxRequest($(this), 'mouseup');
    });
    $('body').on('resize', '*[event*="resize"]', function () {
        ajaxRequest($(this), 'resize');
    });
    $('body').on('scroll', '*[event*="scroll"]', function () {
        ajaxRequest($(this), 'scroll');
    });
    $('body').on('select', '*[event*="select"]', function () {
        ajaxRequest($(this), 'select');
    });
    $('body').on('submit', '*[event*="submit"]', function () {
        ajaxRequest($(this), 'submit');
    });
    $('body').on('unload', '*[event*="unload"]', function () {
        ajaxRequest($(this), 'unload');
    });
    $('body').on('click', '*[updateGrid]', function () {
        eval('data = {"actions": [{"action":"UPDATEGRID", "id":"' + $(this).attr('updateGrid') + '"}]}');
        returnRequest(data);
    });
    $('body').on('click', '*[updateDataTables]', function () {
        eval('data = {"actions": [{"action":"UPDATEDATATABLES", "id":"' + $(this).attr('updateDataTables') + '", "sendFormValues":"' + $(this).attr('sendFormValues') + '"}]}');
        returnRequest(data);
    });
    /**
     * usado o keydown e o keyup pois alguns navegadores no keydown o keycode do
     * enter não existe (ex: IE).
     *
     * e feito este if para não haver mais de uma requisição ajax no firefox
     */
    $('body').on('keydown', '*[hotkeys]', function (e) {
        if (e.keyCode != 13) {
            hotKeys(e, $(this));
        }
        if (pressedKey) {
            return false;
        }
    });
    $('body').on('keyup', '*[hotkeys]', function (e) {
        if (e.keyCode == 13) {
            hotKeys(e, $(this));
        }
        if (pressedKey) {
            return false;
        }
        return false;
    });


    $('body').on('keyup', '*[hotkeys]', function (e) {
        // Quando uma tecla for liberada verifica se o CTRL para notificar
        // que CTRL não está pressionado
        if (e.keyCode == 9 || e.keyCode == 13 || e.keyCode == 16 || e.keyCode == 17) {
            pressedKey = false;
        }
    });

    $('body').on('blur', '.datepicker', function () {
        var data1 = $(this).val();
        data1 = data1.split('/');
        if (data1[2].length == 2) {
            data1[2] = '20' + data1[2];
        } else
        if (data1[2].length == 3) {
            alert("A data digitada tem um erro no ano! " + data1.join('/'));
        }
        $(this).val(data1.join('/'));
    });

});

/**
 * converte os dados do formulario para nome/valor no foramto json ex: {'nome' :
 * 'Ismael Sleifer'}
 */
function serializeDataFormJson(id) {
    var data = '{';
    var sep = '';
    var campo = '';
    var campos = $('#' + id).serialize().split('&');
    for (i = 0; i < campos.length; i++) {
        campo = campos[i].split('=');
        data += sep + "'" + campo[0] + "':'" + campo[1] + "'";
        sep = ', ';
    }
    data += '}';
    return data;
}
var positionMsgAlert = 49;
var waitingTime = 0;
function returnRequest(data) {
    if (data == null) {
        return false;
    }
    $.each(data.actions, function (i, obj) {
        if (obj.action == 'ALERT') {
            setAlert(obj.title, obj.msg, obj.width, obj.height);
        } else if (obj.action == 'COMMAND') {
            eval(obj.command);
        } else if (obj.action == 'SHOW') {
            $('#' + obj.id).show(obj.speed);
        } else if (obj.action == 'HIDE') {
            $('#' + obj.id).hide(obj.speed);
        } else if (obj.action == 'REMOVE') {
            $('#' + obj.id).remove();
        } else if (obj.action == 'REMOVEWINDOW') {
            $('#' + obj.id).modal("hide").data('bs.modal', null);
        } else if (obj.action == 'CLOSEWINDOW') {
            window.close()
        } else if (obj.action == 'NEWWINDOW') {
            $('body').append(obj.html);
            $('#' + obj.id).modal();
            $(document).on('hidden', '#' + obj.id, function () {
                $(this).remove();
                reativaBtnClicado();
            });
        } else if (obj.action == 'CSS') {
            $('#' + obj.id).css(obj.prop, obj.val);
        } else if (obj.action == 'HTML') {
            $('#' + obj.id).html(obj.val);
        } else if (obj.action == 'HTMLCLASS') {
            $.each($('.' + obj.class), function () {
                $(this).html(obj.val);
            });

        } else if (obj.action == 'SETCLASS') {
            $('#' + obj.id).attr('class', obj.class);
        } else if (obj.action == 'RESETFORM') {
            resetForm(obj);
        } else if (obj.action == 'SETBROWSERURL') {
            window.location = obj.val;
        } else if (obj.action == 'UPDATEGRID') {
            $('#' + obj.id).flexReload();
        } else if (obj.action == 'TABFOCUS') {
//            $('#' + obj.id) ;
            activateTab($('#' + obj.id));
        } else if (obj.action == 'UPDATEDATATABLES') {
            updateDataTable(obj);
        } else if (obj.action == 'ADDDATAGRID') {
            eval('var data = ' + unescape(obj.data));
            $('#' + obj.id).flexAddData(data);
        } else if (obj.action == 'SETATTRIB') {
            $('#' + obj.id).attr(obj.attrib, obj.val);
        } else if (obj.action == 'MSG') {
            addToolTip(obj);
        } else if (obj.action == 'MSGALERT') {
            $('body').pgNotification({style: 'flip', message: "<strong>" + obj.title + "</strong> <br> <span>" + obj.msg + "</span>"}).show();
        } else if (obj.action == 'ADDSCRIPT') {
            var script = $('script[src*=' + obj.script + ']');
            $('body').append(obj.script);
        } else if (obj.action == 'EXECUTEAJAXREQUEST') {
            ajaxRequest($('#' + obj.id), obj.event, obj.params);
        } else if (obj.action == 'SETDATAFORM') {
            setDataForm(obj);
        } else if (obj.action == 'VALIDAFORM') {
            validaForm(obj);
        } else if (obj.action == 'REMOVEATTR') {
            $('#' + obj.id).removeAttr(obj.attr);
        } else if (obj.action == 'NEWTAB') {
            var popup = window.open(obj.url, '_blank')
            popupBlockerChecker.check(popup);
        } else if (obj.action == 'FOCUS') {
            $('#' + obj.id).focus();
        } else if (obj.action == 'SENDNOTIFICATION') {
            sendNotification(obj.title, obj.body, obj.img, obj.link, obj.target);
        } else if (obj.action == 'ADDLOADSCRIPT') {
            $.getScript(obj.script, function (data, textStatus, jqxhr) {
                console.log("Load of '" + obj.script + "' was performed.");
//                console.log(data); // Data returned
//                console.log(textStatus); // Success
//                console.log(jqxhr.status); // 200
            }).done(function (script, textStatus) {
                eval(obj.callback);
                console.log("Callback: " + obj.callback);
                console.log('.done: ' + textStatus);
            }).fail(function (jqxhr, settings, exception) {
                $("div.log").text("Triggered ajaxError handler to '" + obj.script + "'.");
            });
        }
    });
    marcaObrig();

    reativaBtnClicado();


}
function sendNotification(theTitle, theBody, theIcon, link, target) {
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    // Let's check whether notification permissions have already been granted
    else if (Notification.permission === "granted") {
        // If it's okay let's create a notification
        //sendNotification('Obrigado!!', 'Você ativou as Notificações do nosso sistema. Vamos usalas com cuidado e sabedoria', 'http://www.criarmeme.com.br/i/thumbs-up.jpg');
        if (theIcon === undefined || theIcon === '') {
            theIcon = cBaseUrl + "Public/Images/favicon.png";
        }
        var options = {
            body: theBody,
            icon: theIcon
//            timestamp: '10h',
//            vibrate: [200, 100, 200],
//            noscreen: true //deicahr como false quando quiser que acenda a tela do celular
        };
        var n = new Notification(theTitle, options);
        if (link !== undefined && link !== '') {
            if (target === '') {
                target = '_blank'
            }
            n.onclick = function (event) {
//                event.preventDefault(); // prevent the browser from focusing the Notification's tab
                window.open(link, target);
            }
        }
    }

    // Otherwise, we need to ask the user for permission
    else if (Notification.permission !== 'granted') {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                sendNotification('Obrigado!!', 'Você ativou as Notificações! Usaremos esse poder com cuidado e sabedoria', 'http://www.criarmeme.com.br/i/thumbs-up.jpg');
                sendNotification(theTitle, theBody, theIcon);
            }
        });
    }

    // At last, if the user has denied notifications, and you
    // want to be respectful there is no need to bother them any more.
}

/**
 * re-habilita o botão que foi clicado para realizar essa request.
 */
function reativaBtnClicado() {
    $('[clicked]').removeAttr('disabled');
    $('[clicked]').removeAttr('clicked');
}
/**
 * desabilita o botão clicado para não ser clicado novamente, antes do retorno da requisição
 */
function desativaBtnClicado(obj) {
    //desabilita o botão clicado para não ser clicado novamente, antes do retorno da requisição
    obj.attr('disabled', 'disabled');
    obj.attr('clicked', 'clicked'); // adiciona esse atributo só para saber qual botão habilitar novamente no retorno da request
}
function updateDataTable(obj) {

    eval("var table" + obj.id + " =  $('#" + obj.id + "').dataTable();");
//    eval('table' + obj.id + '.api().ajax.reload();');
    eval('var urlOld = table' + obj.id + '.api().ajax.url();'); // pega a url, utilizada para fazer a request, atual do grid e guarda para recolocar nele depois

    params = '';
//    console.log('obj.params=' + obj.params);
    if (obj.params != undefined) {
        params = obj.params + '/'; // pega os parametros que vieram do servidor para enviar na atualização do grid
    }
//    console.log('params=' + params);
//        //-------------------------------------------------
//    console.log(obj.sendFormValues);
    if (obj.sendFormValues != 'undefined') {

//        params = getParamsFromForm(obj.id);
//        params = 'params/' + base64_encode(params);

    }

// ---------------------------------------------------

    eval('table' + obj.id + '.api().ajax.url("' + urlOld + '/' + params + '").load();'); //coloca a url antiga concatenada com os parametros vindos do servidor
    eval('table' + obj.id + '.api().ajax.url("' + urlOld + '");'); // coloca o valor antigo da url para que na próxima atualização ele pege a url original, novamente
}

function getParamsFromForm($id) {
    idForm = '';
    // procura pelo formulário pai do item clicado
    parent = $('#' + $id).parent();
    count = 0;
    while (parent !== undefined && parent.prop('tagName') !== 'HTML' && count < 50) {
//        console.log(parent);
        if (parent.prop('tagName') === 'FORM') {
            idForm = parent.attr('id');
            break;
        }
        parent = parent.parent();
        count = count + 1;
    }
    params = '';
    enctype = $('#' + idForm).attr('enctype');
    if (enctype != 'multipart/form-data') {
//            reativaBtnClicado();
//            console.log(idForm);
        params += '' + $('#' + idForm).serialize();
//        console.log(params);

        $('[sendthisvalue]').each(function () {
            params += '&' + $(this).attr('name') + '=' + encodeURIComponent($(this).html());
        });
//            console.log(params);

//        params = params.replace(/\=/g, '/');
////            console.log(params);
//        params = params.replace(/\&/g, '/');
//        console.log(params);

    }
    return params;
}
function base64_encode(stringToEncode) { // eslint-disable-line camelcase
    //  discuss at: http://locutus.io/php/base64_encode/
    // original by: Tyler Akins (http://rumkin.com)
    // improved by: Bayron Guevara
    // improved by: Thunder.m
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // improved by: Kevin van Zonneveld (http://kvz.io)
    // improved by: Rafał Kukawski (http://blog.kukawski.pl)
    // bugfixed by: Pellentesque Malesuada
    //   example 1: base64_encode('Kevin van Zonneveld')
    //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
    //   example 2: base64_encode('a')
    //   returns 2: 'YQ=='
    //   example 3: base64_encode('✓ à la mode')
    //   returns 3: '4pyTIMOgIGxhIG1vZGU='

    if (typeof window !== 'undefined') {
        if (typeof window.btoa !== 'undefined') {
            return window.btoa(unescape(encodeURIComponent(stringToEncode)))
        }
    } else {
        return new Buffer(stringToEncode).toString('base64')
    }

    var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
    var o1
    var o2
    var o3
    var h1
    var h2
    var h3
    var h4
    var bits
    var i = 0
    var ac = 0
    var enc = ''
    var tmpArr = []

    if (!stringToEncode) {
        return stringToEncode
    }

    stringToEncode = unescape(encodeURIComponent(stringToEncode))

    do {
        // pack three octets into four hexets
        o1 = stringToEncode.charCodeAt(i++)
        o2 = stringToEncode.charCodeAt(i++)
        o3 = stringToEncode.charCodeAt(i++)

        bits = o1 << 16 | o2 << 8 | o3

        h1 = bits >> 18 & 0x3f
        h2 = bits >> 12 & 0x3f
        h3 = bits >> 6 & 0x3f
        h4 = bits & 0x3f

        // use hexets to index into b64, and append result to encoded string
        tmpArr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4)
    } while (i < stringToEncode.length)

    enc = tmpArr.join('')

    var r = stringToEncode.length % 3

    return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3)
}

var xhr;
/**
 *
 * @param {type} obj form, botao ou seja lá o que foi passado
 * @param {type} event [click|blur|...]
 * @param {type} parametros parametros a serem passados na request
 * @returns {Boolean}
 */
function ajaxRequest(obj, event, parametros) {
    idForm = '';
    // procura pelo formulário pai do item clicado
    parent = obj;
    count = 0;
    while (parent !== undefined && parent.prop('tagName') !== 'HTML' && count < 50) {
        if (parent.prop('tagName') === 'FORM') {
            idForm = parent.attr('id');
            break;
        }
        parent = parent.parent();
        count = count + 1;
    }
    id = obj.attr('id');

    //desabilita o botão clicado para não ser clicado novamente, antes do retorno da requisição
    desativaBtnClicado(obj);

    // se o botão deve validar se os campos obrigatórios foram preenchidos, ele entra aqui!
    if (obj.attr('validaObrig')) {
        var flag = '';
        if (idForm !== '') {
            //procura apenas nos campos de dentro do formulário onde o ele está.
            //Criado isso pois estava havendo conflito quando abria mais de uma janela de edição de um item
            camposVerificar = $('#' + idForm).find('*[obrig]');
        } else {
            //vai procurar em todos os campos do da tela
            camposVerificar = $('*[obrig]');
        }
        camposVerificar.each(function () {
            if ($(this).val() === '') {
                $(this).css('outline', '1px solid red');
                id = $(this).attr('id');
                //SELECT 2
                $("span[aria-labelledby='select2-" + id + "-container']").css('outline', '1px solid red')
//                var pos = $(this).position();
//                var height = $(this).height();
//                $(this).after('<div class="tooltip-require" id="tooltip-require-' + $(this).attr('id') + '" style="top:' + (pos.top + 33) + 'px;left:' + (pos.left) + 'px; ">Preencha esse campo, por favor.</div>');
                flag = true;
            } else {
                $(this).css('outline', '');
                id = $(this).attr('id');
                $("span[aria-labelledby='select2-" + id + "-container']").css('outline', '')
                $('#tooltip-require-' + $(this).attr('id')).hide();
            }
        });

        if (flag) {
            setAlert('Campos Obrigatórios', 'Os campos em vermelho devem ser preenchidos', 200, 200);
            reativaBtnClicado();
            return false;
        }
    }
    //se tiver o atributo msg é pq deve ser abeta a janela de confirmação.
    if (obj.attr('msg')) {
        setConfirm('Confirmation', obj.attr('msg'), 300, 240, obj, event);
        return false;
    }

    //verifica se o atributo url estiver preenchido no botao, ele deve chamar essa action,
    //não a do formulário em que o botao clicado está.
    if (obj.attr('url')) {
        url = obj.attr('url');
    } else if (idForm !== '') {
        url = $('#' + idForm).attr('action');
    } else {
        alert("Você deve setar uma action para esse elemento!" + "\n\n" + "O idForm está vazio e o attr('url') do elemento também! ");
    }

    params = '&' + obj.attr('params');
    if (params == '&undefined') {
        params = '';
    }
    // pega os parametros do formulário
    datapostparams = $('#' + idForm).attr('data-post-params');
    console.log("datapostparams = " + datapostparams);
    if (datapostparams != 'undefined') {
        params += '&' + datapostparams;

    }
    if (parametros !== undefined) {
        for (var k in parametros) {
            if (typeof parametros[k] !== 'function') {
                params += '&' + k + '=' + parametros[k];
            }
        }
    }

    params += '&ajax=true';

    if (event == 'change' || event == 'blur' || event == 'focus' || event == 'focusout' || event == 'keyup') {
        var field = $('#' + idForm + ' #' + obj.attr('id'));
        if (field.attr('type') === 'checkbox') {
            if (field.prop('checked')) {
                params += '&controlValue=' + field.val();
            }
        } else {
            params += '&controlValue=' + field.val();
        }
    }

    if (obj.attr('act')) {
        controlName = obj.attr('act');
    } else {
        controlName = obj.attr('name');
    }

    sendFormFields = obj.attr('sendFormFields');
    functionResultName = obj.attr('functionResultName');

    senha = '';

    if (functionResultName == undefined || functionResultName == '') {
        functionResultName = 'returnRequest';
    }

    if (sendFormFields) {
        $('[data-editor^="tinymce"]').each(function () {
            console.log($(this));
            $('#' + $(this).attr('id')).html(tinymce.get($(this).attr('id')).getContent());
        });
    }

    enctype = $('#' + idForm).attr('enctype');
    if (sendFormFields && enctype != 'multipart/form-data') {

        params += '&' + $('#' + idForm).serialize();
        $('[sendthisvalue]').each(function () {
            params += '&' + $(this).attr('name') + '=' + encodeURIComponent($(this).html());
        });


    }
    var name;
    $('input[type="password"]').each(function () {
        if ($(this).val() != '' && $(this).attr('cript') != undefined) {
            p = params.split('&');
            params = '';
            sep = '';
            for (i = 1; i < p.length; i++) {
                name = p[i].split('=');
                if ($(this).attr('id') !== name[0]) {
                    params += sep + p[i];
                }
                sep = '&';
            }
            params += '&' + $(this).attr('id') + '=' + md5($(this).val());
        }
    });

    $('#' + id).ajaxStart(function () {
        $('#ajaxStart').show();
    });


    if (enctype == 'multipart/form-data' && sendFormFields) {
        var formElement = document.querySelector('#' + idForm);
        var formData = new FormData(formElement);

        parametros = params.split("&");
        for (i = 0; i < parametros.length; i++) {
            valor = parametros[i].split("=");
            formData.append(valor[0], valor[1]);
        }
        $.ajax({
            url: cBaseUrl + url + '/' + controlName + event,
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function (returnData) {
                eval(functionResultName + '(returnData);');
                $('#ajaxStart').hide();
            },
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
//                        console.log('Enviando Arquivo')/* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    } else {

        //alert(cBaseUrl);
        xhr = $.ajax({
            type: 'POST',
            url: cBaseUrl + url + '/' + controlName + event,
            data: params,
            dataType: 'json',
            success: function (returnData) {
                eval(functionResultName + '(returnData);');
                $('#ajaxStart').hide();
            }
        });
    }
}
function abortAjax() {
    if (xhr) {
        xhr.abort();
    }
}


/**
 * padrão da função
 *
 * letra,id,evento ex: 's,btnsalvar,click'
 */
function hotKeys(e, obj) {
    var keys = new Array();
    keys['TAB'] = '9';
    keys['ENTER'] = '13';
    keys['SHIFT'] = '16';
    keys['CTRL'] = '17';

    var atalhos = obj.attr('hotkeys').split('|');
    var params = '';

    $.each(atalhos, function (i, atalho) {

        params = atalho.split(',');
        comb = params[0].split('+');

        if (comb.length == 2) {
            tecla = jQuery.trim(comb[1].toUpperCase());
            val = tecla.charCodeAt(0);

            if (e.keyCode == keys[jQuery.trim(comb[0]).toUpperCase()]) {
                pressedKey = true;
                return false;
            }

            if (e.keyCode == val && pressedKey == true) {
                // Aqui vai o código e chamadas de funções para o ctrl+s
                ajaxRequest($('#' + jQuery.trim(params[1])), jQuery.trim(params[2]));
                return false;
            }

        } else {
            tecla = jQuery.trim(comb[0].toUpperCase());
            val = tecla.charCodeAt(0);

            if (!isNaN(tecla.charCodeAt(1))) {
                val = '';
            }
            if ($('#' + jQuery.trim(params[1])).attr('id') != undefined) {
                if (e.keyCode == val && pressedKey == false) {
                    // Aqui vai o código e chamadas de funções para o ctrl+s
                    ajaxRequest($('#' + jQuery.trim(params[1])), jQuery.trim(params[2]));
                    return false;
                } else if (e.keyCode == keys[tecla]) {
                    ajaxRequest($('#' + jQuery.trim(params[1])), jQuery.trim(params[2]));
                    return false;
                }
            } else {
                alert('O id "' + params[1] + '" passado não foi encontrado.');
            }
        }
    });
}

var popupBlockerChecker = {
    check: function (popup_window) {
        var _scope = this;
        if (popup_window) {
            if (/chrome/.test(navigator.userAgent.toLowerCase())) {
                setTimeout(function () {
                    _scope._is_popup_blocked(_scope, popup_window);
                }, 200);
            } else {
                popup_window.onload = function () {
                    _scope._is_popup_blocked(_scope, popup_window);
                };
            }
        } else {
            _scope._displayError();
        }
    },
    _is_popup_blocked: function (scope, popup_window) {
        if ((popup_window.innerHeight > 0) == false) {
            scope._displayError();
        }
    },
    _displayError: function () {
//        alert("Popup Blocker is enabled! Please add this site to your exception list.");
        msg = ("O bloqueador de Popup está ativo! Por favor, adicione este site às exceções.");
        var chrome = '', ff = '';
        if (/chrome/.test(navigator.userAgent.toLowerCase())) {
            chrome = '<br><br>Como ativar pop-ups no <strong>Chrome</strong> - <a href="#none" onclick="$(' + "'#chrome'" + ').slideDown()">Abrir</a>' +
                    '<div id="chrome" style="display:none"> <br> 1 - No computador, abra o Google Chrome.' +
                    '<br> 2 - No canto superior direito, clique no ícone exibido: de menu Menu  <img src="//storage.googleapis.com/support-kms-prod/CD148BFC3EE3B5328DAFE08E2B6AA95B73B7" width="18" height="18" alt="Menu" title="Menu">.' +
                    '<br> 3 - Clique em Configurações.' +
                    '<br> 4 - Na parte inferior, clique em Mostrar configurações avançadas.' +
                    '<br> 5 - Em "Privacidade", clique em Configurações de conteúdo.' +
                    '<br> 6 - Em "Pop-ups", clique em "Gerenciar exceções...":' +
                    '<br> 7 - Encontre o endereço "' + HTTP_HOST + '" e selecione "Permitir" à direita do endereço.</div>';
        } else {
            ff = '<br><br>Como ativar pop-ups no <strong>Mozila Firefox</strong> - <a href="#none" onclick="$(' + "'#ff'" + ').slideDown()">Abrir</a>' +
                    '<div id="ff" style="display:none">' +
                    '<img title="" src="//support.cdn.mozilla.net/media/uploads/gallery/images/2014-03-20-11-54-37-8dc24a.png" data-original-src="//support.cdn.mozilla.net/media/uploads/gallery/images/2014-03-20-11-54-37-8dc24a.png" class="wiki-image frameless" style="width:100%;height:110px" alt="Popup1 29 Win">' +
                    ' <br> 1 - Clique no botão Opções da barra de informações ou no ícone da barra de endereço' +
                    '<br> 2 - selecione a seguintes opções:' +
                    '<br> 3 - Permitir pop-ups de [ ' + HTTP_HOST + ' ]</div>';
        }
        setAlert('Popup Bloqueado', msg + chrome + ff, 700, 500);
    }


}
/// ============ Ações nas abas ==========
function nextTab(elem) {
    $(elem + ' li.active')
            .next()
            .find('a[data-toggle="tab"]')
            .click();
}
function prevTab(elem) {
    $(elem + ' li.active')
            .prev()
            .find('a[data-toggle="tab"]')
            .click();
}
function activateTab(elem) {
    $(elem)
            .find('a[data-toggle="tab"]')
            .click();
}
