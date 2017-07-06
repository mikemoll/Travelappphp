<?php

require_once 'Zend/View/Helper/FormElement.php';

class Zend_View_Helper_FormDataTables extends Zend_View_Helper_FormElement {

    public function formDataTables($name, $value = null, $attribs = null) {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, id, value, attribs, options, listsep, disable, escape

        $xhtml = '<div class="table-responsive">
                                <table class="table table-striped  table-hover" id="' . $id . '">
                                    ' . $this->renderThead($id, $attribs['colModel'], $attribs['buttons']);

        //ele só monta o corpo do grid, se não tiver o atributo URL, pois quer dizer que ele vai ser carregado via ajax
        if ($attribs['url'] == '') {
            $xhtml .= $this->renderTbody($attribs['rowns'], $attribs['colModel'], $attribs['buttons']);
        }
//        $xhtml .= $this->renderTfoot($id, $attribs['colModel'], $attribs['buttons']);
        $xhtml .= '  </table>
                            </div>';

        //pega as opções do grid
        $autoUpdateInterval = $attribs['autoUpdateInterval'];
        $autoUpdateDelay = $attribs['autoUpdateDelay'];
        $options = $this->getOptions($id, $attribs);
        $xhtml .= "
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
                <script>
                $(document).ready(function() {
                    var table$id =  $('#$id').dataTable($options);"
                . $this->getScriptButons($attribs['buttons']) . "
                   ";
        if ($autoUpdateInterval != '') {
            $xhtml .= "
                            console.log('O elemento [$id] atualiza  a cada {$autoUpdateInterval}ms um atrazo de {$autoUpdateDelay}ms.');
                            console.log('Action do grid: {$attribs['url']}');
                    setTimeout(function () {
                            var grid1 = {id: '$id' };
                            setInterval(function () {
                                updateDataTable(grid1);
                            }, $autoUpdateInterval);// Ex: de 60 em 60 segundos
                        }, $autoUpdateDelay); // Ex:120 segundos depois de carregado
                        ";
        }
        $xhtml .= " });
                </script>";


        return $xhtml;
    }

    private function getOptions($id, $attribs) {
        $options = '{';
        $options .= '"sDom": ' . "'" . '<"top"f>rt<"bottom"pli><"clear">' . "',";
        if ($attribs['url']) {
            $options .= '"ajax": {
                                    "url": "' . $attribs['url'] . '",
                                        "type": "POST" ,
                                        "data": function ( d ) {
                                        var params = "";';
            if ($attribs['sendFormValues']) {
                $options .= '             params = getParamsFromForm("' . $id . '");';
            }
            $options .= '               return $("#' . $id . '").serialize()+"&idGrid=' . $id . '&" + params; }

                                    },';
        }

        // ------- arrumando as coluna que são do tipo data para serem ordenadas certo! -----
        foreach ($attribs['colModel'] as $key => $value) {
            if (get_class($value) == 'Ui_Element_DataTables_Column_Date') {
                $numColDate[] = $key;
            }
            if ($value->getWidth() == 'hidden' or $value->getWidth() == '0' or ! $value->getVisible()) {
                $numColHidden[] = $key;
            }
        }
        if (count($numColDate) > 0 or count($numColHidden) > 0) {
            $options .= "
                columnDefs: [";
            if (count($numColDate) > 0) {
                $options .= " { targets: [" . implode(',', $numColDate) . "],  type: 'date-br'},";
            }
            if (count($numColHidden) > 0) {
                $options .= " { targets: [" . implode(',', $numColHidden) . "],  visible: false},";
            }
            $options .= "
                 ],
              ";
        }
        // ------- /end      Arrumando as coluna que são do tipo data para serem ordenadas certo! -----
        if ($attribs['sortName'] != '') {
            foreach ($attribs['colModel'] as $key => $value) {
                if ($value->getName() == $attribs['sortName']) {
                    $options .= '"order": [[ ' . $key . ' , "' . $attribs['sortOrder'] . '" ]],';
                }
            }
        }
        if ($attribs['height'] != '') {
            $options .= "
                scrollY: '{$attribs['height']}',
                scrollCollapse: true,
            ";
        }
        if ($attribs['searching'] == false) {
            $options .= "
                searching: false,
            ";
        }
//        if ($attribs['initialSort'] == false) {
//        $options .= "
//                bSort: false,
//            ";
//        }
        if ($attribs['ordering'] == false) {
            $options .= "
                ordering: false,
            ";
        }
        if ($attribs['paging'] == false) {
            $options .= "
                paging: false,
            ";
        }
        if ($attribs['StateSave'] == true) {
            $options .= "
                stateSave: true,
            ";
        }
        if ($attribs['lengthChange'] == false) {
            $options .= "
                lengthChange: false,
            ";
        }
        if ($attribs['info'] == false) {
            $options .= "
                info: false,
            ";
        }
//        $options .= '
//            "language": {
//                "sEmptyTable": "Nenhum registro encontrado",
//    "sInfo": "_START_ à _END_ de _TOTAL_ itens",
//    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
//    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
//    "sInfoPostFix": "",
//    "sInfoThousands": ".",
//    "sLengthMenu": "_MENU_ itens p/página",
//    "sLoadingRecords": "Carregando...",
//    "sProcessing": "Processando...",
//    "sZeroRecords": "Nenhum registro encontrado",
//    "sSearch": "Pesquisar",
//    "oPaginate": {
//        "sNext": "Próximo",
//        "sPrevious": "Anterior",
//        "sFirst": "Primeiro",
//        "sLast": "Último"
//    },
//    "oAria": {
//        "sSortAscending": ": Ordenar colunas de forma ascendente",
//        "sSortDescending": ": Ordenar colunas de forma descendente"
//    }
//            }
//        ';
        $options .= ' }';
        return $options;
    }

    private function renderThead($id, $cols, $buttons) {

        $thead .='  <thead>
                        <tr>';
        foreach ($cols as $column) {
            if ($column->getVisible()) {
                $thead .= '<th class="col-md-' . $column->getWidth() . '">' . $column->getTitle() . '</th>';
            }
        }

        // define a largura da coluna dos botões de ação.
        if (count($buttons) > 2) {
            $largColAcoes = 2;
        } else
        if (count($buttons) > 4) {
            $largColAcoes = 3;
        } else {
            $largColAcoes = 1;
        }
        if (count($buttons) > 0) {
            $thead .= '<th class="col-xs-1"></th>';
//            $thead .= '<th style="width:' . (count($buttons) * 32) . 'px"></th>';
        }
        $thead .='  </tr>
                    </thead>
                ';

        return($thead);
    }

    private function renderTfoot($id, $cols, $buttons) {

        $thead .='<tfoot>
    <tr>';
        foreach ($cols as $column) {
            if ($column->getVisible()) {
                $thead .= '<th class="col-md-' . $column->getWidth() . '">' . $column->getTitle() . '</th>';
            }
        }

        // define a largura da coluna dos botões de ação.
        if (count($buttons) > 2) {
            $largColAcoes = 2;
        } else
        if (count($buttons) > 4) {
            $largColAcoes = 3;
        } else {
            $largColAcoes = 1;
        }
        if (count($buttons) > 0) {
            $thead .= '<th  >Ações</th>';
        }
        $thead .='  </tr>
</tfoot>
';

        return($thead);
    }

    private function renderTbody($rowns, $cols, $buttons) {

        $tbody .='<tbody>';
        if (count($rowns) > 0) {
            foreach ($rowns as $rown) {
                $tbody .=' <tr>';
                foreach ($cols as $column) {
                    if ($column->getVisible()) {
                        $tbody .= '<td class="text-' . $column->getAlign() . '">' . $column->render($rown->getID(), $rown) . '</td>';
                    }
                }
                if (count($buttons) > 0) {
                    // Adiciona a Coluna de ações (Excluir, editar...)
                    $tbody .= '<td>';
                    $tbody .= $this->renderButtons($buttons, $rown->getID());
                    $tbody .= '</td>';
                }
                $tbody .=' </tr>';
            }
        }
        $tbody .='</tbody>';

        return($tbody);
    }

    private function renderButtons($buttons, $idRown) {
        if (count($buttons) > 0) {
            $return .="<div class='btn-group btn-group-sm btn-group-justified' style='width:" . (count($buttons) * 32) . "px'>";
            foreach ($buttons as $button) {
                $return .= $button->render($idRown);
            }
            $return .=' </div> ';

            return $return;
        }
    }

    private function renderSearch($searchs) {
        $separator = '';
        $procura = '[';
        if (isset($searchs)) {

            foreach ($searchs as $search) {
                $procura .= $separator . $search->render();
                $separator = ',';
            }
        }
        $procura .= ']';


        return $procura;
    }

    public function getScriptButons($buttons) {

        if (count($buttons) > 0) {
            foreach ($buttons as $button) {
                $scripts .= "\n" . $button->getScript();
            }

            return ($scripts);
        }
    }

}
