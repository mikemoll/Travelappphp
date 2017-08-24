<?php

/**
 * Model for the class Chat
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Chatmsg extends Db_Table {

    protected $_name = 'chatmsg';
    public $_primary = 'id_chatmsg';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->a_sentdate = date('m/d/Y H:i:s');
    }

    function getFullConversation() {
        $msgLst = $this->getItens();
        foreach ($msgLst as $msg) {
            if ($msg->getid_usuario() == Usuario::getIdUsuarioLogado()) {
                // MY MESSAGES
                $txt = ' <div class="message clearfix">
                    <div  title=" ' . $msg->getsentdate() . '" class="chat-bubble from-me">
                        ' . $msg->getMessage() . '
                    </div>
                </div>';
            } else {
                // === their message =====
                if ($previousUser != $msg->getid_usuario()) {
                    $name = "<strong>{$msg->getUserName()}</strong><br>";
                    $marging = "m-t-15";
                } else {
                    $marging = "";
                    $name = '';
                }
                $txt = '<div class="message clearfix ' . $marging . '">';
                $txt .= '<div class="profile-img-wrapper  inline">';
                if ($name != '') {
                    $txt .= '<img class="col-top" width="30" height="30" src="' . Usuario::makephotoPath($msg->getid_usuario(), $msg->getPhoto()) . '" alt="" data-src="' . Usuario::makephotoPath($msg->getid_usuario(), $msg->getPhoto()) . '" data-src-retina="' . Usuario::makephotoPath($msg->getid_usuario(), $msg->getPhoto()) . '">';
                }
                $txt .= '</div>';
                $txt .= '     <div title=" ' . $msg->getsentdate() . '" class="chat-bubble from-them">
                        ' . $name . $msg->getMessage() . '
                    </div>
                </div>';
//                $txt = '<div class="message clearfix ' . $marging . '">
//                    <div class="profile-img-wrapper  inline">
//                        <img class="col-top" width="30" height="30" src="' . Usuario::makephotoPath($msg->getid_usuario(), $msg->getPhoto()) . '" alt="" data-src="{$baseUrl}Public/assets/img/profiles/avatar_small.jpg" data-src-retina="{$baseUrl}Public/assets/img/profiles/avatar_small2x.jpg">
//                    </div>
//                    <div title=" ' . $msg->getsentdate() . '" class="chat-bubble from-them">
//                        ' . $name . $msg->getMessage() . '
//                    </div>
//                </div>';
            }
            $previousUser = $msg->getid_usuario();
            $ret .= $txt;
        }
        return $ret;
    }

    function readLst($modo = 'obj') {
        $this->join('usuario', 'usuario.id_usuario = chatmsg.id_usuario', 'nomecompleto as username,photo', 'left');
        parent::readLst($modo);
    }

}
