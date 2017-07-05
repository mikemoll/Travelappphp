<?php

class Funcoes {

    /**
     * Exporta uma relatorio para o excel
     * o parametro passado deve ser uma tabela com os dados
     */
    public static function exportToExcel($data, $fileName = 'relatorio') {
        header('Content-type: application/vnd.ms-excel; charset=utf-8');
        header('Content-type: application/force-download');
        header("Content-Disposition: attachment; filename=$fileName.xls");
        header('Pragma: no-cache');
        echo $data;
        exit;
    }

    function LogSystem($Msg) {
        
    }

    static function geraTabelaFromArray($array) {
        $html.='<table class="table" border="1">';
        foreach ($array as $row) {
            $html.='<tr>';
            $html.="<th># </th>";
            foreach ($row as $key => $value) {
                $html.="<th>$key </th>";
            }
            break;
        }
        foreach ($array as $key => $row) {
            $html.='<tr>';
            $html.="<td>$key</td>";
            if (is_object($row)) {
                return 'geraTabelaFromArray() - Tem que ser um array! [$Obj->readLst("array");]';
//                foreach ($row as $key => $value) {
//                    $html.="<th>$row->$key </th>";
//                }
            } else {
                $html.='<td>' . implode('</td><td>', $row);
            }
        }
        $html.='</table>';
        return $html;
    }

}
