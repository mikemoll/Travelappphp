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
//            print'<pre>';
//            die(print_r("$fileTime > " . time()));

            $item['date'] = date('d/m/Y H:i:s', $fileTime);
            $item['filetime'] = $fileTime;
            if ($fileTime > $this->getUpdatedOn()) {
                $item['isnew'] = ' <span class="badge badge-warning">New!</span>';
            }
            $content = file_get_contents($this->sqlFolder . "/$value");
            $item['content'] = $content;
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
        $this->content = $fileLst[$id]['content'];
        $this->date = $fileLst[$id]['date'];
    }

    public function setDataFromRequest($post) {
        $this->filename = $post->filename;
        $this->content = $post->content;
    }

}
