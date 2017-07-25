<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		 system
 * @subpackage	system.application.models
 * @version		1.0
 */
class Mensagem extends Db_Table {

    protected $_name = 'mensagem';
    public $_primary = 'id_mensagem';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_datacadastro = date('d/m/Y H:i:s');
    }

    public function getAssuntoComResumo() {
        $nova = $this->getNovaMsgByUsuarioLogado();
        if ($nova) {
            $i = '<strong>';
            $f = '</strong>';
        }
        return $i . $this->getAssunto() . $f . '<br><small style="color:#ccc">' . substr(strip_tags($this->getMensagem()), 0, 60) . '</small>';
    }

    public function getNomeRemetente() {
        if ($this->getid_remetente() != '0') {
            return Usuario::getUsuarioList($this->getid_remetente());
        }
    }

    public function getNovaMsgByUsuarioLogado() {
        $m = new MensagemDestinatario();
        $m->where('id_usuario', Usuario::getIdUsuarioLogado());
        $m->where('id_mensagem', $this->getID());
        $m->where('visualizada', 'N');
        return ($m->count() > 0) ? true : false;
    }

    public function getLabelNovaMensagem() {
        $nova = $this->getNovaMsgByUsuarioLogado();
        if ($nova) {
//            return '<span class="label label-warning">!</span> <i style="color:#f0ad4e" class="fa fa-envelope-o fa-fw"></i>';
            return '<i style="color:#f0ad4e" class="fa fa-envelope-o fa-fw"></i>';
        } else {
            return '<i class="fa fa-envelope-open-o fa-fw"></i>';
        }
    }

    public function setVisualizada($idUsuario) {
        $m = new MensagemDestinatario();
        $m->where('id_usuario', $idUsuario);
        $m->where('id_mensagem', $this->getID());
        $m->where('visualizada', 'N');
        $m->readLst();
        if ($m->countItens() > 0) {
            $m = $m->getItem(0);
            $m->setVisualizada('S');
            $m->setDataVisualizacao(date('d/m/Y H:i:s'));
            $m->save();
        }
    }

    public function getListaVisualizacoes() {
        $m = new MensagemDestinatario();
        $m->where('id_mensagem', $this->getID());
//        $m->where('visualizada', 'S');
        $m->sortOrder('datavisualizacao', 'asc');
        $m->readLst();
        for ($i = 0; $i < $m->countItens(); $i++) {
            $Item = $m->getItem($i);
//            list($nome) = explode(' ', trim($Item->getNomeUsuario()));
//            $nome = strtok($Item->getNomeUsuario(), " ");
            if ($Item->getVisualizada() == 'S') {
                $t[] = '<strong>' . strtok($Item->getNomeUsuario(), " ") . '</strong> em ' . $Item->getDataVisualizacao();
            } else {
//                $n[] = '<strong>' . strtok($Item->getNomeUsuario(), " ") . '</strong>';
                $n[] = '' . strtok($Item->getNomeUsuario(), " ") . '';
            }
        }
        $ret = '';
        if (count($t) > 0) {
            $ret .= ' Visualizações:(' . count($t) . ' de ' . $m->countItens() . ' )<br>';
            $ret .= implode('<br>', $t);
        }
        if (count($n)) {
            $ret .= '<br><br><strong>Não visualizados:</strong><br>';
            $ret .= implode('<br>', $n);
        }
        return $ret;
    }

    public function getUsuarioTemAcesso($idUsuario) {
        $m = new MensagemDestinatario();
        $m->where('id_mensagem', $this->getID());
        $m->where('id_usuario', $idUsuario);
//        $m->readLst();
        if ($m->count() > 0) {
            return true;
        }
        return false;
    }

    public function getCategoriaDesc() {
        if ($this->getCategoria() != '') {
            return $this->getCategoriaList($this->getCategoria());
        } else {
            return '';
        }
    }

    public static function getCategoriaList($i = '') {
        $list[''] = ' - ';
        $list['1'] = 'Verba Salarial';
        $list['2'] = 'Verba Indenizatoria';
        $list['3'] = 'Correção Monetária, Descontos e Juros';
        $list['4'] = 'Conclusão';
        if ($i != '') {
            return $list[$i];
        }
        return $list;
    }

    public function getDestinatarioLst() {
        $lLst = $this->getMensagemDestinatarioLst();
        if ($lLst->countItens() > 0) {
            for ($i = 0; $i < $lLst->countItens(); $i++) {
                $User = $lLst->getItem($i);
                $list[] = $User->getID_usuario();
            }
        }
        return $list;
    }

    public function enviaPorEmail() {
        $lLst = $this->getMensagemDestinatarioLst();
        $emails = array();
        if ($lLst->countItens() > 0) {
            for ($i = 0; $i < $lLst->countItens(); $i++) {
                $dest = $lLst->getItem($i);
                $id = $dest->getID_usuario();
                $user = new Usuario();
                $user->read($id);
//                print'<pre>';die(print_r( $user->limpaObjeto() ));
                if ($user->getrecebecomunicacaointerna() == 'S' and $user->getEmail() != '') {
//                    $emails[$user->getNomeCompleto()] = $user->getEmail();
                    $emails[] = $user->getEmail();
//                    print'<pre>';die(print_r( $emails ));
                }
            }
        }

        if (count($emails) > 0) {
            $this->listaEmailDestinatarios = $emails;
            $message = $this->getMensagem();
            $message .= '<p>Você pode acessar essa mensagem no system Sinigaglia através do link: ' . HTTP_REFERER . 'mensagem/view/id/' . $this->getID() . ' </p>';
            $subject = $this->getAssunto();
            $enviaEmail = new SendEmail();

            return $enviaEmail->sendEmailComunicacaoInterna($message, $subject, $emails); //, $emailFrom, $nameFrom);
        }
        return 'Nenhum destinatário receberá email, pois nenhum deles está configurado para receber.';
    }

    public function getMensagemDestinatarioLst() {
        if (!$this->MensagemDestinatarioLst) {
            $this->MensagemDestinatarioLst = new MensagemDestinatario();
        }
        return $this->MensagemDestinatarioLst;
    }

    public function setMensagemDestinatarioLst($val) {
        $this->MensagemDestinatarioLst = $val;
    }

    function read($id = null, $modo = 'obj') {
        parent::read($id, $modo);

        $itemLst = new MensagemDestinatario();
        $itemLst->where('id_mensagem', $this->getID());
        $itemLst->readLst();
        $this->setMensagemDestinatarioLst($itemLst);
        return $this;
    }

    function save() {

        switch ($this->getState()) {

            case cDELETE:

                $lLst = $this->getMensagemDestinatarioLst();
                if ($lLst->countItens() > 0) {
                    for ($i = 0; $i < $lLst->countItens(); $i++) {
                        $Item = $lLst->getItem($i);
                        $Item->setDeleted();
                    }
                    $lLst->save();
                }

                parent::save();
                break;

            case cCREATE:
            case cUPDATE:


                parent::save();

                $lCartaoLst = $this->getMensagemDestinatarioLst();
                if ($lCartaoLst->countItens() > 0) {
                    for ($i = 0; $i < $lCartaoLst->countItens(); $i++) {
                        $Item = $lCartaoLst->getItem($i);
                        $Item->setid_mensagem($this->getID());
                        $Item->save();
                    }
                }

                break;
        }
        return $this;
    }

    public function setDataFromRequest($post) {
//        $this->setDataCadastro($post->DataCadastro);
//        $this->setDataCadastro($post->DataCadastro);
        $this->setAssunto($post->Assunto);
        $this->setMensagem($post->getUnescaped('Mensagem'));
    }

}
