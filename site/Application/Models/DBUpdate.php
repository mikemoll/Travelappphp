<?php

/**
 * Modelo da classe Mensagem
 * @filesource
 * @author 		Leonardo Daneili
 * @copyright 	Leonardo Danieli
 * @package		sistema
 * @subpackage	sistema.apllication.models
 * @version		1.0
 */
class DBUpdate extends Db_Table {

    protected $_name = 'dbupdate';
    public $_primary = 'id_dbupdate';

    function __construct($config = array(), $definition = null) {
        parent::__construct($config, $definition);
        $this->sqlFolder = RAIZ_DIRETORY . 'res/db_updates';
    }

    public function getFileList() {
        $dir = $this->sqlFolder;
        $files2 = scandir($dir, 1);
        $files2 = array_diff($files2, array('..', '.'));

        foreach ($files2 as $value) {
            $fileTime = filemtime($this->sqlFolder . '/' . $value);
            $item['filename'] = $value;
            $item['date'] = date('d/m/Y H:i', $fileTime);
            $item['filetime'] = $fileTime;
            $ret[] = $item;
        }

        return $ret;
    }

    public function createFile() {

        $my_file = $this->sqlFolder . '/' . $this->filename;
        $handle = fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
        $data = $this->content;
        fwrite($handle, $data);
        fclose($handle);
    }

    public function save() {
        parent::save();
    }

    public function read($id = NULL, $modo = 'obj') {

        parent::read(1);


        $fileLst = $this->getFileList();
        $this->filename = $fileLst[$id]['filename'];
        $this->filetime = $fileLst[$id]['filetime'];
        $content = file_get_contents($this->sqlFolder . "/" . $fileLst[$id]['filename']);
        $this->content = $content;
        $this->date = $fileLst[$id]['date'];
    }

    public function readLst($modo = 'obj') {

        parent::read(1);

        $fileLst = $this->getFileList();

        foreach ($fileLst as $key => $file) {
            $item = new DBUpdate();
            $item->filename = $file['filename'];
            $item->filetime = $file['filetime'];
            $item->a_updatedon = $this->a_updatedon;
            $item->date = $file['date'];
            $this->add($item);
        }
//        print'<pre>';
//        die(print_r($this->limpaObjeto()));
    }

    public function getisnew() {
        if ($this->getfiletime() > $this->getUpdatedOn()) {
            return ' <span class="badge badge-warning">New!</span>';
        }
    }

    public function getfilename() {
        return $this->filename;
    }

    public function getfiletime() {
        return $this->filetime;
    }

    public function getcontent() {
        return $this->content;
    }

    public function getdate() {
        return $this->date;
    }

    public function setDataFromRequest($post) {
        $this->filename = $post->filename;
        $this->content = $post->content;
    }

}
