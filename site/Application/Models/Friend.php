<?php

/**
 * Modelo da classe Friend
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     system
 * @subpackage  system.application.models
 * @version     1.0
 */
class Friend extends Db_Table {

    protected $_name = 'friend';
    public $_primary = array('id_friend');

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function readLst($modo = 'obj', $onlyregistered = false) {
        if ($onlyregistered) {
            $this->join('usuario', 'usuario.id_usuario = friend.id_usuario_friend', 'friend.accepted_at, usuario.nomecompleto , usuario.lastname, usuario.Photo as photo, usuario.bio, friend.name ');
        } else {
            $this->join('usuario', 'usuario.id_usuario = friend.id_usuario_friend', 'friend.accepted_at, usuario.nomecompleto , usuario.lastname, usuario.Photo as photo, usuario.bio, friend.name ', 'left');
        }
        parent::readLst($modo);
    }

///think in a way to order by uusuraio name, if don't have, order by friend.name

    public static function getFriendsLst($id, $onlyregistered = false) {

        $friendslist = new Friend();
        $friendslist->where('friend.id_usuario', $id);
        $friendslist->sortOrder('nomecompleto', 'asc');
        $friendslist->readLst('obj', $onlyregistered);

        $list = array();
        for ($i = 0; $i < $friendslist->countItens(); $i++) {

            $friend = $friendslist->getItem($i);

            $id = $friend->getid_usuario_friend();
            $email = $friend->getemail();
            $accepted_at = $friend->getaccepted_at();
            $photo = $friend->getphoto();

            if ($id == NULL) {
                $status = '<i>Waiting to create an account...</i>';
                $friend_array['isfriend'] = 'N';
                $name = $friend->getname();
            } else if ($accepted_at == NULL) {
                $status = '<i>Waiting to accept friendship...</i>';
                $friend_array['isfriend'] = 'N';
                $name = $friend->getnomecompleto() . ' ' . $friend->getlastname();
            } else {
                $status = $friend->getbio();
                if (strlen($status) > 35) {
                    $status = substr($status, 0, 30) . '...';
                }
                $friend_array['isfriend'] = 'S';
                $name = $friend->getnomecompleto() . ' ' . $friend->getlastname();
            }
            $firstletter = substr($name, 0, 1);

            $friend_array['id_usuario_friend'] = $id;
            $friend_array['status'] = $status;
            $friend_array['name'] = $name;
            $friend_array['Photo'] = Usuario::makephotoPath($id, $photo);

            $list[$firstletter][$friend->getid_friend()] = $friend_array;
        }

        return $list;
    }

}
