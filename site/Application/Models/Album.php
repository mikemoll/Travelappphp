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
class Album extends Db_Table {
	protected $_name = 'album';
	public $_primary = 'id_album';
	public $_log_ativo = true;

	public function setDataFromRequest($post) {
		$this->setTitulo($post->titulo);
		$this->setDescricao($post->descricao);
//		$this->setOrdem($post->ordem);
		$this->setAtivo($post->ativo);
	}

	public static function montaAlbum($todos = '', $returnArray = false){
		$view = Zend_Registry::get('view');

		$album = '';

		$albuns = new Album;

		if($todos == ''){
			$albuns->addFilter('ativo', 'S');
		}
		Session_Control::setDataSession('mostraTodosAlbuns', $todos);

		$albuns->addSortOrder('ordem');
		$albuns->readLst();

		for($i = 0; $i < $albuns->countItens(); $i++){
			$item = $albuns->getItem($i);

			$arquivo = new Arquivo();
			$arquivo->where('id_owner', $item->a_id_album);
//			$arquivo->where('principal', 'S');
			$arquivo->readLst();
			$album[$i]['id'] = $item->getid();
			$album[$i]['titulo'] = $item->getTitulo();
			$album[$i]['descricao'] = $item->getDescricao();
			if($arquivo->countItens() != 0){
				$album[$i]['imagem'] = PATH_PUBLIC.'Arquivos/'.$arquivo->getItem(0)->getid().'.'.$arquivo->getItem(0)->getExt();
			}else{
				$album[$i]['imagem'] = PATH_PUBLIC.'Arquivos/Default.png';
			}
		}
		$view->assign('editar', Usuario::verificaAcesso('PROC_CAD_ARQUIVOS', 'editar'));
		$view->assign('excluir', Usuario::verificaAcesso('PROC_CAD_ARQUIVOS', 'excluir'));
		$view->assign('albuns', $album);
		if(!$returnArray){
			return $view->fetch('Albuns/albuns.tpl');
		}
		else
			return $album;
	}
        function getImagem() {
            $arquivos = Arquivo::getNomeArquivos($this->getID(),1);
            return $arquivos[0];
        }

}