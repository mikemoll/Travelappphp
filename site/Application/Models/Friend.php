<?php

/**
 * Modelo da classe Friend
 * @filesource
 * @author      Leonardo
 * @copyright   Leonardo
 * @package     sistema
 * @subpackage  sistema.apllication.models
 * @version     1.0
 */
class Friend extends Db_Table {

    protected $_name = 'friend';
    public $_primary = array('id_friend', 'id_usuario');

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
    }

    function readLst($modo = 'obj') {
        $this->join('usuario', 'usuario.id_usuario = friend.id_friend', 'friend.accepted_at, usuario.nomecompleto , usuario.lastname, usuario.Photo as photo, usuario.bio');
        parent::readLst($modo);
    }

    public static function getFriendsLst($id) {

        $friendslist = new Friend();
        $friendslist->where('friend.id_usuario', $id);
        $friendslist->sortOrder('nomecompleto','asc');
        $friendslist->readLst();

        $list= array();
        for ($i = 0; $i < $friendslist->countItens(); $i++) {

            $friend = $friendslist->getItem($i);

            $id             = $friend->getid_friend();
            $name           = $friend->getnomecompleto().' '.$friend->getlastname();
            $firstletter    = substr($name,0,1);
            $email          = $friend->getemail();
            $accepted_at    = $friend->getaccepted_at();
            $photo          = $friend->getphoto();

            if ($accepted_at == NULL) {
                if ($email == NULL) {
                    $status = '<i>Waiting to accept friendship...</i>';
                } else  {
                    $status = '<i>Waiting to create an account...</i>';
                }
            } else {
                $status = $friend->getbio();
                if (strlen($status) > 35) {
                    $status = substr($status, 0, 30).'...';
                }

            }
            $friend_array['status'] = $status;
            $friend_array['name'] = $name;
            $friend_array['Photo'] = Usuario::makephotoPath($id,$photo);

            $list[$firstletter][$friend->getid_friend()] = $friend_array;
        }
        return $list;

    }

}
