<?php

/**
 * Modelo da classe Usuario
 * @filesource
 * @author 		Leonardo Danieli
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class Arquivo extends Db_Table {

    protected $_name = 'arquivo';
    public $_primary = 'id_arquivo';
    public $_log_ativo = false;

    public function setDataFromRequest($post) {
        $this->setDescricao($post->descricao);
        $this->setLink($post->link);
//		$this->setAtivo($post->ativo);
    }

    /**
     *
     * @param string $dir
     * @param mix $filtros
     * @return array
     */
    static function dirToArray($dir, $filtros = false) {

        if (!is_array($filtros) and $filtros != false) {
            $filtrosLst[] = $filtros;
        } else {
            $filtrosLst = $filtros;
        }
        $result = array();

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value) {
            if (!in_array($value, array(".", ".."))) {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                    $result[$value] = self::dirToArray($dir . DIRECTORY_SEPARATOR . $value, $filtrosLst);
                } else {
                    if (is_array($filtrosLst)) {
                        $vai = false;
                        foreach ($filtrosLst as $filtro) {
                            if (strpos($value, '.' . $filtro) !== false) {
                                $vai = true;
                            }
                        }
                    } else {
                        $vai = true;
                    }
                    if ($vai) {
                        $result[$dir . DIRECTORY_SEPARATOR . $value] = $value;
                    }
                }
            }
        }

        return $result;
    }

    /** esse método retorna um html com as fotos do album
     * 
     * @author Leonardo Danieli <ismael@gmail.com>
     * @author Leonardo Danieli <leonardo@4coffee.com.br>
     * @param int $id_Owner id do dono das fotos
     * @param bool $todas se devem ser retornadas todas as fotos ou somente a primeira
     * @return type
     */
    static function getImagens($id_Owner, $todas = false) {
        $view = Zend_Registry::get('view');
        $arquivoLst = new Arquivo();
        $arquivoLst->where('id_owner', $id_Owner);
        if ($todas == false)
            $arquivoLst->where('principal', 'S');
        $arquivoLst->readLst();


        if ($todas == false and $arquivoLst->countItens() > 1) {
            $count = 1;
        } else {
            $count = $arquivoLst->countItens();
        }
        if ($arquivoLst->countItens() != 0) {
            for ($i = 0; $i < $count; $i++) {
                $Item = $arquivoLst->getItem($i);

                $album[$i]['id'] = $Item->getid();
                $album[$i]['titulo'] = $Item->getTitulo();
                $album[$i]['descricao'] = $Item->getDescricao();
                $album[$i]['imagem'] = PATH_PUBLIC . 'Arquivos/' . $Item->getid() . '_mini.' . $Item->getExt();
                $album[$i]['imagemG'] = PATH_PUBLIC . 'Arquivos/' . $Item->getid() . '.' . $Item->getExt();
            }
        } else {
            $album[0]['imagem'] = '';
        }

        $view->assign('editar', Usuario::verificaAcesso('PROC_CAD_ARQUIVOS', 'editar'));
        $view->assign('excluir', Usuario::verificaAcesso('PROC_CAD_ARQUIVOS', 'excluir'));
        $view->assign('albuns', $album);
        if (($todas == false)) {
            return $view->fetch('Albuns/umaFoto.tpl');
        } else
            return $view->fetch('Albuns/albuns.tpl');
    }

    static function getImagen($id_Owner, $larguraFotos = '300px') {
        $view = Zend_Registry::get('view');
        $arquivoLst = new Arquivo();
        $arquivoLst->where('id_owner', $id_Owner);
        $arquivoLst->where('principal', 'S');
        $arquivoLst->readLst();


        if ($todas == false and $arquivoLst->countItens() > 1) {
            $count = 1;
        } else {
            $count = $arquivoLst->countItens();
        }
        if ($arquivoLst->countItens() != 0) {
            for ($i = 0; $i < $count; $i++) {
                $Item = $arquivoLst->getItem($i);

                $album[$i]['id'] = $Item->getid();
                $album[$i]['titulo'] = $Item->getTitulo();
                $album[$i]['descricao'] = $Item->getDescricao();
                $album[$i]['imagem'] = PATH_PUBLIC . 'Arquivos/' . $Item->getid() . '_mini.' . $Item->getExt();
                $album[$i]['imagemG'] = PATH_PUBLIC . 'Arquivos/' . $Item->getid() . '.' . $Item->getExt();
            }
        } else {
            $album[0]['imagem'] = '';
        }

        $view->assign('albuns', $album);
        $view->assign('larguraFotos', $larguraFotos);
        if ($arquivoLst->countItens() <= 1) {
            return $view->fetch('Albuns/umaFotoGrande.tpl');
        } else
            return $view->fetch('Albuns/albuns.tpl');
    }

    public function excluir() {

        $this->setDeleted();
        $this->save();

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . PATH_PUBLIC . 'Arquivos/' . $this->getid() . '.' . $this->getExt())) {
            unlink($_SERVER['DOCUMENT_ROOT'] . PATH_PUBLIC . 'Arquivos/' . $this->getid() . '.' . $this->getExt());
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . PATH_PUBLIC . 'Arquivos/' . $this->getid() . '_mini.' . $this->getExt())) {
            unlink($_SERVER['DOCUMENT_ROOT'] . PATH_PUBLIC . 'Arquivos/' . $this->getid() . '_mini.' . $this->getExt());
        }
    }

    public function getExt() {
        return trim($this->a_ext);
    }

    /**
     * Retorna uma lista de imagens para colocar no banner
     * 
     * @param type $id_owner
     * @return string
     */
    static function getBanner($id_owner) {
//        $view = Zend_Registry::get('view');



        $lImagens = new Arquivo();
        $lImagens->where('id_owner', $id_owner);
        $lImagens->readLst();

        for ($i = 0; $i < $lImagens->countItens(); $i++) {
            $Item = $lImagens->getItem($i);

            $ret .= $sep . '["' . HTTP_REFERER . 'Public/Arquivos/' . $Item->getid() . '.' . $Item->getExt() . '", "' . $Item->getLink() . '", "", "' . $Item->getDescricao() . '"]';
            $sep = ',';
        }

//         ["http://i29.tinypic.com/xp3hns.jpg", "http://en.wikipedia.org/wiki/Cave", "_new", "Some day I'd like to explore these caves!"],

        return $ret;
    }

    /**
     * Retorna uma lista de caminhos para os arquivos
     * 
     * @param integer $id_owner id do dono dos aqruivos
     * @param integer $qtd quantidade de arquivos a serem retornados
     * @return array
     */
    public static function getNomeArquivos($id_owner, $qtd = 0) {
        $lImagens = new Arquivo();
        $lImagens->where('id_owner', $id_owner);
        $lImagens->sortOrder('principal', 'desc');
        if ($qtd > 0) {
            $lImagens->limit($qtd, 0);
        }
        $lImagens->readLst();

//        print'<pre>';die(print_r(  $lImagens));

        $ret = array();
        for ($i = 0; $i < $lImagens->countItens(); $i++) {
            $Item = $lImagens->getItem($i);
            $ret[] = HTTP_REFERER . 'Public/Arquivos/' . $Item->getid() . '.' . $Item->getExt();
        }
        return $ret;
    }

}
